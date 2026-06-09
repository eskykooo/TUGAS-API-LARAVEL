<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalArticles = Article::count();
        $totalComments = Comment::count();
        $pendingComments = Comment::where('status', 'pending')->count();
        $draftCount = Article::where('status', 'draft')->count();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalArticles', 'totalComments', 'pendingComments', 'draftCount'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);

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

    public function comments()
    {
        $comments = Comment::with(['user', 'article'])->latest()->paginate(20);

        return view('admin.comments', compact('comments'));
    }

    public function approveComment($id)
    {
        Comment::where('id', $id)->update(['status' => 'approved']);

        return back()->with('success', 'Komentar berhasil disetujui.');
    }

    public function rejectComment($id)
    {
        Comment::where('id', $id)->update(['status' => 'rejected']);

        return back()->with('success', 'Komentar berhasil ditolak.');
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

    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
