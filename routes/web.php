<?php

use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::get('/search', [SearchController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/articles/create', [DashboardController::class, 'create']);
    Route::post('/dashboard/articles', [DashboardController::class, 'store']);
    Route::get('/dashboard/articles/{id}/edit', [DashboardController::class, 'edit']);
    Route::put('/dashboard/articles/{id}', [DashboardController::class, 'update']);
    Route::delete('/dashboard/articles/{id}', [DashboardController::class, 'destroy']);
    Route::post('/dashboard/articles/{id}/publish', [DashboardController::class, 'publish']);
    Route::post('/comments', [DashboardController::class, 'storeComment']);
});

require __DIR__ . '/auth.php';
