![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![Tailwind](https://img.shields.io/badge/Tailwind-3-06B6D4)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2)
![Sanctum](https://img.shields.io/badge/Sanctum-Auth-orange)
![License](https://img.shields.io/badge/License-MIT-green)

# 🔥 Nexus Gaming — Portal Berita Gaming Premium

**Nexus Gaming** adalah portal berita gaming Indonesia dengan desain dark mode cyberpunk premium, dual-interface (Web + REST API), dan pengalaman membaca setara IGN, Dexerto, PC Gamer, serta GameSpot.

Dibangun dengan **Laravel 10**, **Tailwind CSS**, **Alpine.js**, dan **Sanctum**.

---

## ✨ Fitur Unggulan

### 🎮 Frontend Web
- **Artikel Gaming** — Kategori PC, Console, Mobile, Esports, News, Reviews, Guides
- **Reading Experience Premium** — Lebar konten optimal, progress bar, sticky sidebar, artikel terkait
- **Author Profile** — Halaman publik author dengan statistik & artikel per penulis
- **Komentar Threaded** — Reply, reaction system (like/love/wow), role badge, nested comments
- **Dark Mode Only** — Tema gelap dengan aksen **brutal-orange (#FF6B35)** khas Nexus
- **Neo-Brutalism** — Border tebal, hard shadow, solid color, tanpa glass/blur
- **Futuristic Typography** — Orbitron + Inter yang mudah dibaca
- **Responsive** — Mobile-first, desktop dengan sidebar sticky

### 🔐 Sistem Autentikasi
- Login/Register dengan validasi ketat
- Honeypot anti-spam (`website` field tersembunyi)
- Rate limiting (login 20/min, register 10/60min)
- Session terenkripsi, HTTP-only, SameSite=Lax
- Sanctum token API untuk akses mobile/third-party

### 🛠️ Admin Panel (Nexus Control Center)
- Dashboard dengan statistik real-time
- Manajemen artikel (approve/reject/delete)
- Manajemen komentar (approve/reject/delete)
- Manajemen kategori, tag, user
- Notifications & Activity log

### 🌐 REST API
- Endpoint publik & protected
- Format response JSON seragam (`ApiResponseTrait`)
- Filter, pagination, eager loading
- Rate limiting per endpoint

---

## 🚀 Instalasi

### Persyaratan
- PHP 8.1+
- Composer
- MySQL / MariaDB
- Node.js (optional, untuk asset)

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/eskykooo/TUGAS-API-LARAVEL.git
cd Tugas_API

# 2. Install dependencies
composer install

# 3. Copy environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database (edit .env)
# DB_DATABASE=Tugas_API
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migrasi & seed
php artisan migrate:fresh --seed

# 6. Buat storage link (untuk upload gambar)
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

### Akun Demo

| Email | Password | Role |
|-------|----------|------|
| `admin@blog.com` | `password` | **Admin** |
| `user1@example.com` | `password` | Author |
| `user2@example.com` - `user7@example.com` | `password` | Author |

---

## 📂 Struktur Routes

### Web Routes (`routes/web.php`)

| Method | URL | Controller | Middleware |
|--------|-----|-----------|------------|
| `GET` | `/` | HomeController@index | — |
| `GET` | `/articles/{slug}` | ArticleController@show | — |
| `GET` | `/authors/{id}` | AuthorController@show | — |
| `GET` | `/categories` | CategoryController@index | — |
| `GET` | `/categories/{slug}` | CategoryController@show | — |
| `GET` | `/search` | SearchController@index | throttle:30,1 |
| `POST` | `/comments` | DashboardController@storeComment | auth, throttle:5,1 |
| `POST` | `/comments/{id}/react` | DashboardController@toggleReaction | auth, throttle:10,1 |
| `GET` | `/dashboard` | DashboardController@index | auth |
| `GET/POST` | `/profile` | ProfileController@edit/update | auth |
| `GET/PUT` | `/admin/*` | AdminController | auth, admin |

### API Routes (`routes/api.php`)

Endpoints lengkap dengan format response `{ success, message, data, meta? }`.

#### Publik
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/auth/register` | Register user |
| `POST` | `/api/auth/login` | Login (return token) |
| `GET` | `/api/articles` | Daftar artikel (filter: category, tag, author, search) |
| `GET` | `/api/articles/{slug}` | Detail artikel |
| `GET` | `/api/articles/{id}/comments` | Komentar per artikel |
| `GET` | `/api/categories` | Daftar kategori |
| `GET` | `/api/categories/{slug}/articles` | Artikel per kategori |
| `GET` | `/api/tags` | Daftar tag |
| `GET` | `/api/tags/{slug}/articles` | Artikel per tag |

#### Protected (auth:sanctum)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/auth/logout` | Logout + hapus token |
| `GET` | `/api/auth/me` | Data user saat ini |
| `POST` | `/api/articles` | Buat artikel |
| `PUT` | `/api/articles/{id}` | Update artikel |
| `DELETE` | `/api/articles/{id}` | Hapus artikel |
| `POST` | `/api/articles/{id}/publish` | Publikasikan artikel |
| `POST` | `/api/comments` | Tambah komentar |
| `PUT` | `/api/comments/{id}` | Update komentar (owner only) |
| `DELETE` | `/api/comments/{id}` | Hapus komentar (owner/admin) |

#### Admin
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/admin/comments` | Semua komentar (paginated 20) |
| `PUT` | `/api/admin/comments/{id}/approve` | Approve komentar |

---

## 🧠 Arsitektur

### Dual Interface
```
Web (Session)  →  routes/web.php  →  Blade + Alpine.js  →  Browser
                     ↓
API (Token)    →  routes/api.php  →  JSON Response     →  Mobile / SPA
```

### Model Relationships
```
User ──hasMany──> Article ──hasMany──> Comment
 │                    │                    │
 │                    │ belongsTo           │ belongsTo
 │                    ▼                    ▼
 └───────>       Category               User (commenter)

Article ──belongsToMany──> Tag
              via pivot: article_tags
```

### Security Features
- ✅ Honeypot anti-spam pada register, login, dan komentar
- ✅ Rate limiting spesifik per endpoint
- ✅ Session terenkripsi + HTTP-only + SameSite=Lax
- ✅ HTML Sanitizer untuk konten artikel
- ✅ SQL injection safe (parameterized binding + LIKE escaping)
- ✅ Anti duplicate comment (same user + content within 5min)
- ✅ Generic login error message (no email enumeration)
- ✅ Security headers (HSTS, CSP, Permissions-Policy)
- ✅ Admin middleware dengan logging

---

## 🎨 Desain System

### Color Palette
| Color | Hex | Usage |
|-------|-----|-------|
| Dark Background | `#0A0A0A` | Body background |
| Dark Card | `#141414` | Card, sidebar |
| Dark Border | `#1a1a1a` | Borders |
| **Brutal Orange** | **`#FF6B35`** | Primary accent |
| Brutal Red | `#FF1744` | Danger |
| Brutal Yellow | `#FFD600` | Mobile category |
| Brutal Green | `#00E676` | Esports category |
| Brutal Blue | `#3B82F6` | Reviews category |
| Brutal Purple | `#A855F7` | Guides category |

### Typography
- **Headings:** Orbitron (sans-serif, futuristic)
- **Body:** Inter (sans-serif, readable)
- **Style:** Uppercase + tracking-wide pada elemen navigasi & label

---

## 📦 Dependencies

| Library | Versi | Penggunaan |
|---------|-------|------------|
| Laravel | 10.x | Framework |
| Laravel Sanctum | ^3 | API token auth |
| Tailwind CSS | 3.x (CDN) | Styling |
| Alpine.js | 3.x (CDN) | Interaktivitas frontend |
| Font Awesome | 6.5 (CDN) | Icons |
| AOS | 2.3.1 (CDN) | Scroll animation |
| Trix | 1.3.1 (CDN) | Rich text editor (dashboard) |
| Cropper.js | 1.6.2 (CDN) | Avatar crop (profile) |
| Google Fonts | Inter + Orbitron | Typography |

---

## 📝 API Documentation

### Response Format

**Success:**
```json
{
    "success": true,
    "message": "Data artikel berhasil diambil",
    "data": { ... },
    "meta": {
        "current_page": 1,
        "total": 25,
        "per_page": 10,
        "last_page": 3
    }
}
```

**Error:**
```json
{
    "success": false,
    "message": "Email atau password salah."
}
```

### Contoh Request

```bash
# Get articles with filters
curl "https://example.com/api/articles?category=pc-gaming&page=1"

# Login
curl -X POST "https://example.com/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@blog.com","password":"password"}'

# Create article (with token)
curl -X POST "https://example.com/api/articles" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Judul","content":"<p>Konten</p>","category_id":1,"status":"published","tags":[1,2]}'
```

---

## 🛡️ Security

- **CORS:** Allowed origins from `CORS_ALLOWED_ORIGINS` env (no wildcard)
- **Rate Limiting:** Login 20/min, Register 10/60min, Comments 5/min, Search 30/min
- **Password:** Min 8 chars with confirmation (no uppercase/number requirement)
- **File Upload:** Max 5MB, converted to WebP quality 80
- **Sanctum Token:** Expires per `SANCTUM_TOKEN_EXPIRATION` env (default 1440 min)
- **Session:** Lifetime 300 min (5 hours), expire on close, encrypted

---

## 🤝 Kontribusi

Pull request terbuka! Pastikan mengikuti code style dengan `./vendor/bin/pint` sebelum commit.

```bash
./vendor/bin/pint
```

---

## 📄 Lisensi

MIT License — bebas digunakan untuk pembelajaran dan pengembangan.

---

*Dibuat dengan ❤️ untuk gamers Indonesia.*
