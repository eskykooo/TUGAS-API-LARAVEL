<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('footerArticles', Article::published()
                ->latest('published_at')
                ->take(3)
                ->get());
        });

        View::composer('admin.partials.sidebar', function ($view) {
            $view->with('sidebarCounts', [
                'pendingArticles' => Article::where('status', 'pending')->count(),
                'pendingComments' => Comment::where('status', 'pending')->count(),
                'totalUsers' => User::count(),
                'onlineUsers' => User::where('created_at', '>=', now()->subDay())->count(),
                'totalArticles' => Article::count(),
                'totalCategories' => Category::count(),
                'totalTags' => Tag::count(),
                'draftArticles' => Article::where('status', 'draft')->count(),
                'totalComments' => Comment::count(),
                'appVersion' => '2.1.0',
                'phpVersion' => PHP_VERSION,
                'laravelVersion' => app()->version(),
            ]);
        });
    }
}
