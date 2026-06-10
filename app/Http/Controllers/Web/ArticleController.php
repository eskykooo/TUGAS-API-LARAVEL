<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with(['category', 'user', 'tags'])
            ->firstOrFail();

        $article->increment('views');

        $totalComments = $article->comments()->approved()->count();

        $article->load(['comments' => function ($q) {
            $q->with(['user', 'replies' => function ($r) {
                $r->with('user');
            }])->approved()->root()->latest();
        }]);

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['category', 'user'])
            ->latest('published_at')->take(3)->get();

        return view('articles.show', compact('article', 'related', 'totalComments'));
    }
}
