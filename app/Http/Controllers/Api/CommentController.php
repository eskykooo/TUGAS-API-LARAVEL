<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function index(string $articleId): JsonResponse
    {
        $comments = Comment::where('article_id', $articleId)
            ->with('user')
            ->latest()
            ->get();

        return $this->success($comments, 'Komentar berhasil diambil');
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        if ($request->filled('website')) {
            return $this->error('Bad request', 400);
        }

        $data = $request->validated();
        $data['content'] = strip_tags($data['content']);

        $duplicate = Comment::where('user_id', $request->user()->id)
            ->where('content', $data['content'])
            ->where('article_id', $data['article_id'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->exists();

        if ($duplicate) {
            return $this->error('Komentar duplikat terdeteksi.', 429);
        }

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'approved';

        $comment = Comment::create($data);
        $comment->load('user');

        return $this->success($comment, 'Komentar berhasil ditambahkan', 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $request->validate(['content' => 'required|string|min:3|max:2000']);

        $comment->update([
            'content' => strip_tags($request->content),
        ]);

        return $this->success($comment, 'Komentar berhasil diperbarui');
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $comment->delete();

        return $this->success(null, 'Komentar berhasil dihapus');
    }

    public function approve(string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return $this->success($comment, 'Komentar berhasil diapprove');
    }

    public function adminIndex(): JsonResponse
    {
        $comments = Comment::with(['article', 'user'])->latest()->paginate(20);

        return $this->success(
            $comments->items(),
            'Semua komentar berhasil diambil',
            200,
            [
                'current_page' => $comments->currentPage(),
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'last_page' => $comments->lastPage(),
            ]
        );
    }
}
