@extends('layouts.app')
@section('title', $article->title . ' - Nexus Gaming')
@section('meta_description', $article->excerpt ?? strip_tags(Str::limit($article->content, 160)))

@push('scripts')
<script>
    // Reading progress for sidebar
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarProgress = document.getElementById('sidebar-progress-fill');
        const sidebarPct = document.getElementById('sidebar-progress-pct');
        if (!sidebarProgress) return;

        window.addEventListener('scroll', function () {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const pct = docHeight > 0 ? Math.min(Math.round((scrollTop / docHeight) * 100), 100) : 0;
            sidebarProgress.style.width = pct + '%';
            if (sidebarPct) sidebarPct.textContent = pct + '%';
        });
    });

    // Reply toggle
    function toggleReply(formId) {
        const form = document.getElementById('reply-form-' + formId);
        if (form) {
            form.classList.toggle('is-open');
            if (form.classList.contains('is-open')) {
                form.querySelector('textarea')?.focus();
            }
        }
    }
</script>
@endpush

@section('content')
{{-- Breadcrumb --}}
<div class="bg-dark-card border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <a href="/" class="hover:text-brutal-orange transition-colors font-bold uppercase tracking-wider whitespace-nowrap">Beranda</a>
            <span class="text-gray-600">/</span>
            <a href="/categories/{{ $article->category->slug }}" class="hover:text-brutal-orange transition-colors font-bold uppercase tracking-wider whitespace-nowrap">{{ $article->category->name }}</a>
            <span class="text-gray-600">/</span>
            <span class="text-gray-400 font-bold truncate max-w-[200px] sm:max-w-xs uppercase tracking-wider">{{ $article->title }}</span>
        </nav>
    </div>
</div>

{{-- Hero --}}
<div class="relative w-full h-72 md:h-96 lg:h-[520px] overflow-hidden border-b border-white/5">
    @if($article->thumbnail_url)
    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover object-center">
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-dark-card to-dark-bg"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <i class="fas fa-gamepad text-7xl text-gray-800/50"></i>
    </div>
    @endif
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute bottom-0 left-0 right-0 z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 md:pb-12">
        <div class="flex flex-wrap items-center gap-2 mb-3">
            <span class="tag-brutal text-[10px]">{{ $article->category->name }}</span>
            <span class="read-time-badge"><i class="far fa-clock"></i>{{ $article->reading_time ?? (ceil(str_word_count(strip_tags($article->content)) / 200) . ' menit') }}</span>
        </div>
        <h1 class="font-orbitron text-2xl md:text-4xl lg:text-5xl font-black text-white leading-tight max-w-4xl uppercase tracking-wide">{{ $article->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-400 text-sm mt-4">
            <div class="flex items-center gap-2">
                <img src="{{ $article->user->avatarUrl(32) }}" class="w-7 h-7 rounded border border-brutal-orange/50">
                <span class="font-bold uppercase tracking-wider text-gray-300">{{ $article->user->name ?? '-' }}</span>
            </div>
            <span class="font-bold uppercase tracking-wider text-gray-500"><i class="far fa-calendar mr-1.5"></i>{{ $article->published_at?->translatedFormat('d F Y') }}</span>
            <span class="font-bold uppercase tracking-wider text-gray-500"><i class="far fa-eye mr-1.5"></i>{{ number_format($article->views) }} tayangan</span>
            <span class="font-bold uppercase tracking-wider text-gray-500"><i class="far fa-comment mr-1.5"></i>{{ $totalComments }} komentar</span>
        </div>
    </div>
</div>

{{-- Content Section --}}
<section class="py-10 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-[1fr_300px] lg:gap-10 xl:gap-14">
            {{-- Main Content --}}
            <div class="min-w-0">
                <article class="article-premium max-w-3xl mx-auto lg:mx-0">
                    {!! $article->safe_content !!}
                </article>

                {{-- Tags --}}
                @if($article->tags->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mt-12 pt-6 border-t border-white/5 max-w-3xl mx-auto lg:mx-0">
                    <span class="text-xs font-bold text-gray-500 mr-1 uppercase tracking-wider"><i class="fas fa-tags mr-1"></i>Tag:</span>
                    @foreach($article->tags as $tag)
                    <a href="/search?tag={{ $tag->slug }}" class="tag-brutal hover:bg-brutal-orange hover:text-brutal-black transition-colors text-[10px]">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                {{-- Share --}}
                <div class="flex flex-wrap items-center gap-2 mt-6 max-w-3xl mx-auto lg:mx-0" x-data="{ copied: false }">
                    <span class="text-xs font-bold text-gray-500 mr-1 uppercase tracking-wider">Bagikan:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="btn-share"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="btn-share"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="btn-share"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.reddit.com/submit?url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="btn-share"><i class="fab fa-reddit-alien"></i></a>
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="btn-share relative">
                        <i class="fas fa-link"></i>
                        <span x-show="copied" x-cloak x-transition class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] px-2 py-1 border border-brutal-orange whitespace-nowrap font-bold uppercase tracking-wider">Tersalin!</span>
                    </button>
                </div>

                {{-- Author Box --}}
                @php $authorArticlesCount = $article->user->articles()->published()->count(); @endphp
                <div class="max-w-3xl mx-auto lg:mx-0 mt-12">
                    <hr class="section-divider mb-8">
                    <div class="author-box">
                        <div class="flex items-start gap-4 sm:gap-5">
                            <a href="/authors/{{ $article->user->id }}" class="flex-shrink-0 group">
                                <img src="{{ $article->user->avatarUrl(72) }}" alt="{{ $article->user->name }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl border-2 border-brutal-orange/20 flex-shrink-0 group-hover:border-brutal-orange/50 transition-all duration-300">
                            </a>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <a href="/authors/{{ $article->user->id }}" class="font-orbitron font-bold text-sm text-white hover:text-brutal-orange transition-colors uppercase tracking-wider">{{ $article->user->name }}</a>
                                    @if($article->user->isAdmin())
                                    <span class="role-badge admin"><i class="fas fa-crown"></i> Admin</span>
                                    @elseif($article->user->role === 'editor')
                                    <span class="role-badge editor"><i class="fas fa-edit"></i> Editor</span>
                                    @elseif($article->user->role === 'author')
                                    <span class="role-badge author"><i class="fas fa-pen-fancy"></i> Author</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 leading-relaxed">
                                    Penulis artikel ini. {{ $authorArticlesCount > 0 ? 'Telah menulis ' . $authorArticlesCount . ' artikel di Nexus Gaming.' : '' }}
                                </p>
                                <div class="flex items-center gap-3 mt-3">
                                    <a href="/authors/{{ $article->user->id }}" class="btn-primary text-[10px] px-3 py-1.5"><i class="fas fa-user mr-1"></i>Lihat Profil</a>
                                    <a href="/authors/{{ $article->user->id }}?page=1" class="text-xs font-bold text-gray-500 hover:text-brutal-orange transition-colors uppercase tracking-wider"><i class="fas fa-arrow-right mr-1"></i>{{ $authorArticlesCount }} Artikel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Comments --}}
                <section class="max-w-3xl mx-auto lg:mx-0 mt-12 scroll-offset" id="komentar">
                    <hr class="section-divider mb-8">
                    <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white mb-8 flex items-center gap-2 uppercase tracking-wide">
                        <i class="fas fa-comments text-brutal-orange text-lg"></i>
                        Komentar ({{ $totalComments }})
                    </h2>

                    @auth
                    <form method="POST" action="/comments" class="card-glow p-5 sm:p-6 mb-8">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <div class="flex items-start gap-3">
                            <img src="{{ auth()->user()->avatarUrl(36) }}" alt="" class="w-8 h-8 sm:w-9 sm:h-9 rounded border border-brutal-orange/30 flex-shrink-0 mt-1">
                            <div class="flex-1">
                                <textarea name="content" rows="3" placeholder="Tulis komentar kamu..." class="input-brutal resize-none text-sm @error('content') border-brutal-red @enderror" required>{{ old('content') }}</textarea>
                                @error('content')<p class="text-brutal-red text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                                <div class="flex justify-end mt-3">
                                    <button type="submit" class="btn-primary text-xs px-4 py-2">Kirim Komentar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="card-glow p-6 text-center mb-8">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-brutal-orange/10 border border-brutal-orange/20 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt text-brutal-orange text-xl"></i>
                        </div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Silakan <a href="/login" class="text-brutal-orange hover:underline">masuk</a> untuk menambahkan komentar.</p>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="bg-black/50 border border-brutal-green/30 text-brutal-green px-4 py-3 mb-6 text-xs font-bold uppercase tracking-wider rounded-lg flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-black/50 border border-brutal-red/30 text-brutal-red px-4 py-3 mb-6 text-xs font-bold uppercase tracking-wider rounded-lg flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                    @endif

                    {{-- Comment List --}}
                    <div class="space-y-4">
                        @forelse($article->comments as $comment)
                        @include('articles._comment', ['comment' => $comment, 'article' => $article, 'level' => 0])
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                                <i class="far fa-comment-dots text-2xl text-gray-600"></i>
                            </div>
                            <p class="font-bold uppercase tracking-wider text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sticky Sidebar --}}
            <aside class="hidden lg:block">
                <div class="sidebar-premium">
                    {{-- Author Card --}}
                    @php $authorArticlesCount = $article->user->articles()->published()->count(); @endphp
                    <div class="card-glow p-5 mb-5">
                        <div class="flex items-center gap-3 mb-4">
                            <a href="/authors/{{ $article->user->id }}">
                                <img src="{{ $article->user->avatarUrl(48) }}" alt="{{ $article->user->name }}" class="w-11 h-11 rounded-lg border-2 border-brutal-orange/20 flex-shrink-0 hover:border-brutal-orange/50 transition-all duration-300">
                            </a>
                            <div class="min-w-0">
                                <p class="font-orbitron font-bold text-white text-xs uppercase tracking-wider truncate">Ditulis oleh</p>
                                <a href="/authors/{{ $article->user->id }}" class="font-bold text-sm text-brutal-orange hover:text-white truncate uppercase tracking-wider transition-colors">{{ $article->user->name }}</a>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                @if($article->user->isAdmin())
                                <span class="role-badge admin text-[9px]"><i class="fas fa-crown"></i> Admin</span>
                                @elseif($article->user->role === 'editor')
                                <span class="role-badge editor text-[9px]"><i class="fas fa-edit"></i> Editor</span>
                                @elseif($article->user->role === 'author')
                                <span class="role-badge author text-[9px]"><i class="fas fa-pen-fancy"></i> Author</span>
                                @endif
                            </div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $authorArticlesCount }} artikel</span>
                        </div>
                        <a href="/authors/{{ $article->user->id }}" class="mt-3 block w-full text-center bg-brutal-orange/10 border border-brutal-orange/20 hover:bg-brutal-orange/20 transition-colors rounded-lg py-2 text-[10px] font-bold text-brutal-orange uppercase tracking-wider">
                            <i class="fas fa-user mr-1"></i> Lihat Profil
                        </a>
                    </div>

                    {{-- Article Info --}}
                    <div class="card-glow p-5 mb-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-brutal-orange text-[10px]"></i> Informasi Artikel
                        </h4>
                        <div class="space-y-1">
                            <div class="sidebar-stat">
                                <div class="sidebar-stat-icon"><i class="fas fa-folder"></i></div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Kategori</p>
                                    <p class="text-xs font-bold text-brutal-orange uppercase tracking-wider">{{ $article->category->name }}</p>
                                </div>
                            </div>
                            <div class="sidebar-stat">
                                <div class="sidebar-stat-icon"><i class="far fa-calendar"></i></div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Dipublikasi</p>
                                    <p class="text-xs font-bold text-white uppercase tracking-wider">{{ $article->published_at?->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="sidebar-stat">
                                <div class="sidebar-stat-icon"><i class="far fa-clock"></i></div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Waktu Baca</p>
                                    <p class="text-xs font-bold text-white uppercase tracking-wider">{{ $article->reading_time ?? (ceil(str_word_count(strip_tags($article->content)) / 200) . ' menit') }}</p>
                                </div>
                            </div>
                            <div class="sidebar-stat">
                                <div class="sidebar-stat-icon"><i class="far fa-eye"></i></div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Total Tayangan</p>
                                    <p class="text-xs font-bold text-white uppercase tracking-wider">{{ number_format($article->views) }}</p>
                                </div>
                            </div>
                            <div class="sidebar-stat">
                                <div class="sidebar-stat-icon"><i class="far fa-comment"></i></div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Komentar</p>
                                    <p class="text-xs font-bold text-white uppercase tracking-wider">{{ $totalComments }} komentar</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Reading Progress --}}
                    <div class="card-glow p-5 mb-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                            <i class="fas fa-book-open text-brutal-orange text-[10px]"></i> Progress Membaca
                        </h4>
                        <div class="sidebar-progress-track">
                            <div class="sidebar-progress-fill" id="sidebar-progress-fill"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Kemajuan</span>
                            <span class="text-[11px] font-bold text-brutal-orange" id="sidebar-progress-pct">0%</span>
                        </div>
                    </div>

                    {{-- Share --}}
                    <div class="card-glow p-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-share-alt text-brutal-orange text-[10px]"></i> Bagikan
                        </h4>
                        <div class="flex flex-wrap gap-2" x-data="{ copied: false }">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="btn-share w-9 h-9 text-xs"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="btn-share w-9 h-9 text-xs"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="btn-share w-9 h-9 text-xs"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://www.reddit.com/submit?url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="btn-share w-9 h-9 text-xs"><i class="fab fa-reddit-alien"></i></a>
                            <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="btn-share w-9 h-9 text-xs relative">
                                <i class="fas fa-link"></i>
                                <span x-show="copied" x-cloak x-transition class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-[9px] px-2 py-1 border border-brutal-orange whitespace-nowrap font-bold uppercase tracking-wider">Tersalin!</span>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- Related Articles --}}
@if($related->count() > 0)
<section class="py-14 sm:py-18 bg-dark-card border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white flex items-center gap-2 uppercase tracking-wide">
                <i class="fas fa-link text-brutal-orange"></i> Artikel Terkait
            </h2>
            <a href="/categories/{{ $article->category->slug }}" class="text-xs font-bold text-brutal-orange hover:text-white transition-colors uppercase tracking-wider flex items-center gap-1">
                Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($related as $rel)
            <x-article-card :article="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
