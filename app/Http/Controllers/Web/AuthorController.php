<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AuthorController extends Controller
{
    public function show($id)
    {
        $author = User::withCount(['articles' => function (Builder $q) {
            $q->published();
        }])->findOrFail($id);

        // Stats
        $totalViews = (int) Article::published()->where('user_id', $author->id)->sum('views');

        $totalComments = (int) Article::published()
            ->where('user_id', $author->id)
            ->withCount('comments')
            ->get()
            ->sum('comments_count');

        // Articles query — published to all, draft/pending only to owner or admin
        $articlesQuery = Article::where('user_id', $author->id)
            ->with(['category', 'tags'])
            ->withCount('comments');

        if (auth()->check() && (auth()->id() === $author->id || auth()->user()->isAdmin())) {
            // Show all articles except archived
            $articlesQuery->whereIn('status', ['published', 'draft', 'pending']);
        } else {
            $articlesQuery->published();
        }

        $latestArticles = (clone $articlesQuery)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        // Most popular (all-time, published only for everyone, or all if owner/admin)
        $popularQuery = Article::where('user_id', $author->id)->with(['category']);
        if (! auth()->check() || (auth()->id() !== $author->id && ! auth()->user()->isAdmin())) {
            $popularQuery->published();
        }
        $popularArticles = (clone $popularQuery)
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // Most-written categories
        $categoryQuery = Article::where('user_id', $author->id);
        $mostCategories = (clone $categoryQuery)
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->with('category')
            ->take(5)
            ->get()
            ->pluck('total', 'category.name');

        return view('authors.show', compact(
            'author',
            'totalViews',
            'totalComments',
            'latestArticles',
            'popularArticles',
            'mostCategories'
        ));
    }
}
