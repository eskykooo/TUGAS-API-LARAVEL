<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
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
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::put('/profile', [ProfileController::class, 'update'])->middleware('throttle:5,1');
    Route::get('/profile/security', [ProfileController::class, 'editSecurity']);
    Route::put('/profile/security', [ProfileController::class, 'updateSecurity'])->middleware('throttle:5,1');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users']);
        Route::get('/articles', [AdminController::class, 'articles']);
        Route::put('/articles/{id}/approve', [AdminController::class, 'approveArticle']);
        Route::delete('/articles/{id}/delete', [AdminController::class, 'deleteArticle']);
        Route::get('/comments', [AdminController::class, 'comments']);
        Route::put('/comments/{id}/approve', [AdminController::class, 'approveComment']);
        Route::put('/comments/{id}/reject', [AdminController::class, 'rejectComment']);
        Route::delete('/comments/{id}/delete', [AdminController::class, 'deleteComment']);

    });
});

require __DIR__.'/auth.php';
