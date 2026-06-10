<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $categorySlug = $request->get('category');
        $tagSlug = $request->get('tag');
        $sort = $request->get('sort', 'latest');

        $articles = Article::published()->with(['category', 'user', 'tags']);

        if ($query) {
            $safe = str_replace(['%', '_'], ['\\%', '\\_'], $query);
            $articles->where(function ($q) use ($safe) {
                $q->where('title', 'like', "%{$safe}%")
                    ->orWhere('content', 'like', "%{$safe}%")
                    ->orWhere('excerpt', 'like', "%{$safe}%");
            });
        }

        if ($categorySlug) {
            $articles->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($tagSlug) {
            $articles->whereHas('tags', fn ($q) => $q->where('slug', $tagSlug));
        }

        match ($sort) {
            'popular' => $articles->orderByDesc('views'),
            'trending' => $articles->orderByDesc('views')->latest('published_at'),
            default => $articles->latest('published_at'),
        };

        $articles = $articles->paginate(12)->withQueryString();

        $categories = Category::withCount('articles')->get();
        $tags = Tag::withCount('articles')->get();

        $trendingArticles = Article::published()
            ->with(['category', 'user'])
            ->orderByDesc('views')
            ->take(4)
            ->get();

        return view('search', compact(
            'articles', 'query', 'categories', 'tags',
            'categorySlug', 'tagSlug', 'sort', 'trendingArticles'
        ));
    }
}
