<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $tags = Tag::withCount('articles')->get();

        return $this->success($tags, 'Data tag berhasil diambil');
    }

    public function articlesByTag(string $slug): JsonResponse
    {
        $tag = Tag::where('slug', $slug)
            ->with(['articles' => function ($q) {
                $q->where('status', 'published')->with(['category', 'user']);
            }])
            ->firstOrFail();

        return $this->success($tag, 'Artikel per tag berhasil diambil');
    }
}
