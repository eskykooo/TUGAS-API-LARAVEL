<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->get();
        $latestArticles = Article::published()
            ->with(['category', 'user'])
            ->latest('published_at')->take(6)->get();

        return view('categories.index', compact('categories', 'latestArticles'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['category', 'user', 'tags'])
            ->latest('published_at')->paginate(9);

        $categories = Category::withCount('articles')->get();

        return view('categories.show', compact('category', 'articles', 'categories'));
    }
}
