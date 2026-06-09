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

        $articles = $articles->latest('published_at')->paginate(10);

        $categories = Category::withCount('articles')->get();
        $tags = Tag::withCount('articles')->get();

        return view('search', compact('articles', 'query', 'categories', 'tags', 'categorySlug', 'tagSlug'));
    }
}
