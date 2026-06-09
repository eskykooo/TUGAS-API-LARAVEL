# AGENTS.md — Tugas_API (Nexus Gaming)

## Stack
Laravel 10, PHP 8.1+, MySQL, Sanctum (token auth), Pint (code style).  
Frontend: Tailwind CSS (CDN), Alpine.js 3.x, AOS, Font Awesome 6.5, Trix (dashboard only), Cropper.js (profile only), Google Fonts (Orbitron + Inter).  
Locale `id`, dark-only theme (`#0A0A0A` bg), neo-brutalism style (thick borders, hard shadows, solid colors, no glass/blur/gradients).  
Palette: `#FF6B35` (brutal-orange), `#FF1744` (brutal-red), `#FFD600` (brutal-yellow), `#00E676` (brutal-green).

## Commands
| Command | Purpose |
|---------|---------|
| `php artisan serve` | Dev server |
| `php artisan test` | Runs tests (hits real MySQL — `DB_CONNECTION`/`DB_DATABASE` commented out in phpunit.xml) |
| `php artisan test --filter=ClassName::testMethod` | Single test |
| `./vendor/bin/pint` | Fix code style |
| `php artisan migrate:fresh --seed` | Reset DB + seed |
| `php artisan optimize:clear` | Clear all cache (incl. rate limiter counters) |

## Architecture
- **Dual interface:** API (Sanctum tokens) + Web (session). API routes defined BEFORE public routes in `routes/api.php` — Laravel requirement.
- **Web routes:** `routes/web.php` (public + `auth` group). Auth routes in `routes/auth.php`.
- **Admin middleware** (`'admin'` alias in Kernel): checks `$user->isAdmin()` (`role === 'admin'`). Logs failed access via `Log::warning`. Returns JSON 403 for both API and web (no redirect).
- **API response format:** `ApiResponseTrait` — `{ success, message, data, meta? }` success, `{ success, message, errors? }` error.

## Models
- **Article** — status: `draft`|`pending`|`published` (DB enum: `draft`,`published`,`archived`,`pending`). User creates → `pending` → Admin approves → `published`. Only `published` shown on frontend & API. Slug auto-generated: `Str::slug($title).'-'.Str::random(5)`.
- **User** — `HasApiTokens`, `isAdmin()` checks `role === 'admin'` (enum: `admin`|`editor`|`author`, default `author`). `avatarUrl()` returns `Storage::url(avatar)` or `ui-avatars.com` fallback with orange bg. Avatar upload via ProfileController → WebP quality 80, stored in `avatars/`.
- **Comment** — status: `pending`|`approved`|`rejected`. Admin paginates 20/page.

## Seed accounts (all password: `password`)
| Email | Role |
|-------|------|
| admin@blog.com | admin |
| 7 factory users | user |

## Conventions
- **Admin** manages articles (view/approve/delete) via `/admin/*`. Admin **cannot** create/edit articles — `DashboardController` returns 403 on all CRUD methods for admin.
- **Users** create articles via `/dashboard/articles/*`. Choosing "published" sets status to `pending` automatically. Admin must approve.
- **Tags:** `attach()` on create, `sync()` on update.
- **Ownership:** Article owner can update/delete/publish (user). Comment owner can update (resets to `pending`); owner or admin can delete.
- **View count:** Increments per visit, no dedup.
- **Profile:** Two pages — `/profile` (name, email, avatar with Cropper.js) and `/profile/security` (password with `current_password` validation). Avatar sent as base64 data URL via hidden input, decoded server-side and converted to WebP.
- **Newsletter:** Client-side only (Alpine.js, no backend).

## Security
- **SecurityHeadersMiddleware** (global): HSTS 1yr preload, X-Frame-Options SAMEORIGIN, X-Content-Type-Options nosniff, X-XSS-Protection 1;mode=block, Referrer-Policy strict-origin-when-cross-origin, Content-Security-Policy (restrictive with CDN allowances), Permissions-Policy locked down.
- **CORS:** `allowed_origins` from `CORS_ALLOWED_ORIGINS` env (fallback `APP_URL`), no wildcard. `supports_credentials: false`.
- **Rate limiting:** Login 20/min, register 10/60min, article CRUD 10/60min, comment 5/1min, profile update 5/1min, search 30/1min (web + API). API group has global throttle.
- **Anti-spam:** Honeypot field (`website`) on register/login/comment forms — silently rejected if filled. Duplicate comment detection (same user+content+article within 5min). Comment content stripped of HTML, max 2000 chars.
- **Login messages:** Generic ("Email atau kata sandi salah") — no email enumeration.
- **Password:** `min:8|confirmed`, no uppercase/number requirement.
- **Sanctum tokens:** Expire per `SANCTUM_TOKEN_EXPIRATION` (default 1440 min).
- **Session:** `expire_on_close = true`, `encrypt = true`, `http_only = true`, `same_site = lax`.
- **XSS:** `HtmlSanitizer` whitelists tags (adds `h1`), blocks dangerous protocols (`javascript:`, `data:`, `vbscript:`, `blob:`, `file:`) on `href`/`src`, auto-adds `rel="noopener noreferrer"` on `target="_blank"`. `safe_content` accessor sanitizes on read (defense in depth). Alpine `x-data` uses `@json()`. Trix only on dashboard. All user text output via Blade `{{ }}` (auto-escaped). Comment content stripped via `strip_tags()`. Article content validated max 100000 chars, comment max 2000 chars.
- **Image upload:** Max 5MB, auto-converted to WebP (quality 80) via `App\Helpers\ImageHelper` (thumbnails) or inline GD (avatar base64). Validation uses Laravel `image` rule (checks real MIME via finfo).
- **SQL injection:** LIKE queries escape `%` and `_` via `str_replace`. All other queries use Eloquent parameterized binding.

## Design system
All classes defined in `resources/views/layouts/app.blade.php` (tailwind.config + `<style>` block):
- `.glass-card` — solid `#141414` bg, `2px solid #FF6B35` border, hard orange shadow on hover
- `.btn-primary`, `.btn-outline`, `.btn-danger`, `.btn-ghost` — thick borders, hard shadows, uppercase
- `.input-brutal`, `.select-brutal` — black bg, thick borders (`#1a1a1a`), orange focus
- `.tag-brutal` — black bg, orange border, uppercase
- Trix editor styled for dark brutalist look
- Tailwind config overrides `gray` scale: gray-300 `#cccccc`, gray-400 `#999999`, gray-500 `#888888`, gray-600 `#777777`, gray-700 `#666666`, gray-800 `#444444`
- All `text-gray-*` / `border-gray-*` / `bg-gray-*` use these overridden values, never Tailwind defaults
- Border color `dark-border` is `#1a1a1a` (in palette), referenced as `border-dark-border` / `bg-dark-border`

## CDN caveat
`cdn.tailwindcss.com` and Google Fonts don't serve CORS headers — **never add `crossorigin`** to their `<script>`/`<link>` tags.

## Testing
`phpunit.xml` has `DB_CONNECTION` and `DB_DATABASE` commented out — tests hit real MySQL. `RefreshDatabase` not imported.