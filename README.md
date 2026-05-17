![Laravel](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)

# RIZQY - 2409116039 - A'2024

# 📡 Memahami API dan Implementasinya di Laravel

---

## 1. Definisi API dalam Pemrograman

### Apa itu API?

**API** (*Application Programming Interface*) adalah jembatan yang memungkinkan dua aplikasi berbeda saling berkomunikasi dan bertukar data. API bertindak sebagai perantara yang mendefinisikan *aturan main* — bagaimana sebuah aplikasi bisa meminta data, dan bagaimana data itu akan dikembalikan.

### Analogi Sederhana

Bayangkan Anda makan di restoran:

| Peran | Analogi Restoran | Analogi API |
|-------|------------------|-------------|
| Anda | Pelanggan | **Client** (Frontend / Mobile App) |
| Pramusaji | Pelayan yang membawa pesanan | **API** (perantara) |
| Dapur | Tempat memasak | **Server / Database** |

Anda tidak bisa langsung masuk ke dapur untuk mengambil makanan. Anda harus **memesan melalui pramusaji**, yang kemudian menyampaikan ke dapur, dan mengantarkan makanan kembali ke meja Anda. Itulah cara kerja API — pihak ketiga yang mengatur pertukaran data antara client dan server.

### Jenis-jenis API

| Jenis | Karakteristik | Contoh Penggunaan |
|-------|---------------|-------------------|
| **REST** | Berbasis HTTP, menggunakan method GET/POST/PUT/DELETE, output JSON | Paling populer di web modern |
| **SOAP** | Berbasis XML, protokol ketat, lebih berat | Sistem perbankan, enterprise |
| **GraphQL** | Client bisa meminta field spesifik, satu endpoint | Aplikasi yang butuh fleksibilitas data tinggi |

> **Catatan:** Proyek ini menerapkan **RESTful API** — standar paling umum dan mudah diimplementasikan dengan Laravel.

### Komponen Utama API

| Komponen | Penjelasan |
|----------|------------|
| **Endpoint** | URL spesifik yang bisa diakses (contoh: `/api/articles`) |
| **Request** | Data yang dikirim client ke server (parameter, header, body) |
| **Response** | Data yang dikembalikan server ke client (biasanya JSON) |
| **Header** | Informasi tambahan dalam request/response (Authorization, Content-Type) |
| **Body** | Isi data yang dikirim (untuk POST/PUT) |

---

## 2. Tujuan dan Pemanfaatan API

### Mengapa API Dibuat?

API dibuat untuk memisahkan **logika backend** dari **tampilan frontend**. Dengan API, aplikasi web, mobile, dan pihak ketiga bisa menggunakan data yang sama tanpa harus membuat ulang sistem backend.

### Manfaat Nyata API

- **Reusability** — satu backend bisa melayani web, iOS, Android sekaligus
- **Security** — data sensitif tidak diekspos langsung ke client
- **Scalability** — backend dan frontend bisa di-scale secara independen
- **Integrasi** — mudah menghubungkan dengan layanan pihak ketiga

### Contoh dalam Kehidupan Sehari-hari

**1. Aplikasi Cuaca**
Aplikasi cuaca di HP Anda mengambil data dari server气象局 melalui API. Setiap kali Anda buka aplikasi, terjadi request GET ke endpoint API cuaca, dan server mengembalikan data suhu, kelembaban, dan prakiraan dalam format JSON.

**2. Login dengan Google / Facebook**
Saat Anda login ke aplikasi menggunakan akun Google, aplikasi tersebut menggunakan **OAuth API** dari Google. Google-lah yang memverifikasi identitas Anda, bukan aplikasi itu sendiri. Aplikasi hanya menerima token dari Google sebagai bukti bahwa Anda sudah terverifikasi.

**3. Pembayaran Online (Midtrans / Xendit)**
Toko online tidak perlu mengurus sistem pembayaran sendiri. Cukup panggil API dari Midtrans atau Xendit, dan pembayaran diproses oleh mereka. Toko online hanya menerima notifikasi sukses/gagal melalui **webhook callback**.

**4. Ojek Online dengan Google Maps**
Aplikasi Gojek/Grab menampilkan peta dan rute perjalanan dengan memanfaatkan **Google Maps API**. Mereka tidak membuat peta sendiri — mereka meminjam data dari Google melalui API.

---

## 3. Seberapa Penting API dalam Pemrograman Modern

### Peran API dalam Arsitektur Modern

Hampir semua aplikasi modern menggunakan arsitektur **Frontend ↔ Backend via API**:

```
[React/Vue]  ──HTTP──>  [API Laravel]  ──>  [Database]
     │                      │
     │                      ├──> [Cache Redis]
     │                      └──> [Storage Gambar]
```

### Kenapa Aplikasi Mobile WAJIB Punya API?

Aplikasi mobile (Android/iOS) tidak bisa mengakses database secara langsung. Mereka harus berkomunikasi melalui HTTP/HTTPS ke server. Tanpa API, aplikasi mobile hanyalah aplikasi offline tanpa data real-time.

### Kenapa Microservice Tidak Bisa Jalan Tanpa API?

Arsitektur microservice membagi aplikasi besar menjadi service-service kecil yang independen. Service-service ini berkomunikasi satu sama lain **hanya melalui API**. Contoh:

```
[Service User]  ──API──>  [Service Artikel]  ──API──>  [Service Notifikasi]
       │                        │
       └────────────────────────┘
           API (Internal Network)
```

### Perbandingan: Tanpa API vs Dengan API

| Aspek | Aplikasi Tanpa API | Aplikasi Dengan API |
|-------|--------------------|----------------------|
| **Arsitektur** | Monolitik (backend & frontend menyatu) | Terpisah (backend API + frontend terpisah) |
| **Platform** | Hanya web | Web + Mobile + Desktop sekaligus |
| **Pengembangan** | Setiap platform buat backend sendiri | Satu backend untuk semua platform |
| **Maintenance** | Perubahan UI harus ubah backend juga | Backend tetap, UI bisa diganti kapan saja |
| **Skalabilitas** | Sulit, harus scale seluruh aplikasi | Mudah, scale per service |
| **Integrasi Pihak Ketiga** | Sulit, tidak ada standar | Mudah, tinggal panggil endpoint |
| **Contoh** | Website tradisional PHP (2000-an) | SaaS modern (2020+) |

### Dampak Jika Tidak Ada API

- Setiap aplikasi (web, iOS, Android) harus punya backend sendiri-sendiri
- Integrasi dengan pihak ketiga (pembayaran, maps, login sosial) hampir tidak mungkin
- Data tidak bisa dibagikan antar sistem dengan aman
- Ekosistem software menjadi tertutup dan tidak terhubung

---

## 4. Contoh Dasar API di Laravel (Studi Kasus: Blog & Berita)

### Struktur Database

```sql
-- Tabel users
id          INT PRIMARY KEY AUTO_INCREMENT
name        VARCHAR(100)
email       VARCHAR(100) UNIQUE
role        ENUM('admin', 'author')
password    VARCHAR(255)

-- Tabel categories
id          INT PRIMARY KEY AUTO_INCREMENT
name        VARCHAR(100)
slug        VARCHAR(100) UNIQUE
description TEXT NULLABLE

-- Tabel articles
id          INT PRIMARY KEY AUTO_INCREMENT
title       VARCHAR(255)
slug        VARCHAR(255) UNIQUE
content     TEXT
excerpt     TEXT NULLABLE
thumbnail   VARCHAR(255) NULLABLE
status      ENUM('draft', 'published', 'archived') DEFAULT 'draft'
category_id INT FOREIGN KEY → categories(id)
user_id     INT FOREIGN KEY → users(id)
views       INT DEFAULT 0
published_at DATETIME NULLABLE

-- Tabel comments
id          INT PRIMARY KEY AUTO_INCREMENT
article_id  INT FOREIGN KEY → articles(id)
user_id     INT FOREIGN KEY → users(id)
content     TEXT
status      ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'

-- Tabel tags
id          INT PRIMARY KEY AUTO_INCREMENT
name        VARCHAR(100)
slug        VARCHAR(100) UNIQUE

-- Tabel pivot article_tags
article_id  INT FOREIGN KEY → articles(id)
tag_id      INT FOREIGN KEY → tags(id)
```

### routes/api.php

```php
<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

// === ROUTE PUBLIC (tanpa autentikasi) ===

// Auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Articles
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/articles/{id}/comments', [CommentController::class, 'index']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}/articles', [CategoryController::class, 'articlesByCategory']);

// Tags
Route::get('/tags', [TagController::class, 'index']);
Route::get('/tags/{slug}/articles', [TagController::class, 'articlesByTag']);

// === ROUTE PROTECTED (wajib login via Sanctum) ===
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
    Route::post('/articles/{id}/publish', [ArticleController::class, 'publish']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});

// === ROUTE ADMIN ===
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/comments', [CommentController::class, 'adminIndex']);
    Route::put('/admin/comments/{id}/approve', [CommentController::class, 'approve']);
});
```

### Model dengan Relasi

#### Model Article

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'thumbnail',
        'status', 'category_id', 'user_id', 'views', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relasi: Artikel dimiliki oleh satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Artikel dimiliki oleh satu user (penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Artikel memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi: Artikel memiliki banyak tag (many-to-many via pivot)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    // Scope: hanya artikel published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Accessor: menghitung waktu baca
    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' menit';
    }
}
```

#### Model Category

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    // Relasi: Satu kategori memiliki banyak artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
```

#### Model Comment

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'content', 'status'];

    // Relasi: Komentar dimiliki oleh satu artikel
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Relasi: Komentar dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

#### Model Tag

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Relasi: Tag dimiliki oleh banyak artikel (many-to-many)
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }
}
```

#### Model User

```php
<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
```

### ArticleController (API)

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    /**
     * GET /api/articles
     * Menampilkan daftar artikel dengan filter, eager loading, dan pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['category', 'user', 'tags'])
            ->withCount('comments')
            ->where('status', 'published');

        // Filter berdasarkan kategori (?category=teknologi)
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter berdasarkan tag (?tag=laravel)
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        // Filter berdasarkan penulis (?author=John)
        if ($request->filled('author')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->author}%"));
        }

        // Pencarian judul/konten (?search=laravel)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest('published_at')->paginate(10);

        return $this->success(
            $articles->items(),
            'Data artikel berhasil diambil',
            200,
            [
                'current_page' => $articles->currentPage(),
                'total'        => $articles->total(),
                'per_page'     => $articles->perPage(),
                'last_page'    => $articles->lastPage(),
            ]
        );
    }

    /**
     * GET /api/articles/{slug}
     * Menampilkan detail satu artikel + komentar yang sudah di-approve.
     */
    public function show(string $slug): JsonResponse
    {
        $article = Article::with([
            'category', 'user', 'tags',
            'comments' => function ($q) {
                $q->where('status', 'approved')->with('user');
            }
        ])->where('slug', $slug)->firstOrFail();

        $article->increment('views');

        return $this->success($article, 'Detail artikel berhasil diambil');
    }
}
```

### Format Response JSON Seragam

Semua response API menggunakan trait `ApiResponseTrait` agar formatnya konsisten:

```php
<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function success($data = null, string $message = 'Success', int $code = 200, $meta = null): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }

    public function error(string $message = 'Error', int $code = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
```

**Contoh response sukses:**

```json
{
    "success": true,
    "message": "Data artikel berhasil diambil",
    "data": [
        {
            "id": 1,
            "title": "Laravel 11 Resmi Dirilis",
            "slug": "laravel-11-resmi-dirilis",
            "category": { "id": 1, "name": "Teknologi", "slug": "teknologi" },
            "user": { "id": 1, "name": "Admin", "email": "admin@blog.test" },
            "tags": [ { "id": 1, "name": "laravel", "slug": "laravel" } ],
            "comments_count": 5,
            "views": 1200,
            "published_at": "2025-12-01T08:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 25,
        "per_page": 10,
        "last_page": 3
    }
}
```

**Contoh response error:**

```json
{
    "success": false,
    "message": "Email atau password salah."
}
```

---

## 5. Studi Kasus API Sederhana (3 Kasus Berbeda)

### Kasus 1: API Manajemen Artikel

**Endpoint CRUD lengkap:**

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| GET | `/api/articles` | Ambil semua artikel | ❌ |
| GET | `/api/articles/{slug}` | Ambil detail artikel | ❌ |
| POST | `/api/articles` | Buat artikel baru | ✅ |
| PUT | `/api/articles/{id}` | Update artikel | ✅ |
| DELETE | `/api/articles/{id}` | Hapus artikel | ✅ |
| POST | `/api/articles/{id}/publish` | Publikasikan artikel | ✅ |

**Contoh request POST /api/articles:**

```json
{
    "title": "Cara Membuat API di Laravel",
    "content": "<p>Langkah-langkah membuat RESTful API...</p>",
    "excerpt": "Panduan lengkap membuat API.",
    "category_id": 1,
    "status": "published",
    "tags": [1, 3, 5]
}
```

**Contoh response:**

```json
{
    "success": true,
    "message": "Artikel berhasil dibuat",
    "data": {
        "id": 10,
        "title": "Cara Membuat API di Laravel",
        "slug": "cara-membuat-api-di-laravel-abc12",
        "status": "published",
        "published_at": "2025-12-10T10:30:00.000000Z",
        "category": { "id": 1, "name": "Teknologi", "slug": "teknologi" },
        "user": { "id": 2, "name": "Penulis" },
        "tags": [
            { "id": 1, "name": "laravel", "slug": "laravel" },
            { "id": 3, "name": "api", "slug": "api" }
        ]
    }
}
```

### Kasus 2: API Kategori dengan Jumlah Artikel

```php
public function index(): JsonResponse
{
    $categories = Category::withCount('articles')->get();

    return $this->success($categories, 'Data kategori berhasil diambil');
}
```

**Response JSON:**

```json
{
    "success": true,
    "message": "Data kategori berhasil diambil",
    "data": [
        {
            "id": 1,
            "name": "Teknologi",
            "slug": "teknologi",
            "articles_count": 15
        },
        {
            "id": 2,
            "name": "Politik",
            "slug": "politik",
            "articles_count": 8
        },
        {
            "id": 3,
            "name": "Olahraga",
            "slug": "olahraga",
            "articles_count": 12
        }
    ]
}
```

> `withCount('articles')` menambahkan kolom `articles_count` secara otomatis tanpa perlu query manual. Laravel menggunakan `COUNT(*)` di level database — sangat efisien.

### Kasus 3: API Komentar per Artikel

```php
public function index(string $articleId): JsonResponse
{
    $comments = Comment::where('article_id', $articleId)
        ->where('status', 'approved')
        ->with('user')          // eager loading data user
        ->latest()
        ->get();

    return $this->success($comments, 'Komentar berhasil diambil');
}
```

**Response JSON:**

```json
{
    "success": true,
    "message": "Komentar berhasil diambil",
    "data": [
        {
            "id": 1,
            "content": "Artikelnya sangat bermanfaat!",
            "status": "approved",
            "created_at": "2 jam lalu",
            "user": {
                "id": 3,
                "name": "Budi Santoso",
                "avatar": null
            }
        },
        {
            "id": 2,
            "content": "Terima kasih, ditunggu artikel selanjutnya.",
            "status": "approved",
            "created_at": "1 jam lalu",
            "user": {
                "id": 5,
                "name": "Siti Rahmawati",
                "avatar": null
            }
        }
    ]
}
```

---

## 6. Cara Kerja Pengambilan Data Antar Tabel

### Relasi 1: Article → Category (belongsTo)

Setiap artikel memiliki **satu kategori**. Relasi ini disebut **belongsTo** karena artikel "dimiliki oleh" kategori.

```php
// Di Model Article
public function category()
{
    return $this->belongsTo(Category::class);
}

// Cara panggil di controller
$article = Article::with('category')->first();
```

**Hasil JSON:**

```json
{
    "id": 1,
    "title": "Laravel 11 Resmi Dirilis",
    "content": "<p>Laravel 11 hadir dengan fitur...</p>",
    "category": {
        "id": 1,
        "name": "Teknologi",
        "slug": "teknologi"
    }
}
```

**Cara kerja:** Laravel mengambil `category_id` dari tabel `articles`, lalu mencocokkannya dengan `id` di tabel `categories`. Hasilnya digabung dalam satu objek JSON. Tanpa `with('category')`, field `category_id` hanya muncul sebagai angka, bukan data kategori lengkap.

---

### Relasi 2: Category → Articles (hasMany)

Satu kategori bisa memiliki **banyak artikel**. Relasi ini adalah kebalikan dari belongsTo.

```php
// Di Model Category
public function articles()
{
    return $this->hasMany(Article::class);
}

// Cara panggil di controller
$category = Category::withCount('articles')->first();
```

**Hasil JSON:**

```json
{
    "id": 1,
    "name": "Teknologi",
    "slug": "teknologi",
    "articles_count": 15,
    "articles": [
        {
            "id": 1,
            "title": "Laravel 11 Resmi Dirilis",
            "status": "published",
            "user": { "name": "Admin" }
        },
        {
            "id": 2,
            "title": "React 19 vs Vue 4",
            "status": "published",
            "user": { "name": "Penulis" }
        }
    ]
}
```

**Cara kerja:** Laravel mengambil semua baris dari tabel `articles` yang memiliki `category_id` sama dengan `id` kategori ini. Mirip dengan `SELECT * FROM articles WHERE category_id = ?`. Method `withCount('articles')` menambahkan `COUNT(*)` sebagai kolom `articles_count` tanpa harus query manual.

---

### Relasi 3: Article → Comments → User (Nested)

Artikel → komentar → user yang berkomentar. Ini contoh **nested eager loading** — mengambil data dari 3 tabel sekaligus dalam satu query.

```php
// Di Model Article
public function comments()
{
    return $this->hasMany(Comment::class);
}

// Di Model Comment
public function user()
{
    return $this->belongsTo(User::class);
}

// Cara panggil — eager loading 3 level
$article = Article::with(['comments' => function ($q) {
    $q->where('status', 'approved')->with('user');
}])->first();
```

**Hasil JSON:**

```json
{
    "id": 1,
    "title": "Laravel 11 Resmi Dirilis",
    "comments": [
        {
            "id": 1,
            "content": "Mantap!",
            "status": "approved",
            "created_at": "2025-12-10T08:00:00.000000Z",
            "user": {
                "id": 3,
                "name": "Budi Santoso",
                "email": "budi@example.com",
                "role": "author"
            }
        }
    ]
}
```

**Cara kerja:**
1. Laravel mengambil artikel → dapat `id = 1`
2. Laravel mengambil komentar → `SELECT * FROM comments WHERE article_id = 1 AND status = 'approved'`
3. Untuk setiap komentar, Laravel mengambil user → `SELECT * FROM users WHERE id IN (3, 5, 7)`
4. Semua data digabung menjadi satu struktur JSON nested

Tanpa eager loading (`with`), query akan berlipat ganda — yang disebut masalah **N+1 query**. Eager loading mereduksi ribuan query menjadi hanya 3 query.

---

### Relasi 4: Article ↔ Tags (belongsToMany via Pivot)

Ini adalah relasi **many-to-many**. Satu artikel bisa punya banyak tag, dan satu tag bisa dimiliki banyak artikel. Hubungan ini disimpan di tabel pivot `article_tags`.

```php
// Di Model Article
public function tags()
{
    return $this->belongsToMany(Tag::class, 'article_tags');
}

// Di Model Tag
public function articles()
{
    return $this->belongsToMany(Article::class, 'article_tags');
}

// Cara panggil
$article = Article::with('tags')->first();
```

**Struktur tabel pivot `article_tags`:**

| article_id | tag_id |
|------------|--------|
| 1 | 1 |
| 1 | 3 |
| 2 | 1 |
| 2 | 5 |

**Hasil JSON:**

```json
{
    "id": 1,
    "title": "Laravel 11 Resmi Dirilis",
    "tags": [
        {
            "id": 1,
            "name": "laravel",
            "slug": "laravel",
            "pivot": {
                "article_id": 1,
                "tag_id": 1
            }
        },
        {
            "id": 3,
            "name": "php",
            "slug": "php",
            "pivot": {
                "article_id": 1,
                "tag_id": 3
            }
        }
    ]
}
```

**Cara kerja:**
1. Laravel mengambil artikel → `id = 1`
2. Laravel cek tabel pivot `article_tags` → `SELECT tag_id FROM article_tags WHERE article_id = 1`
3. Laravel ambil data tag → `SELECT * FROM tags WHERE id IN (1, 3)`
4. Data pivot (`article_id`, `tag_id`) otomatis disertakan di setiap tag

> Field `pivot` bisa disembunyikan dengan menambahkan `->withPivot('...')` atau di-hidden di response API.

---

### Ringkasan Semua Relasi

| Tipe Relasi | Model 1 | Model 2 | Foreign Key | Contoh Penggunaan |
|-------------|---------|---------|-------------|-------------------|
| **belongsTo** | Article | Category | `category_id` | Artikel punya 1 kategori |
| **hasMany** | Category | Article | `category_id` | Kategori punya banyak artikel |
| **belongsTo** | Comment | Article | `article_id` | Komentar milik 1 artikel |
| **belongsTo** | Comment | User | `user_id` | Komentar ditulis 1 user |
| **hasMany** | Article | Comment | `article_id` | Artikel punya banyak komentar |
| **belongsToMany** | Article | Tag | pivot `article_tags` | Artikel bisa banyak tag, tag banyak artikel |

### Diagram Alur Data

```
User ──hasMany──> Article ──hasMany──> Comment
                     │                      │
                     │ belongsTo             │ belongsTo
                     ▼                      ▼
                 Category                 User
                     │
                     │ hasMany
                     ▼
                 Article (lagi)

Article ──belongsToMany──> Tag
   │                           │
   └──── pivot article_tags ───┘
```

---

## Kesimpulan

API adalah fondasi utama arsitektur aplikasi modern. Dengan Laravel, pembuatan RESTful API menjadi sangat cepat berkat fitur-fitur seperti:

- **Eloquent ORM** — relasi data antar tabel yang ekspresif dan mudah dibaca
- **Sanctum** — autentikasi API yang simpel untuk SPA dan mobile
- **Eager Loading** — mencegah masalah N+1 query
- **Resource / Trait** — format response JSON yang konsisten
- **Request Validation** — validasi data masuk yang terpusat

Proyek **Blog & Berita API** ini adalah contoh nyata bagaimana sebuah API dibangun dengan struktur yang rapi, aman, dan siap digunakan oleh frontend web maupun aplikasi mobile.
