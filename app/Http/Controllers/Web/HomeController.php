<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $slideIds = $slides->pluck('id')->toArray();

        $latest = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->whereNotIn('id', $slideIds)
            ->latest('published_at')
            ->take(6)
            ->get();

        $breaking = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $categories = Category::withCount(['articles' => fn ($q) => $q->where('status', 'published')])->get();

        $popular = Article::with(['category'])
            ->where('status', 'published')
            ->orderByDesc('views')
            ->take(8)
            ->get();

        $trending = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->whereNotIn('id', $slideIds)
            ->orderByDesc('views')
            ->take(4)
            ->get();

        $tags = Tag::withCount('articles')->orderByDesc('articles_count')->take(15)->get();

        $footerArticles = Article::with(['category', 'user'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact(
            'slides', 'latest', 'breaking',
            'categories', 'popular', 'trending',
            'tags', 'footerArticles'
        ));
    }
}
