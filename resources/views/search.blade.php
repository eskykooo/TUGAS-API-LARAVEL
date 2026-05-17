@extends('layouts.app')
@section('title', 'Pencarian - BlogCMS')
@section('meta_description', 'Cari artikel di BlogCMS.')

@section('content')
<section class="py-12 sm:py-16 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-10" data-aos="fade-up">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 dark:text-white">Pencarian</h1>
            <div class="w-12 h-1 bg-sky-500 rounded-full mt-2 mx-auto"></div>
        </div>
        <form action="/search" method="GET" data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari artikel, topik, atau kata kunci..."
                           class="w-full pl-12 pr-4 py-3.5 sm:py-4 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition text-base sm:text-lg shadow-sm" autofocus>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-3.5 sm:py-4 bg-sky-500 hover:bg-sky-600 text-white rounded-2xl font-semibold transition shadow-md min-h-[44px]">Cari</button>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3 mt-4 justify-center">
                <select name="category" class="flex-1 sm:flex-none px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ ($categorySlug ?? '') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->articles_count }})</option>
                    @endforeach
                </select>
                <select name="tag" class="flex-1 sm:flex-none px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" onchange="this.form.submit()">
                    <option value="">Semua Tag</option>
                    @foreach($tags as $tag)
                    <option value="{{ $tag->slug }}" {{ ($tagSlug ?? '') == $tag->slug ? 'selected' : '' }}>{{ $tag->name }} ({{ $tag->articles_count }})</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</section>

<section class="pb-12 sm:pb-16 lg:pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($query)
        <p class="text-slate-500 dark:text-slate-400 mb-6 sm:mb-8 text-sm sm:text-base" data-aos="fade-up">Menampilkan hasil untuk: <strong class="text-slate-800 dark:text-white">"{{ $query }}"</strong> ({{ $articles->total() }} hasil)</p>
        @endif

        @if($articles->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($articles as $article)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                <x-article-card :article="$article" />
            </div>
            @endforeach
        </div>
        <div class="mt-8 sm:mt-10">
            <x-pagination :paginator="$articles" />
        </div>
        @else
        <div class="text-center py-16 sm:py-20" data-aos="fade-up">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-2xl sm:text-3xl text-slate-400"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white mb-2">Tidak ada hasil</h3>
            <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto text-sm sm:text-base">Tidak ditemukan artikel dengan kata kunci "{{ $query }}". Coba kata kunci lain atau kurangi filter.</p>
            <a href="/search" class="inline-block mt-5 sm:mt-6 px-5 py-2.5 bg-sky-50 dark:bg-sky-900/20 text-sky-500 rounded-xl font-medium text-sm hover:bg-sky-500 hover:text-white transition min-h-[44px]">Reset Pencarian</a>
        </div>
        @endif
    </div>
</section>
@endsection