<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\AuthorController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    $files = array_merge(
        glob(storage_path('framework/views/*')),
        glob(storage_path('framework/cache/data/*')),
        glob(storage_path('framework/cache/data/{*/,*/*/}', GLOB_BRACE))
    );
    foreach ($files as $file) {
        if (is_file($file)) { @unlink($file); }
    }
    return 'OK';
})->middleware('throttle:1,60');

Route::get('/', [HomeController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::get('/search', [SearchController::class, 'index'])->middleware('throttle:30,1');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/articles/create', [DashboardController::class, 'create']);
    Route::post('/dashboard/articles', [DashboardController::class, 'store'])->middleware('throttle:10,60');
    Route::get('/dashboard/articles/{id}/edit', [DashboardController::class, 'edit']);
    Route::put('/dashboard/articles/{id}', [DashboardController::class, 'update'])->middleware('throttle:10,60');
    Route::delete('/dashboard/articles/{id}', [DashboardController::class, 'destroy'])->middleware('throttle:10,60');
    Route::post('/dashboard/articles/{id}/publish', [DashboardController::class, 'publish'])->middleware('throttle:10,60');
    Route::post('/comments', [DashboardController::class, 'storeComment'])->middleware('throttle:5,1');
    Route::post('/comments/{id}/react', [DashboardController::class, 'toggleReaction'])->middleware('throttle:10,1');
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update'])->middleware('throttle:5,1');
    Route::get('/profile/security', [ProfileController::class, 'editSecurity']);
    Route::put('/profile/security', [ProfileController::class, 'updateSecurity'])->middleware('throttle:5,1');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/articles', [AdminController::class, 'articles']);
        Route::put('/articles/{id}/approve', [AdminController::class, 'approveArticle']);
        Route::delete('/articles/{id}/delete', [AdminController::class, 'deleteArticle']);
        Route::get('/comments', [AdminController::class, 'comments']);
        Route::put('/comments/{id}/approve', [AdminController::class, 'approveComment']);
        Route::put('/comments/{id}/reject', [AdminController::class, 'rejectComment']);
        Route::delete('/comments/{id}/delete', [AdminController::class, 'deleteComment']);
        Route::get('/categories', [AdminController::class, 'categories']);
        Route::get('/tags', [AdminController::class, 'tags']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::get('/notifications', [AdminController::class, 'notifications']);
        Route::get('/activity', [AdminController::class, 'activity']);
        Route::get('/settings', [AdminController::class, 'settings']);
        Route::get('/security', [AdminController::class, 'security'])->name('admin.security');
        Route::put('/security', [AdminController::class, 'updateSecurity'])->middleware('throttle:5,1');
    });
});

require __DIR__.'/auth.php';
