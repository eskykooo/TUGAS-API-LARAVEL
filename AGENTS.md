# AGENTS.md — Tugas_API

## Tech stack
- Laravel 10, PHP 8.1+, MySQL, Sanctum (token auth), Laravel Pint (code style)
- Locale: `id` (Indonesian). API response messages are in Indonesian.

## Key commands
```bash
# Serve
php artisan serve

# Tests (DB not configured for testing — see phpunit.xml: DB env is commented out)
php artisan test
# Single test: php artisan test --filter=ClassName::testMethod

# Code style
./vendor/bin/pint

# Database
php artisan migrate
php artisan db:seed
```

## Architecture

### Dual interface
| Layer | Routes | Auth |
|-------|--------|------|
| **API** | `routes/api.php` → `App\Http\Controllers\Api\*` | Sanctum (`auth:sanctum`) |
| **Web** | `routes/web.php` → `App\Http\Controllers\Web\*` | Laravel session (`auth`) |

### API entrypoint
`routes/api.php` — public endpoints + protected (Sanctum) + admin-only (`auth:sanctum,admin`).

### Admin middleware
Custom `AdminMiddleware` checks `$user->isAdmin()` (role === 'admin'). Registered as alias `'admin'` in `Kernel.php`.

### Response format
All API controllers use `ApiResponseTrait`:
```json
{ "success": true, "message": "...", "data": ..., "meta": { "current_page": 1, ... } }
{ "success": false, "message": "...", "errors": ... }
```

### Models & relationships
- `Article` — `belongsTo` Category, User; `belongsToMany` Tag (pivot `article_tags`); `hasMany` Comment
- `User` — `HasApiTokens` (Sanctum), `hasMany` Article, Comment; `isAdmin()` checks role
- Comments have status: `pending` | `approved` | `rejected`

### Seed data
| Email | Password | Role |
|-------|----------|------|
| admin@blog.com | password | admin |
| editor1@blog.com | password | editor |
| editor2@blog.com | password | editor |

Run `php artisan db:seed` to populate.

## Testing quirks
- phpunit.xml has `DB_CONNECTION` and `DB_DATABASE` commented out — tests will hit real MySQL DB unless uncommented for SQLite/:memory:
- `RefreshDatabase` trait is not imported in the example test
- Tests live in `tests/Feature/` and `tests/Unit/`

## Request validation
Uses Form Request classes (`StoreArticleRequest`, `StoreCommentRequest`, `RegisterRequest`) for store endpoints. `authorize()` returns `true` (auth gate handled at route level).

## Conventions
- Controller methods return `JsonResponse` typed
- Slug auto-generated: `Str::slug($title) . '-' . Str::random(5)`
- Publishing an article sets `published_at = now()`
- Tags sync on update, attach on create
- Article owner or admin can update/delete articles
- Comment owner or admin can delete; only comment owner can update (resets status to pending)
