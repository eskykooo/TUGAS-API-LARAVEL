@extends('layouts.app')
@section('title', $article->title . ' - BlogCMS')
@section('meta_description', $article->excerpt ?? strip_tags(Str::limit($article->content, 160)))

@section('content')
{{-- Breadcrumb (di luar hero, di atas) --}}
<div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-3">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 flex-wrap">
            <a href="/" class="hover:text-sky-500 transition-colors whitespace-nowrap">Beranda</a>
            <span class="text-slate-300 dark:text-slate-600">/</span>
            <a href="/categories/{{ $article->category->slug }}" class="hover:text-sky-500 transition-colors whitespace-nowrap">{{ $article->category->name }}</a>
            <span class="text-slate-300 dark:text-slate-600">/</span>
            <span class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-[200px] sm:max-w-xs">{{ $article->title }}</span>
        </nav>
    </div>
</div>

{{-- Hero Image --}}
<div class="relative w-full h-72 md:h-96 lg:h-[480px] overflow-hidden">
    <img src="https://picsum.photos/seed/{{ $article->slug }}/1600/900"
         alt="{{ $article->title }}"
         class="absolute inset-0 w-full h-full object-cover object-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 md:pb-10">
        <span class="inline-block px-3 py-1 bg-sky-500 text-white text-xs font-bold rounded-full mb-3 uppercase tracking-wider">{{ $article->category->name }}</span>
        <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight max-w-4xl mt-2">{{ $article->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-slate-300 text-sm mt-4">
            <div class="flex items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'A') }}&background=0ea5e9&color=fff&size=32" class="w-7 h-7 rounded-full">
                <span>{{ $article->user->name ?? '-' }}</span>
            </div>
            <span><i class="fas fa-calendar mr-1"></i>{{ $article->published_at?->translatedFormat('d F Y') }}</span>
            <span><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} tayangan</span>
            <span><i class="fas fa-clock mr-1"></i>{{ $article->reading_time ?? (ceil(str_word_count(strip_tags($article->content)) / 200) . ' menit baca') }}</span>
        </div>
    </div>
</div>

{{-- Content --}}
<section class="py-10 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            {{-- Main --}}
            <div class="lg:col-span-2">
                {{-- Article Body --}}
                <div class="prose prose-slate dark:prose-invert max-w-2xl mx-auto lg:mx-0 prose-headings:font-bold prose-headings:text-slate-800 dark:prose-headings:text-slate-100 prose-p:text-slate-600 dark:prose-p:text-slate-300 prose-p:leading-relaxed prose-a:text-sky-500 prose-a:no-underline hover:prose-a:underline prose-code:bg-slate-100 dark:prose-code:bg-slate-800 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-sm prose-img:rounded-xl prose-img:mx-auto prose-blockquote:border-sky-500 prose-blockquote:bg-slate-50 dark:prose-blockquote:bg-slate-800/50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:not-italic prose-strong:text-slate-800 dark:prose-strong:text-slate-100 prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4 prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3 prose-pre:bg-slate-900 dark:prose-pre:bg-slate-950 prose-pre:rounded-xl prose-pre:text-sm">
                    {!! $article->content !!}
                </div>

                {{-- Tags --}}
                @if($article->tags->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mt-10 pt-6 border-t border-slate-200 dark:border-slate-700 max-w-2xl mx-auto lg:mx-0">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 mr-2"><i class="fas fa-tags mr-1"></i>Tag:</span>
                    @foreach($article->tags as $tag)
                    <a href="/search?tag={{ $tag->slug }}" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-sky-500 hover:text-white transition text-sm">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                {{-- Share --}}
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-6 max-w-2xl mx-auto lg:mx-0" x-data="{ copied: false }">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 mr-1">Bagikan:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-blue-500 hover:text-white transition flex items-center justify-center text-slate-600 dark:text-slate-300"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center text-slate-600 dark:text-slate-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-green-500 hover:text-white transition flex items-center justify-center text-slate-600 dark:text-slate-300"><i class="fab fa-whatsapp"></i></a>
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-700 hover:bg-sky-500 hover:text-white transition flex items-center justify-center text-slate-600 dark:text-slate-300 relative">
                        <i class="fas fa-link"></i>
                        <span x-show="copied" x-cloak x-transition class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap">Tersalin!</span>
                    </button>
                </div>

                {{-- Comments --}}
                <section class="mt-10 sm:mt-12 pt-8 sm:pt-10 border-t border-slate-200 dark:border-slate-700 max-w-2xl mx-auto lg:mx-0">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white mb-6 sm:mb-8 flex items-center gap-2"><i class="far fa-comments text-sky-500"></i> Komentar ({{ $article->comments->count() }})</h2>

                    @auth
                    <form method="POST" action="/comments" class="bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 dark:border-slate-700 mb-8 sm:mb-10">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <textarea name="content" rows="3" placeholder="Tulis komentar kamu..." class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none resize-none text-sm transition @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
                        @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <div class="flex justify-end mt-3">
                            <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-medium text-sm transition min-h-[44px]">Kirim Komentar</button>
                        </div>
                    </form>
                    @else
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-5 sm:p-6 text-center mb-8 sm:mb-10 border border-dashed border-slate-200 dark:border-slate-700">
                        <p class="text-slate-500 dark:text-slate-400">Silakan <a href="/login" class="text-sky-500 font-semibold hover:underline">masuk</a> untuk menambahkan komentar.</p>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
                    @endif

                    <div class="space-y-4 sm:space-y-5">
                        @forelse($article->comments as $comment)
                        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700" data-aos="fade-up">
                            <div class="flex items-start gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? 'A') }}&background=0ea5e9&color=fff&size=40" alt="" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex-shrink-0" loading="lazy">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-semibold text-sm text-slate-800 dark:text-white">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 sm:py-12 text-slate-400">
                            <i class="far fa-comment-dots text-3xl sm:text-4xl mb-3"></i>
                            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:block space-y-8">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 sticky top-24">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4">Informasi Artikel</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Penulis</span>
                            <span class="font-medium text-slate-800 dark:text-white">{{ $article->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kategori</span>
                            <span class="font-medium text-sky-500">{{ $article->category->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Diterbitkan</span>
                            <span class="font-medium text-slate-800 dark:text-white">{{ $article->published_at?->format('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Dibaca</span>
                            <span class="font-medium text-slate-800 dark:text-white">{{ number_format($article->views) }}x</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- Related --}}
@if($related->count() > 0)
<section class="py-12 sm:py-16 bg-slate-100 dark:bg-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white mb-6 sm:mb-8 flex items-center gap-2"><i class="fas fa-link text-sky-500"></i> Artikel Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($related as $rel)
            <x-article-card :article="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection