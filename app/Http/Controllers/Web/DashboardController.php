<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalArticles = Article::where('user_id', $user->id)->count();
        $totalViews = Article::where('user_id', $user->id)->sum('views');
        $totalComments = Comment::whereIn('article_id', Article::where('user_id', $user->id)->pluck('id'))->count();
        $draftCount = Article::where('user_id', $user->id)->where('status', 'draft')->count();

        $articles = Article::where('user_id', $user->id)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        return view('dashboard.index', compact(
            'totalArticles', 'totalViews', 'totalComments', 'draftCount', 'articles'
        ));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();
        return view('dashboard.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['user_id'] = auth()->id();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article = Article::create($data);

        if ($request->filled('tags')) {
            $article->tags()->attach($request->tags);
        }

        $msg = $data['status'] === 'published'
            ? 'Artikel berhasil diterbitkan!'
            : 'Artikel berhasil disimpan sebagai draft.';
        return redirect('/dashboard')->with('success', $msg);
    }

    public function edit($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();
        return view('dashboard.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published',
        ]);

        if ($data['status'] === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);

        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }

        return redirect('/dashboard')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function publish($id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        return back()->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function storeComment(Request $request)
    {
        $data = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string|min:3',
        ]);

        Comment::create([
            'article_id' => $data['article_id'],
            'user_id' => auth()->id(),
            'content' => $data['content'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Komentar berhasil dikirim dan sedang menunggu moderasi.');
    }
}
