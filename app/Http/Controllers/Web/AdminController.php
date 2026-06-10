<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalArticles = Article::count();
        $draftCount = Article::where('status', 'draft')->count();
        $publishedCount = Article::where('status', 'published')->count();

        $prevMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $userGrowth = $prevMonthUsers > 0 ? round((($totalUsers - $prevMonthUsers) / $prevMonthUsers) * 100) : 100;

        $prevMonthArticles = Article::where('created_at', '<', now()->subMonth())->count();
        $articleGrowth = $prevMonthArticles > 0 ? round((($totalArticles - $prevMonthArticles) / $prevMonthArticles) * 100) : 100;

        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[] = [
                'date' => $date,
                'label' => now()->subDays($i)->format('d M'),
                'articles' => Article::whereDate('created_at', $date)->count(),
                'users' => User::whereDate('created_at', $date)->count(),
            ];
        }

        $recentArticles = Article::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $newUsers = User::latest()->take(5)->get();

        $recentArticles_ = Article::latest()->take(5)->get()
            ->map(fn ($a) => [
                'type' => 'article',
                'user' => $a->user,
                'description' => 'Membuat artikel "'.Str::limit($a->title, 40).'"',
                'time' => $a->created_at,
                'icon' => 'fas fa-newspaper',
                'color' => 'green',
            ]);

        $recentUsers = User::latest()->take(5)->get()
            ->map(fn ($u) => [
                'type' => 'user',
                'user' => $u,
                'description' => 'Pengguna baru "'.$u->name.'" mendaftar',
                'time' => $u->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'purple',
            ]);

        $activities = $recentArticles_
            ->concat($recentUsers)
            ->sortByDesc('time')
            ->take(10);

        return view('admin.dashboard', compact(
            'totalUsers', 'totalArticles',
            'draftCount', 'publishedCount',
            'userGrowth', 'articleGrowth',
            'chartData', 'recentArticles',
            'newUsers', 'activities'
        ));
    }

    public function comments()
    {
        $comments = Comment::with(['article', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.comments', compact('comments'));
    }

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function rejectComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'rejected']);

        return back()->with('success', 'Komentar berhasil ditolak.');
    }

    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function categories()
    {
        $categories = Category::withCount('articles')->latest()->paginate(20);

        return view('admin.categories', compact('categories'));
    }

    public function tags()
    {
        $tags = Tag::withCount('articles')->latest()->paginate(20);

        return view('admin.tags', compact('tags'));
    }

    public function notifications()
    {
        $pendingArticles = Article::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        $pendingComments = Comment::where('status', 'pending')
            ->with(['user', 'article'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.notifications', compact('pendingArticles', 'pendingComments'));
    }

    public function activity()
    {
        $recentArticles = Article::with('user')->latest()->take(20)->get()
            ->map(fn ($a) => [
                'type' => 'article',
                'user' => $a->user,
                'description' => 'Membuat artikel "'.Str::limit($a->title, 40).'"',
                'time' => $a->created_at,
                'icon' => 'fas fa-newspaper',
                'color' => 'orange',
            ]);

        $recentUsers = User::latest()->take(20)->get()
            ->map(fn ($u) => [
                'type' => 'user',
                'user' => $u,
                'description' => 'Pengguna baru "'.$u->name.'" mendaftar',
                'time' => $u->created_at,
                'icon' => 'fas fa-user-plus',
                'color' => 'blue',
            ]);

        $recentComments = Comment::with('user')->latest()->take(20)->get()
            ->map(fn ($c) => [
                'type' => 'comment',
                'user' => $c->user,
                'description' => 'Mengirim komentar baru',
                'time' => $c->created_at,
                'icon' => 'fas fa-comment',
                'color' => 'green',
            ]);

        $activities = $recentArticles
            ->concat($recentUsers)
            ->concat($recentComments)
            ->sortByDesc('time')
            ->take(50);

        return view('admin.activity', compact('activities'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function users()
    {
        $users = User::withCount('articles')->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function articles(Request $request)
    {
        $articles = Article::with(['user', 'category']);

        if ($search = $request->get('search')) {
            $safe = str_replace(['%', '_'], ['\\%', '\\_'], $search);
            $articles->where(function ($q) use ($safe) {
                $q->where('title', 'like', "%{$safe}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$safe}%"));
            });
        }

        $articles = $articles->latest()->paginate(20);

        return view('admin.articles', compact('articles', 'search'));
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function approveArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Artikel berhasil disetujui dan diterbitkan.');
    }

    public function security()
    {
        return view('admin.security');
    }

    public function updateSecurity(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update(['password' => Hash::make($data['password'])]);

        return redirect('/admin/security')->with('success', 'Password berhasil diperbarui!');
    }
}
