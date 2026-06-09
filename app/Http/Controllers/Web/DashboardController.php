<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        $search = $request->get('search');

        $totalArticles = Article::where('user_id', $user->id)->count();
        $totalViews = Article::where('user_id', $user->id)->sum('views');
        $totalComments = Comment::whereIn('article_id', Article::where('user_id', $user->id)->pluck('id'))->count();
        $draftCount = Article::where('user_id', $user->id)->where('status', 'draft')->count();

        $articles = Article::where('user_id', $user->id)
            ->with(['category', 'tags']);

        if ($search) {
            $safe = str_replace(['%', '_'], ['\\%', '\\_'], $search);
            $articles->where(function ($q) use ($safe) {
                $q->where('title', 'like', "%{$safe}%")
                    ->orWhere('content', 'like', "%{$safe}%")
                    ->orWhere('excerpt', 'like', "%{$safe}%");
            });
        }

        $articles = $articles->latest()->paginate(10);

        return view('dashboard.index', compact(
            'totalArticles', 'totalViews', 'totalComments', 'draftCount', 'articles', 'search'
        ));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            abort(403, 'Admin tidak dapat membuat artikel.');
        }

        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        return view('dashboard.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            abort(403, 'Admin tidak dapat membuat artikel.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:100000',
            'excerpt' => 'nullable|string',
            'thumbnail' => ImageHelper::VALIDATION_RULES(true),
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,pending',
        ]);

        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        $data['user_id'] = auth()->id();

        if ($data['status'] === 'published') {
            $data['status'] = 'pending';
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = ImageHelper::uploadAndConvertToWebp($request->file('thumbnail'));
        }

        $article = Article::create($data);

        if ($request->filled('tags')) {
            $article->tags()->attach($request->tags);
        }

        $msg = $data['status'] === 'pending'
            ? 'Artikel berhasil dikirim dan menunggu persetujuan admin.'
            : 'Artikel berhasil disimpan sebagai draft.';

        return redirect('/dashboard')->with('success', $msg);
    }

    public function edit($id)
    {
        if (auth()->user()->isAdmin()) {
            abort(403, 'Admin tidak dapat mengedit artikel.');
        }

        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        return view('dashboard.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->isAdmin()) {
            abort(403, 'Admin tidak dapat mengedit artikel.');
        }

        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:100000',
            'excerpt' => 'nullable|string',
            'thumbnail' => ImageHelper::VALIDATION_RULES(),
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,pending',
        ]);

        if ($data['status'] === 'published') {
            $data['status'] = 'pending';
        }

        if ($data['status'] === 'pending' && $article->status !== 'pending' && $article->status !== 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = ImageHelper::uploadAndConvertToWebp($request->file('thumbnail'));
        }

        $article->update($data);

        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }

        return redirect('/dashboard')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->isAdmin()) {
            abort(403);
        }

        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function publish($id)
    {
        if (auth()->user()->isAdmin()) {
            abort(403);
        }

        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $article->update([
            'status' => 'pending',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Artikel berhasil dikirim untuk persetujuan admin.');
    }

    public function storeComment(Request $request)
    {
        if ($request->filled('website')) {
            return back();
        }

        $data = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string|min:3|max:2000',
        ]);

        $duplicate = Comment::where('user_id', auth()->id())
            ->where('content', $data['content'])
            ->where('article_id', $data['article_id'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'Komentar duplikat terdeteksi. Harap tunggu sebelum mengirim lagi.');
        }

        Comment::create([
            'article_id' => $data['article_id'],
            'user_id' => auth()->id(),
            'content' => strip_tags($data['content']),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Komentar berhasil dikirim dan sedang menunggu moderasi.');
    }
}
