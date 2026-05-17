# AGENTS.md — Tugas_API

## Tech stack
- **Laravel 10**, PHP 8.1+, MySQL, Sanctum (token auth), Laravel Pint (code style)
- Locale: `id` (Indonesian). All API response messages are in Indonesian.

## Key commands
```bash
# Initial setup (after clone)
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

# Serve
php artisan serve

# Tests (hits real MySQL — see Testing quirks)
php artisan test
php artisan test --filter=ClassName::testMethod

# Code style
./vendor/bin/pint

# Database
php artisan migrate:fresh --seed   # reset + reseed
```

## Architecture

### Dual interface
| Layer | Routes | Auth |
|-------|--------|------|
| **API** | `routes/api.php` → `App\Http\Controllers\Api\*` | Sanctum (`auth:sanctum`) |
| **Web** | `routes/web.php` → `App\Http\Controllers\Web\*` | Laravel session (`auth`) |

### API entrypoint
`routes/api.php` — public endpoints + protected (Sanctum) + admin-only (`auth:sanctum,admin`).  
Note: protected groups are defined BEFORE public routes in the file (valid in Laravel).

### Admin middleware
Custom `AdminMiddleware` checks `$user->isAdmin()` (role === `'admin'`). Registered as alias `'admin'` in `Kernel.php`.

### Response format
All API controllers use `ApiResponseTrait`:
```json
{ "success": true, "message": "...", "data": ..., "meta": { "current_page": 1, ... } }
{ "success": false, "message": "...", "errors": ... }
```

### Models & relationships
- `Article` — `belongsTo` Category, User; `belongsToMany` Tag (pivot `article_tags`); `hasMany` Comment. Status: `draft`|`published`|`archived`
- `User` — `HasApiTokens` (Sanctum), `hasMany` Article, Comment; `isAdmin()` checks `role === 'admin'`
- `Comment` — `belongsTo` Article, User. Status: `pending`|`approved`|`rejected`

### Seed data
| Email | Password | Role |
|-------|----------|------|
| admin@blog.com | password | admin |
| editor1@blog.com | password | editor |
| editor2@blog.com | password | editor |

Plus 5 random users via `User::factory(5)->create()`.

## Web layer
- Public: homepage, article detail, category listing, search (`routes/web.php`)
- Protected (`auth`): dashboard for article CRUD + comment creation (`DashboardController`)
- No web auth endpoints — authentication is API-only (Sanctum tokens)

## Testing quirks
- `phpunit.xml` has `DB_CONNECTION` and `DB_DATABASE` commented out — tests will hit real MySQL DB unless uncommented for SQLite/:memory:
- `RefreshDatabase` trait is not imported in the example test
- Tests live in `tests/Feature/` and `tests/Unit/`

## Request validation
- Uses Form Request classes (`StoreArticleRequest`, `StoreCommentRequest`, `RegisterRequest`) for store/update endpoints
- `CommentController::update` uses inline `$request->validate(...)` instead of a Form Request
- `authorize()` returns `true` (auth gate handled at route level)

## Conventions
- Controller methods return `JsonResponse` typed
- Slug: `Str::slug($title) . '-' . Str::random(5)` (auto-generated, not user-supplied)
- Publishing an article sets `published_at = now()`
- Tags: `attach()` on create, `sync()` on update
- Article owner or admin can update/delete/publish articles
- Comment owner can update (resets status to `pending`); owner or admin can delete
- Admin-only endpoints: `GET /admin/comments`, `PUT /admin/comments/{id}/approve`
