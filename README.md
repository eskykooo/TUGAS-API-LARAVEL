![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![Tailwind](https://img.shields.io/badge/Tailwind-3-06B6D4)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1)
![Sanctum](https://img.shields.io/badge/Sanctum-Auth-orange)
![License](https://img.shields.io/badge/License-MIT-green)

# RIZQY - 2409116039 - A'2024

# 🎮 PROJEK UAS - WEBSITE BERITA GAMING (NEXUS GAMING)

**Nexus Gaming** adalah portal berita gaming Indonesia yang dibangun sebagai projek UAS. Website ini menyajikan berita dan artikel seputar dunia gaming — mulai dari PC gaming, console, mobile, esports, hingga review dan panduan.

Dikembangkan menggunakan **Laravel 10** dengan **REST API** dan **Web UI** (dual-interface), otentikasi **Sanctum**, serta desain dark mode khas gaming.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Database](#-struktur-database)
- [Instalasi & Menjalankan Projek](#-instalasi--menjalankan-projek)
- [Akun Demo](#-akun-demo)
- [Route Web (Frontend)](#-route-web-frontend)
- [Route API](#-route-api)
- [Penjelasan API](#-penjelasan-api)
- [Relasi Database](#-relasi-database)
- [Screenshot Halaman](#-screenshot-halaman)

---

## ✨ Fitur Utama

### Frontend Web
| Fitur | Keterangan |
|-------|-----------|
| Halaman Home | Menampilkan artikel terbaru, trending, kategori populer |
| Halaman Artikel | Detail artikel dengan reading progress bar, sidebar sticky, author info, share button |
| Halaman Author | Profil publik penulis dengan statistik dan daftar artikel |
| Kategori | Filter artikel berdasarkan kategori (PC Gaming, Console, Mobile, Esports, dll) |
| Pencarian | Pencarian artikel dengan filter tag dan author |
| Komentar Threaded | Komentar bertingkat dengan reply, reaksi (like/love/wow), role badge |
| Profil Pengguna | Edit profil, avatar (dengan Cropper.js), bio, dan keamanan password |
| Dashboard Penulis | CRUD artikel, manajemen komentar |
| Admin Panel | Manajemen artikel, komentar, kategori, tag, user, notifikasi, aktivitas |

### REST API
| Fitur | Keterangan |
|-------|-----------|
| Autentikasi | Register, login, logout via Sanctum token |
| CRUD Artikel | Create, read, update, delete artikel |
| Filter Artikel | Berdasarkan kategori, tag, author, pencarian |
| Kategori & Tag | Daftar dan filter artikel per kategori/tag |
| Komentar | Tambah, update, hapus komentar per artikel |
| Admin API | Approve komentar, lihat semua komentar |

### Keamanan
- Honeypot anti-spam pada form
- Rate limiting (login, register, komentar, pencarian)
- Session terenkripsi & HTTP-only
- HTML Sanitizer untuk konten artikel
- Anti duplicate comment (5 menit)
- LIKE query escape (SQL injection protection)
- Security headers (HSTS, CSP, Permissions-Policy)

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| Laravel | 10.x | Framework backend (MVC) |
| PHP | 8.1+ | Bahasa pemrograman |
| MySQL | 8.x | Database management |
| Laravel Sanctum | ^3 | Autentikasi API token |
| Tailwind CSS | 3.x (CDN) | Styling & layout |
| Alpine.js | 3.x (CDN) | Interaktivitas frontend |
| Font Awesome | 6.5 (CDN) | Ikon |
| AOS | 2.3.1 (CDN) | Animasi scroll |
| Trix | 1.3.1 (CDN) | Rich text editor (dashboard) |
| Cropper.js | 1.6.2 (CDN) | Crop avatar (profil) |
| Google Fonts | Inter + Orbitron | Tipografi |

---

## 🗄️ Struktur Database

### Entity Relationship Diagram (ERD)

```
┌─────────────┐       ┌──────────────────┐       ┌─────────────┐
│    users    │       │    articles      │       │  comments   │
├─────────────┤       ├──────────────────┤       ├─────────────┤
│ id (PK)     │◄──────│ user_id (FK)     │       │ id (PK)     │
│ name        │       │ id (PK)          │◄──────│ article_id  │
│ email       │       │ title            │       │ user_id (FK)│
│ password    │       │ slug             │       │ content     │
│ role        │       │ content          │       │ status      │
│ avatar      │       │ excerpt          │       │ parent_id   │
│ bio         │       │ thumbnail        │       │ reactions   │
│ created_at  │       │ status           │       │ created_at  │
└─────────────┘       │ category_id (FK) │       └─────────────┘
                      │ views            │
                      │ published_at     │       ┌─────────────┐
                      └────────┬─────────┘       │   tags      │
                               │                 ├─────────────┤
                      ┌────────▼─────────┐       │ id (PK)     │
                      │   categories     │       │ name        │
                      ├──────────────────┤       │ slug        │
                      │ id (PK)          │       └─────────────┘
                      │ name             │
                      │ slug             │       ┌──────────────────┐
                      │ description      │       │  article_tags    │
                      └──────────────────┘       ├──────────────────┤
                                                 │ article_id (FK)  │
                                                 │ tag_id (FK)      │
                                                 └──────────────────┘
```

### Tabel

| Tabel | Penjelasan | Kolom Kunci |
|-------|-----------|-------------|
| `users` | Data pengguna (admin, editor, author) | id, name, email, role (enum: admin/editor/author), avatar, bio |
| `categories` | Kategori artikel gaming | id, name, slug, description |
| `articles` | Artikel berita | id, title, slug, content, excerpt, thumbnail, status (enum: draft/pending/published/archived), category_id, user_id, views, published_at |
| `comments` | Komentar artikel (threaded) | id, article_id, user_id, content, status (enum: pending/approved/rejected), parent_id (untuk reply), reactions (JSON) |
| `tags` | Tag artikel | id, name, slug |
| `article_tags` | Pivot many-to-many artikel & tag | article_id, tag_id |

---

## 🚀 Instalasi & Menjalankan Projek

### Prasyarat
- PHP 8.1 atau lebih baru
- Composer
- MySQL / MariaDB
- Laragon / XAMPP (recommended)

### Langkah-langkah

```bash
# 1. Clone repositori
git clone https://github.com/eskykooo/TUGAS-API-LARAVEL.git
cd Tugas_API

# 2. Install dependency PHP
composer install

# 3. Buat file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Konfigurasi database di file .env
#    DB_DATABASE=Tugas_API
#    DB_USERNAME=root
#    DB_PASSWORD=

# 6. Buat database 'Tugas_API' di phpMyAdmin

# 7. Jalankan migrasi dan seeder
php artisan migrate:fresh --seed

# 8. Buat storage link (untuk upload gambar)
php artisan storage:link

# 9. Jalankan server
php artisan serve

# 10. Buka browser
#     http://localhost:8000
```

---

## 👤 Akun Demo

Setelah menjalankan `php artisan migrate:fresh --seed`, akun berikut tersedia:

| Email | Password | Role |
|-------|----------|------|
| `admin@blog.com` | `password` | **Admin** — akses penuh ke admin panel |
| `user1@example.com` | `password` | Author |
| `user2@example.com` - `user7@example.com` | `password` | Author |

Semua password: **`password`**

---

## 🌐 Route Web (Frontend)

### Public Routes

| Method | URL | Controller | Fungsi |
|--------|-----|-----------|--------|
| `GET` | `/` | HomeController@index | Beranda |
| `GET` | `/articles/{slug}` | ArticleController@show | Detail artikel |
| `GET` | `/authors/{id}` | AuthorController@show | Profil author publik |
| `GET` | `/categories` | CategoryController@index | Semua kategori |
| `GET` | `/categories/{slug}` | CategoryController@show | Artikel per kategori |
| `GET` | `/search` | SearchController@index | Pencarian |

### Auth Routes (perlu login)

| Method | URL | Controller | Fungsi |
|--------|-----|-----------|--------|
| `GET` | `/dashboard` | DashboardController@index | Dashboard penulis |
| `POST` | `/comments` | DashboardController@storeComment | Kirim komentar |
| `POST` | `/comments/{id}/react` | DashboardController@toggleReaction | Reaksi komentar |
| `GET` | `/profile` | ProfileController@edit | Edit profil |
| `PUT` | `/profile` | ProfileController@update | Update profil |
| `GET` | `/profile/security` | ProfileController@editSecurity | Keamanan password |
| `PUT` | `/profile/security` | ProfileController@updateSecurity | Update password |

### Admin Routes (`/admin/*`)

| Method | URL | Fungsi |
|--------|-----|--------|
| `GET` | `/admin` | Dashboard admin |
| `GET` | `/admin/articles` | Manajemen artikel |
| `PUT` | `/admin/articles/{id}/approve` | Approve artikel |
| `DELETE` | `/admin/articles/{id}/delete` | Hapus artikel |
| `GET` | `/admin/comments` | Manajemen komentar |
| `PUT` | `/admin/comments/{id}/approve` | Approve komentar |
| `PUT` | `/admin/comments/{id}/reject` | Reject komentar |
| `DELETE` | `/admin/comments/{id}/delete` | Hapus komentar |
| `GET` | `/admin/categories` | Manajemen kategori |
| `GET` | `/admin/tags` | Manajemen tag |
| `GET` | `/admin/users` | Manajemen user |
| `GET` | `/admin/notifications` | Notifikasi |
| `GET` | `/admin/activity` | Log aktivitas |
| `GET` | `/admin/settings` | Pengaturan |
| `GET` | `/admin/security` | Keamanan admin |

### Auth Routes (Login/Register)

| Method | URL | Fungsi |
|--------|-----|--------|
| `GET/POST` | `/login` | Login |
| `GET/POST` | `/register` | Register |
| `POST` | `/logout` | Logout |

---

## 📡 Route API

Semua response API menggunakan format JSON seragam:
```json
{
    "success": true/false,
    "message": "...",
    "data": ...,
    "meta": { ... }
}
```

### Public API

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `POST` | `/api/auth/register` | Register user baru |
| `POST` | `/api/auth/login` | Login, return token |
| `GET` | `/api/articles` | Daftar artikel (dengan filter) |
| `GET` | `/api/articles/{slug}` | Detail artikel |
| `GET` | `/api/articles/{id}/comments` | Komentar per artikel |
| `GET` | `/api/categories` | Semua kategori |
| `GET` | `/api/categories/{slug}/articles` | Artikel per kategori |
| `GET` | `/api/tags` | Semua tag |
| `GET` | `/api/tags/{slug}/articles` | Artikel per tag |

### Protected API (Bearer Token)

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `POST` | `/api/auth/logout` | Logout |
| `GET` | `/api/auth/me` | Data user saat ini |
| `POST` | `/api/articles` | Buat artikel baru |
| `PUT` | `/api/articles/{id}` | Update artikel |
| `DELETE` | `/api/articles/{id}` | Hapus artikel |
| `POST` | `/api/articles/{id}/publish` | Publikasikan artikel |
| `POST` | `/api/comments` | Tambah komentar |
| `PUT` | `/api/comments/{id}` | Update komentar |
| `DELETE` | `/api/comments/{id}` | Hapus komentar |

### Admin API

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| `GET` | `/api/admin/comments` | Semua komentar |
| `PUT` | `/api/admin/comments/{id}/approve` | Approve komentar |

---

## 📖 Penjelasan API

### 1. Autentikasi

#### Register

```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Registrasi berhasil",
    "data": {
        "user": { "id": 8, "name": "Budi Santoso", "email": "budi@example.com", "role": "author" },
        "token": "1|abc123..."
    }
}
```

#### Login

```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "admin@blog.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": { "id": 1, "name": "Admin", "email": "admin@blog.com", "role": "admin" },
        "token": "1|abc123..."
    }
}
```

**Catatan:** Pesan error login bersifat umum (`"Email atau kata sandi salah"`) untuk mencegah email enumeration.

### 2. Artikel

#### GET Daftar Artikel (dengan filter)

```http
GET /api/articles?category=pc-gaming&tag=valorant&author=Budi&search=game&page=1
```

**Response:**
```json
{
    "success": true,
    "message": "Data artikel berhasil diambil",
    "data": [
        {
            "id": 1,
            "title": "Judul Artikel",
            "slug": "judul-artikel-abc12",
            "excerpt": "Cuplikan artikel...",
            "status": "published",
            "views": 150,
            "published_at": "2026-06-10T08:00:00.000000Z",
            "category": { "id": 1, "name": "PC Gaming", "slug": "pc-gaming" },
            "user": { "id": 2, "name": "Penulis" },
            "tags": [ { "id": 1, "name": "valorant", "slug": "valorant" } ],
            "comments_count": 3
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 10,
        "per_page": 10,
        "last_page": 1
    }
}
```

#### GET Detail Artikel

```http
GET /api/articles/{slug}
```

**Response:** Detail artikel lengkap dengan komentar (status approved) dan data user.

#### POST Buat Artikel (Authenticated)

```http
POST /api/articles
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Review Elden Ring: Game of The Year",
    "content": "<p>Elden Ring adalah...</p>",
    "excerpt": "Review lengkap Elden Ring.",
    "category_id": 1,
    "status": "published",
    "tags": [1, 3, 5]
}
```

### 3. Komentar

#### POST Tambah Komentar

```http
POST /api/comments
Authorization: Bearer {token}
Content-Type: application/json

{
    "article_id": 1,
    "content": "Artikelnya bagus!",
    "parent_id": null
}
```

Untuk membalas komentar, isi `parent_id` dengan ID komentar yang ingin dibalas.

#### GET Komentar per Artikel

```http
GET /api/articles/1/comments
```

### 4. Filter Pencarian

Parameter query yang tersedia di `GET /api/articles`:

| Parameter | Contoh | Fungsi |
|-----------|--------|--------|
| `category` | `pc-gaming` | Filter kategori (slug) |
| `tag` | `valorant` | Filter tag (slug) |
| `author` | `Budi` | Filter nama penulis |
| `search` | `game` | Cari judul/konten |
| `page` | `2` | Halaman pagination |

---

## 🔗 Relasi Database

| Tipe Relasi | Model 1 | Model 2 | Foreign Key |
|-------------|---------|---------|-------------|
| **belongsTo** | Article | Category | `category_id` |
| **hasMany** | Category | Article | `category_id` |
| **belongsTo** | Article | User | `user_id` |
| **hasMany** | User | Article | `user_id` |
| **belongsTo** | Comment | Article | `article_id` |
| **hasMany** | Article | Comment | `article_id` |
| **belongsTo** | Comment | User | `user_id` |
| **hasMany** | User | Comment | `user_id` |
| **belongsToMany** | Article | Tag | pivot `article_tags` |

### Diagram Alur Data

```
User ──hasMany──> Article ──hasMany──> Comment
 │                    │                    │
 │ belongsTo          │ belongsTo           │ belongsTo
 └──────────────────> Category              └──> User (commenter)

Article ──belongsToMany──> Tag
              via pivot: article_tags
```

---

## 📸 Screenshot Halaman

*(Tempat untuk menambahkan screenshot)*

| Halaman | Deskripsi |
|---------|-----------|
| **Home** | Beranda dengan artikel terbaru, trending, kategori populer |
| **Detail Artikel** | Artikel lengkap dengan progress bar, sidebar info, author box |
| **Author Profile** | Profil publik penulis dengan statistik dan daftar artikel |
| **Kategori** | Daftar artikel per kategori gaming |
| **Dashboard** | Dashboard penulis untuk CRUD artikel |
| **Admin Panel** | Control center admin untuk manajemen data |
| **Login/Register** | Halaman autentikasi pengguna |

---

## 📁 Struktur Folder Projek

```
Tugas_API/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/          ← API controllers
│   │   │   │   ├── ArticleController.php
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── CommentController.php
│   │   │   │   └── TagController.php
│   │   │   └── Web/          ← Web controllers
│   │   │       ├── AdminController.php
│   │   │       ├── ArticleController.php
│   │   │       ├── AuthorController.php
│   │   │       ├── CategoryController.php
│   │   │       ├── DashboardController.php
│   │   │       ├── HomeController.php
│   │   │       ├── ProfileController.php
│   │   │       └── SearchController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   └── SecurityHeadersMiddleware.php
│   │   ├── Requests/
│   │   └── Traits/
│   │       └── ApiResponseTrait.php
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Category.php
│   │   ├── Comment.php
│   │   ├── Tag.php
│   │   └── User.php
│   └── Helpers/
│       ├── HtmlSanitizer.php
│       └── ImageHelper.php
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php     ← Layout utama
│   ├── articles/
│   │   ├── show.blade.php    ← Detail artikel
│   │   └── _comment.blade.php ← Komentar partial
│   ├── authors/
│   │   └── show.blade.php    ← Profil author
│   ├── components/
│   │   ├── article-card.blade.php
│   │   ├── author-info.blade.php
│   │   ├── category-badge.blade.php
│   │   ├── pagination.blade.php
│   │   └── skeleton.blade.php
│   ├── admin/
│   ├── dashboard/
│   ├── profile/
│   └── ...
├── routes/
│   ├── web.php               ← Route frontend
│   ├── api.php               ← Route API
│   └── auth.php              ← Route autentikasi
└── ...
```

---

## 🎨 Desain UI

### Tema
- **Mode:** Dark-only (`#0A0A0A` background)
- **Gaya:** Neo-brutalism (border tebal, shadow keras, warna solid)
- **Aksen:** `#FF6B35` (Brutal Orange) — warna khas Nexus Gaming

### Palet Warna

| Warna | Hex | Penggunaan |
|-------|-----|-----------|
| Dark BG | `#0A0A0A` | Latar belakang |
| Dark Card | `#141414` | Kartu, sidebar |
| Border | `#1a1a1a` | Garis batas |
| **Orange** | **`#FF6B35`** | **Aksen utama** |
| Red | `#FF1744` | Danger / Console |
| Yellow | `#FFD600` | Mobile |
| Green | `#00E676` | Esports |
| Blue | `#3B82F6` | Reviews |
| Purple | `#A855F7` | Guides |

### Tipografi
- **Judul:** Orbitron (futuristik, uppercase)
- **Body:** Inter (mudah dibaca)
- **Style:** Uppercase + letter-spacing untuk navigasi dan label

---

## 🛡️ Fitur Keamanan

| Fitur | Implementasi |
|-------|-------------|
| Anti-spam | Honeypot (`website` field) pada register, login, komentar |
| Rate Limiting | Login 20/min, Register 10/60min, Comments 5/min, Search 30/min |
| Session Security | Encrypt=true, HTTP-only=true, SameSite=Lax, Lifetime 300 menit |
| XSS Protection | HTML Sanitizer whitelist tag, Blade `{{ }}` escaping, Alpine `@json()` |
| SQL Injection | Parameterized binding + LIKE escape (`%` dan `_`) |
| File Upload | Max 5MB, validasi MIME via finfo, auto-konversi WebP |
| Duplicate Detection | Komentar sama dalam 5 menit by user + content + article |
| No Email Enumeration | Pesan error login bersifat umum |
| Security Headers | HSTS 1 tahun, CSP ketat, Permissions-Policy terbatas |

---

## 📚 Sumber Belajar

Projek ini dibuat berdasarkan pembelajaran:
- **Laravel 10 Documentation** — https://laravel.com/docs/10.x
- **Tailwind CSS Documentation** — https://tailwindcss.com/docs
- **Alpine.js Documentation** — https://alpinejs.dev/
- **Laravel Sanctum** — https://laravel.com/docs/10.x/sanctum
- **Database Design & ERD** — Mata Kuliah Basis Data

---

## 📄 Lisensi

Projek ini dibuat untuk tujuan **pembelajaran dan tugas UAS**. Tidak untuk penggunaan komersial.

---

*Dibuat oleh **RIZQY - 2409116039 - A'2024** — Sistem Informasi, Universitas X*
