<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $categories = Category::withCount('articles')->get();

        return $this->success($categories, 'Data kategori berhasil diambil');
    }

    public function articlesByCategory(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->with(['articles' => function ($q) {
                $q->where('status', 'published')->with(['user', 'tags']);
            }])
            ->firstOrFail();

        return $this->success($category, 'Artikel per kategori berhasil diambil');
    }
}
