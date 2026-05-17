<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with(['category', 'user', 'tags', 'comments' => function ($q) {
                $q->where('status', 'approved')->with('user');
            }])
            ->firstOrFail();

        $article->increment('views');

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['category', 'user'])
            ->latest('published_at')->take(3)->get();

        return view('articles.show', compact('article', 'related'));
    }
}
