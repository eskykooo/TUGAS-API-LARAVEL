<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function index(string $articleId): JsonResponse
    {
        $comments = Comment::where('article_id', $articleId)
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->get();

        return $this->success($comments, 'Komentar berhasil diambil');
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';

        $comment = Comment::create($data);
        $comment->load('user');

        return $this->success($comment, 'Komentar berhasil ditambahkan (menunggu approve)', 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return $this->error('Anda tidak memiliki akses', 403);
        }

        $request->validate(['content' => 'required|string|min:3']);

        $comment->update([
            'content' => $request->content,
            'status' => 'pending',
        ]);

        return $this->success($comment, 'Komentar berhasil diperbarui');
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
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
        $comments = Comment::with(['article', 'user'])->latest()->get();

        return $this->success($comments, 'Semua komentar berhasil diambil');
    }
}
