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

    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['category', 'user', 'tags'])
            ->withCount('comments')
            ->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('author')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->author}%"));
        }

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
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'last_page' => $articles->lastPage(),
            ]
        );
    }

    public function show(string $slug): JsonResponse
    {
        $article = Article::with(['category', 'user', 'tags', 'comments' => function ($q) {
            $q->where('status', 'approved')->with('user');
        }])->where('slug', $slug)->firstOrFail();

        $article->increment('views');

        return $this->success($article, 'Detail artikel berhasil diambil');
    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['user_id'] = $request->user()->id;

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        if ($request->filled('tags')) {
            $article->tags()->attach($request->tags);
        }

        $article->load(['category', 'user', 'tags']);

        return $this->success($article, 'Artikel berhasil dibuat', 201);
    }

    public function update(StoreArticleRequest $request, string $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $data = $request->validated();

        if ($data['status'] === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        }

        $article->update($data);

        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }

        $article->load(['category', 'user', 'tags']);

        return $this->success($article, 'Artikel berhasil diperbarui');
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $article->delete();

        return $this->success(null, 'Artikel berhasil dihapus');
    }

    public function publish(Request $request, string $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return $this->success($article, 'Artikel berhasil dipublikasikan');
    }
}
