@extends('layouts.app')
@section('title', $article->title . ' - Nexus Gaming')
@section('meta_description', $article->excerpt ?? strip_tags(Str::limit($article->content, 160)))

@section('content')
{{-- Breadcrumb --}}
<div class="bg-dark-card border-b-2 border-dark-border">
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
<div class="relative w-full h-72 md:h-96 lg:h-[480px] overflow-hidden border-b-4 border-brutal-orange">
    @if($article->thumbnail_url)
    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover object-center">
    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/50 to-transparent"></div>
    @else
    <div class="absolute inset-0 bg-dark-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/50 to-transparent"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <i class="fas fa-gamepad text-6xl text-gray-800"></i>
    </div>
    @endif
    <div class="absolute bottom-0 left-0 right-0 z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 md:pb-10">
        <span class="tag-brutal inline-block mb-3">{{ $article->category->name }}</span>
        <h1 class="font-orbitron text-2xl md:text-4xl lg:text-5xl font-black text-white leading-tight max-w-4xl mt-2 uppercase tracking-wide">{{ $article->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-400 text-sm mt-4">
            <div class="flex items-center gap-2">
                <img src="{{ $article->user->avatarUrl(32) }}" class="w-7 h-7 rounded border-2 border-brutal-orange">
                <span class="font-bold uppercase tracking-wider">{{ $article->user->name ?? '-' }}</span>
            </div>
            <span class="font-bold uppercase tracking-wider"><i class="fas fa-calendar mr-1"></i>{{ $article->published_at?->translatedFormat('d F Y') }}</span>
            <span class="font-bold uppercase tracking-wider"><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} tayangan</span>
            <span class="font-bold uppercase tracking-wider"><i class="fas fa-clock mr-1"></i>{{ $article->reading_time ?? (ceil(str_word_count(strip_tags($article->content)) / 200) . ' menit baca') }}</span>
        </div>
    </div>
</div>

{{-- Content --}}
<section class="py-10 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            {{-- Main --}}
            <div class="lg:col-span-2">
                <div class="article-content max-w-2xl mx-auto lg:mx-0">
                    {!! $article->safe_content !!}
                </div>

                {{-- Tags --}}
                @if($article->tags->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mt-10 pt-6 border-t-2 border-dark-border max-w-2xl mx-auto lg:mx-0">
                    <span class="text-sm font-bold text-gray-400 mr-2 uppercase tracking-wider"><i class="fas fa-tags mr-1"></i>Tag:</span>
                    @foreach($article->tags as $tag)
                    <a href="/search?tag={{ $tag->slug }}" class="tag-brutal hover:bg-brutal-orange hover:text-brutal-black transition-colors">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                {{-- Share --}}
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-6 max-w-2xl mx-auto lg:mx-0" x-data="{ copied: false }">
                    <span class="text-sm font-bold text-gray-400 mr-1 uppercase tracking-wider">Bagikan:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="w-9 h-9 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-400"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-9 h-9 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-400"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="w-9 h-9 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-400"><i class="fab fa-whatsapp"></i></a>
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="w-9 h-9 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-400 relative">
                        <i class="fas fa-link"></i>
                        <span x-show="copied" x-cloak x-transition class="absolute -top-8 left-1/2 -translate-x-1/2 bg-brutal-black text-white text-xs px-2 py-1 border border-brutal-orange whitespace-nowrap font-bold uppercase tracking-wider">Tersalin!</span>
                    </button>
                </div>

                {{-- Comments --}}
                <section class="mt-10 sm:mt-12 pt-8 sm:pt-10 border-t-2 border-dark-border max-w-2xl mx-auto lg:mx-0">
                    <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white mb-6 sm:mb-8 flex items-center gap-2 uppercase tracking-wide"><i class="far fa-comments text-brutal-orange"></i> Komentar ({{ $article->comments->count() }})</h2>

                    @auth
                    <form method="POST" action="/comments" class="glass-card p-5 sm:p-6 mb-8 sm:mb-10">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <textarea name="content" rows="3" placeholder="Tulis komentar kamu..." class="input-brutal resize-none text-sm @error('content') border-brutal-red @enderror" required>{{ old('content') }}</textarea>
                        @error('content')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                        <div class="flex justify-end mt-3">
                            <button type="submit" class="btn-primary text-sm">Kirim Komentar</button>
                        </div>
                    </form>
                    @else
                    <div class="bg-dark-card border-2 border-dashed border-dark-border p-5 sm:p-6 text-center mb-8 sm:mb-10">
                        <p class="text-gray-400 font-bold uppercase tracking-wider">Silakan <a href="/login" class="text-brutal-orange hover:underline">masuk</a> untuk menambahkan komentar.</p>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="bg-brutal-black border-2 border-brutal-green text-brutal-green px-4 py-3 mb-6 text-sm font-bold uppercase tracking-wider">{{ session('success') }}</div>
                    @endif

                    <div class="space-y-4 sm:space-y-5">
                        @forelse($article->comments as $comment)
                        <div class="bg-dark-card border-2 border-dark-border p-4 sm:p-5" data-aos="fade-up">
                            <div class="flex items-start gap-3">
                                <img src="{{ $comment->user->avatarUrl(40) }}" alt="" class="w-8 h-8 sm:w-9 sm:h-9 rounded flex-shrink-0 border-2 border-brutal-orange" loading="lazy">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-bold text-sm text-white uppercase tracking-wider">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-300 mt-2 text-sm leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 sm:py-12 text-gray-500">
                            <i class="far fa-comment-dots text-3xl sm:text-4xl mb-3"></i>
                            <p class="font-bold uppercase tracking-wider">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:block space-y-8">
                <div class="glass-card p-5 sticky top-24">
                    <h3 class="font-orbitron font-bold text-white mb-4 uppercase tracking-wider text-sm">Informasi Artikel</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-bold uppercase tracking-wider">Penulis</span>
                            <span class="font-bold text-white">{{ $article->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-bold uppercase tracking-wider">Kategori</span>
                            <span class="font-bold text-brutal-orange">{{ $article->category->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-bold uppercase tracking-wider">Terbit</span>
                            <span class="font-bold text-white">{{ $article->published_at?->format('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-bold uppercase tracking-wider">Dibaca</span>
                            <span class="font-bold text-white">{{ number_format($article->views) }}x</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- Related --}}
@if($related->count() > 0)
<section class="py-12 sm:py-16 bg-dark-card border-t-4 border-brutal-orange">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white mb-6 sm:mb-8 flex items-center gap-2 uppercase tracking-wide"><i class="fas fa-link text-brutal-orange"></i> Artikel Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($related as $rel)
            <x-article-card :article="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection