@php
$reactions = $comment->reactionCounts();
$totalReactions = array_sum($reactions);
$reactionIcons = [
    'like' => 'fa-thumbs-up',
    'love' => 'fa-heart',
    'laugh' => 'fa-face-laugh-squint',
    'wow' => 'fa-face-surprise',
    'sad' => 'fa-face-sad-tear',
    'angry' => 'fa-face-angry',
];
$reactionLabels = [
    'like' => 'Suka',
    'love' => 'Cinta',
    'laugh' => 'Lucu',
    'wow' => 'Wow',
    'sad' => 'Sedih',
    'angry' => 'Marah',
];
$isOwner = auth()->check() && $comment->user_id === auth()->id();
$isArticleAuthor = $article->user_id === $comment->user_id;
@endphp

<div class="comment-card p-4 sm:p-5 {{ $level > 0 ? 'is-reply ml-4 sm:ml-6 md:ml-8 border-l-2 border-brutal-orange/10' : '' }}" data-aos="fade-up" data-aos-delay="{{ min($level * 50, 200) }}" x-data="{ replyOpen: false, showReplies: true }">
    <div class="flex items-start gap-3">
        <img src="{{ $comment->user->avatarUrl(40) }}" alt="" class="w-8 h-8 sm:w-9 sm:h-9 rounded border border-brutal-orange/20 flex-shrink-0" loading="lazy">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="font-bold text-sm text-white uppercase tracking-wider">{{ $comment->user->name }}</span>
                @if($isArticleAuthor)
                <span class="role-badge admin text-[9px]"><i class="fas fa-pen-fancy"></i> Penulis</span>
                @elseif($comment->user->isAdmin())
                <span class="role-badge admin text-[9px]"><i class="fas fa-crown"></i> Admin</span>
                @elseif($comment->user->role === 'editor')
                <span class="role-badge editor text-[9px]"><i class="fas fa-edit"></i> Editor</span>
                @endif
                <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-300 mt-1.5 text-sm leading-relaxed">{{ $comment->content }}</p>

            {{-- Actions --}}
            <div class="flex items-center gap-2 mt-2.5 flex-wrap">
                {{-- Reactions --}}
                @auth
                <form method="POST" action="/comments/{{ $comment->id }}/react" class="inline-flex items-center gap-1">
                    @csrf
                    <input type="hidden" name="reaction" value="like">
                    <button type="submit" class="reaction-btn text-[10px] {{ $comment->hasReacted('like', auth()->id()) ? 'is-active' : '' }}">
                        <i class="far fa-thumbs-up"></i>
                        @if(($reactions['like'] ?? 0) > 0)<span class="reaction-count">{{ $reactions['like'] }}</span>@endif
                    </button>
                </form>
                @else
                <span class="reaction-btn text-[10px] cursor-default opacity-50"><i class="far fa-thumbs-up"></i></span>
                @endif

                {{-- Reaction summary --}}
                @if($totalReactions > 0)
                <div class="flex items-center gap-1 text-[10px] text-gray-500">
                    @foreach(['like', 'love', 'laugh', 'wow'] as $r)
                    @if(($reactions[$r] ?? 0) > 0)
                    <span class="inline-flex items-center gap-0.5"><i class="fas {{ $reactionIcons[$r] }} text-brutal-orange/70"></i>{{ $reactions[$r] }}</span>
                    @endif
                    @endforeach
                </div>
                @endif

                {{-- Reply --}}
                @auth
                @if($level < 3)
                <button @click="replyOpen = !replyOpen" class="text-[10px] font-bold text-gray-500 hover:text-brutal-orange transition-colors uppercase tracking-wider flex items-center gap-1">
                    <i class="fas fa-reply"></i> Balas
                </button>
                @endif
                @endauth

                {{-- View replies --}}
                @if($comment->replies->count() > 0)
                <button @click="showReplies = !showReplies" class="text-[10px] font-bold text-gray-500 hover:text-brutal-orange transition-colors uppercase tracking-wider flex items-center gap-1">
                    <i class="fas" :class="showReplies ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    <span x-text="showReplies ? 'Sembunyikan' : 'Tampilkan'"></span>
                    {{ $comment->replies->count() }} balasan
                </button>
                @endif
            </div>

            {{-- Reply Form --}}
            @auth
            @if($level < 3)
            <div class="mt-3" :class="replyOpen ? 'block' : 'hidden'">
                <form method="POST" action="/comments" class="flex items-start gap-2">
                    @csrf
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <img src="{{ auth()->user()->avatarUrl(28) }}" alt="" class="w-7 h-7 rounded border border-brutal-orange/20 flex-shrink-0 mt-1">
                    <div class="flex-1">
                        <textarea name="content" rows="2" placeholder="Tulis balasan..." class="input-brutal resize-none text-xs" required></textarea>
                        <div class="flex justify-end gap-2 mt-2">
                            <button type="button" @click="replyOpen = false" class="text-[10px] font-bold text-gray-500 hover:text-white transition-colors uppercase tracking-wider">Batal</button>
                            <button type="submit" class="btn-primary text-[10px] px-3 py-1.5">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </div>

    {{-- Replies --}}
    @if($comment->replies->count() > 0)
    <div x-show="showReplies" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" class="mt-3 space-y-3">
        @foreach($comment->replies as $reply)
        @include('articles._comment', ['comment' => $reply, 'article' => $article, 'level' => $level + 1])
        @endforeach
    </div>
    @endif
</div>
