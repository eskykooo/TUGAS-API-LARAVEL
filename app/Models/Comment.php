<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'content',
        'status',
        'parent_id',
        'reactions',
    ];

    protected $casts = [
        'reactions' => 'array',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies', 'user');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function toggleReaction(string $reaction, int $userId): void
    {
        $reactions = $this->reactions ?? [];
        $reactions[$reaction] = $reactions[$reaction] ?? [];

        $index = array_search($userId, $reactions[$reaction]);
        if ($index !== false) {
            array_splice($reactions[$reaction], $index, 1);
            if (empty($reactions[$reaction])) {
                unset($reactions[$reaction]);
            }
        } else {
            $reactions[$reaction][] = $userId;
        }

        $this->reactions = $reactions;
        $this->save();
    }

    public function hasReacted(string $reaction, int $userId): bool
    {
        $reactions = $this->reactions ?? [];

        return in_array($userId, $reactions[$reaction] ?? []);
    }

    public function reactionCounts(): array
    {
        $reactions = $this->reactions ?? [];
        $counts = [];
        foreach ($reactions as $key => $users) {
            $counts[$key] = count($users);
        }

        return $counts;
    }
}
