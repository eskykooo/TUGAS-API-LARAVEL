# AGENTS.md — Tugas_API (Nexus Gaming)

## Stack
Laravel 10, PHP 8.1+, MySQL, Sanctum (token auth), Pint (code style).  
Frontend: Tailwind CSS (CDN), Alpine.js 3.x, AOS, Font Awesome 6.5, Trix (dashboard only), Cropper.js (profile only), Google Fonts (Orbitron + Inter).  
Locale `id`, dark-only theme (`#0A0A0A` bg), neo-brutalism (thick borders, hard shadows, solid colors, no glass/blur).  
Palette: `#FF6B35` (brutal-orange), `#FF1744` (brutal-red), `#FFD600` (brutal-yellow), `#00E676` (brutal-green), `#3B82F6` (brutal-blue), `#A855F7` (brutal-purple).

## Commands
| Command | Purpose |
|---------|---------|
| `php artisan serve` | Dev server |
| `php artisan test` | Runs tests (hits real MySQL — `DB_CONNECTION`/`DB_DATABASE` commented out in phpunit.xml) |
| `php artisan test --filter=ClassName::testMethod` | Single test |
| `./vendor/bin/pint` | Fix code style |
| `php artisan migrate:fresh --seed` | Reset DB + seed |
| `php artisan optimize:clear` | Clear all cache (incl. rate limiter counters) |
| `php artisan db:seed --class=XSeeder` | Seed single class |

## Routes
- **API** (`routes/api.php`): Public routes FIRST, protected `auth:sanctum` group, then admin `auth:sanctum + admin` — Laravel requirement.
- **Web** (`routes/web.php`): Public routes, `auth` group (dashboard, profile, comments), `admin` middleware group (`/admin/*`).
- **Auth** (`routes/auth.php`): Login/register/logout routes (separated per Laravel convention).
- Search at `/search` — throttled 30/1min. No `/home` prefix.

## Architecture
- **Dual interface:** API (Sanctum tokens) + Web (session). Web Auth routes in `routes/auth.php`.
- **Admin middleware** (`'admin'` alias in `Kernel.php`): checks `$user->isAdmin()`, logs via `Log::warning`, returns JSON 403 (no web redirect).
- **API response format:** `ApiResponseTrait` — `{ success, message, data, meta? }` success, `{ success, message, errors? }` error.
- **DashboardController** doubles as user article CRUD + comment submission. Admin redirected to `/admin` on dashboard index, 403 on CRUD.

## Models
- **Article** — status DB enum: `draft`,`published`,`archived`,`pending`. User creates → `pending` → Admin approves → `published`. Only `published` shown publicly. Slug: `Str::slug($title).'-'.Str::random(5)`. Thumbnail URL via `getThumbnailUrlAttribute()`. Content sanitized on read via `getSafeContentAttribute()`.
- **User** — `HasApiTokens`, `isAdmin()` checks `role === 'admin'` (enum: `admin`|`editor`|`author`, default `author`). `avatarUrl()` fallback to `ui-avatars.com` with orange bg.
- **Comment** — status: `pending`|`approved`|`rejected`. Admin paginates 20/page.

## Seed accounts (all password: `password`)
| Email | Role |
|-------|------|
| admin@blog.com | admin |
| 7 factory users | user |

## Conventions
- **Admin** manages articles (view/approve/delete) via `/admin/*`. Admin **cannot** create/edit — `DashboardController` returns 403.
- **Tags:** `attach()` on create, `sync()` on update.
- **Ownership:** Article owner can update/delete/publish. Comment owner can update (resets to `pending`); owner or admin can delete.
- **View count:** Increments per visit, no dedup.
- **Profile:** Two pages — `/profile` (name, email, avatar via Cropper.js, base64 → WebP quality 80) and `/profile/security` (password with `current_password`).
- **Newsletter:** Client-side only (Alpine.js, no backend).

## Category color maps — synced across 3 files
Category badge colors are defined independently in 3 Blade files. When adding/modifying a category, update ALL THREE:
1. `resources/views/categories/index.blade.php` — `$catMeta` array (icon + bg color)
2. `resources/views/components/category-badge.blade.php` — `$colors` array (border + text color)
3. `resources/views/components/article-card.blade.php` — `$catColors` array (border + text color)

Slug keys must match `CategorySeeder.php` exactly (currently: `pc-gaming`, `console`, `mobile`, `esports`, `gaming-news`, `reviews`, `guides`).

## Security
- **SecurityHeadersMiddleware** (global): HSTS 1yr preload, restrictive CSP with CDN allowances, locked-down Permissions-Policy.
- **CORS:** `allowed_origins` from `CORS_ALLOWED_ORIGINS` env (fallback `APP_URL`), no wildcard. `supports_credentials: false`.
- **Rate limiting:** Login 20/min, register 10/60min, article CRUD 10/60min, comment 5/1min, profile update 5/1min, search 30/1min (web + API). API group has global throttle.
- **Anti-spam:** Honeypot (`website`) on register/login/comment — silently rejected. Duplicate comment detection (same user+content+article within 5min). HTML stripped, max 2000 chars.
- **Login:** Generic message (`"Email atau kata sandi salah"`), no email enumeration.
- **Password:** `min:8|confirmed`, no uppercase/number requirement.
- **Sanctum tokens:** Expire per `SANCTUM_TOKEN_EXPIRATION` env (default 1440 min).
- **Session:** `lifetime = 300` (5 hours, via env `SESSION_LIFETIME`), `expire_on_close = true`, `encrypt = true`, `http_only = true`, `same_site = lax`.
- **XSS:** `HtmlSanitizer` whitelists tags + blocks dangerous protocols on `href`/`src`. Alpine `x-data` uses `@json()`. All user text via Blade `{{ }}`. Article content max 100000 chars.
- **Image upload:** Max 5MB, auto-converted to WebP via `App\Helpers\ImageHelper` (thumbnails) or inline GD (avatar base64). Validation uses Laravel `image` rule (real MIME via finfo).
- **SQL injection:** LIKE queries escape `%` and `_` via `str_replace`. All other queries use Eloquent parameterized binding.

## CDN caveat
`cdn.tailwindcss.com` and Google Fonts don't serve CORS headers — **never add `crossorigin`** to their `<script>`/`<link>` tags.
