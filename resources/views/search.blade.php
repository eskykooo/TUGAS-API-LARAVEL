@extends('layouts.app')
@section('title', $query ? "Pencarian: $query - Nexus Gaming" : 'Pencarian - Nexus Gaming')
@section('meta_description', $query ? "Hasil pencarian untuk \"$query\" di Nexus Gaming." : 'Cari artikel gaming di Nexus Gaming.')

@section('content')

@php
$catMeta = [
    'pc-gaming' => ['icon'=>'fa-desktop','color'=>'bg-brutal-orange'],
    'console' => ['icon'=>'fa-gamepad','color'=>'bg-brutal-red'],
    'mobile' => ['icon'=>'fa-mobile-alt','color'=>'bg-brutal-yellow'],
    'esports' => ['icon'=>'fa-trophy','color'=>'bg-brutal-green'],
    'gaming-news' => ['icon'=>'fa-newspaper','color'=>'bg-brutal-orange'],
    'reviews' => ['icon'=>'fa-star','color'=>'bg-brutal-blue'],
    'guides' => ['icon'=>'fa-book','color'=>'bg-brutal-purple'],
];
$activeCategory = $categories->firstWhere('slug', $categorySlug);
$activeTag = $tags->firstWhere('slug', $tagSlug);
@endphp

{{-- 1. SEARCH HEADER --}}
<section class="py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Pencarian</h1>
            <div class="w-12 h-1 bg-brutal-orange mt-2 mx-auto"></div>
        </div>

        <form action="/search" method="GET" class="max-w-3xl mx-auto">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari artikel gaming..."
                           class="input-brutal pl-10 text-sm sm:text-base">
                </div>
                <button type="submit" class="btn-primary text-sm">Cari</button>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4">
                <div class="flex flex-wrap items-center gap-1.5 flex-1 min-w-0 overflow-x-auto pb-1">
                    <a href="{{ request()->fullUrlWithQuery(['category' => '', 'page' => null]) }}"
                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] sm:text-xs font-black uppercase tracking-wider border-2 transition-all duration-150 flex-shrink-0
                       {{ !$categorySlug ? 'bg-brutal-orange text-brutal-black border-brutal-black' : 'bg-transparent text-gray-400 border-dark-border hover:border-brutal-orange hover:text-brutal-orange' }}">
                        <i class="fas fa-th-large"></i> Semua
                    </a>
                    @foreach($categories as $cat)
                    @php $meta = $catMeta[$cat->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border']; @endphp
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug, 'page' => null]) }}"
                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] sm:text-xs font-black uppercase tracking-wider border-2 transition-all duration-150 flex-shrink-0
                       {{ ($categorySlug ?? '') == $cat->slug ? 'bg-brutal-orange text-brutal-black border-brutal-black' : 'bg-transparent text-gray-400 border-dark-border hover:border-brutal-orange hover:text-brutal-orange' }}">
                        <i class="fas {{ $meta['icon'] }}"></i> {{ $cat->name }}
                    </a>
                    @endforeach
                </div>

                <div class="flex gap-2 flex-shrink-0">
                    <select name="tag" onchange="this.form.submit()"
                            class="appearance-none bg-dark-card border-2 border-dark-border text-gray-400 text-[10px] sm:text-xs font-black uppercase tracking-wider px-2.5 py-1.5 cursor-pointer hover:border-brutal-orange hover:text-brutal-orange transition-colors outline-none focus:border-brutal-orange focus:text-brutal-orange min-w-0 max-w-[130px] sm:max-w-[160px]">
                        <option value="">Semua Tag</option>
                        @foreach($tags->sortByDesc('articles_count')->take(20) as $tag)
                        <option value="{{ $tag->slug }}" {{ ($tagSlug ?? '') == $tag->slug ? 'selected' : '' }}>#{{ $tag->name }} ({{ $tag->articles_count }})</option>
                        @endforeach
                    </select>

                    <select name="sort" onchange="this.form.submit()"
                            class="appearance-none bg-dark-card border-2 border-dark-border text-gray-400 text-[10px] sm:text-xs font-black uppercase tracking-wider px-2.5 py-1.5 cursor-pointer hover:border-brutal-orange hover:text-brutal-orange transition-colors outline-none focus:border-brutal-orange focus:text-brutal-orange">
                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="trending" {{ $sort == 'trending' ? 'selected' : '' }}>Trending</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- 2. RESULTS --}}
<section class="pb-8 sm:pb-10 lg:pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Results Info Bar --}}
        <div class="flex flex-wrap items-center gap-2 mb-5 sm:mb-6">
            <div class="flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-gray-500">
                @if($articles->total() > 0)
                <span class="text-white">{{ $articles->total() }}</span> hasil ditemukan
                @if($query)
                untuk "<span class="text-brutal-orange">{{ $query }}</span>"
                @endif
                @else
                Tidak ada hasil ditemukan
                @if($query)
                untuk "<span class="text-brutal-orange">{{ $query }}</span>"
                @endif
                @endif
            </div>
            @if($activeCategory)
            <a href="{{ request()->fullUrlWithQuery(['category' => '', 'page' => null]) }}" class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-black uppercase tracking-wider bg-brutal-orange/20 text-brutal-orange border border-brutal-orange hover:bg-brutal-orange hover:text-brutal-black transition-all">
                <i class="fas {{ $catMeta[$activeCategory->slug]['icon'] ?? 'fa-folder' }}"></i>
                {{ $activeCategory->name }}
                <i class="fas fa-times ml-0.5 text-[8px]"></i>
            </a>
            @endif
            @if($activeTag)
            <a href="{{ request()->fullUrlWithQuery(['tag' => '', 'page' => null]) }}" class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-black uppercase tracking-wider bg-brutal-orange/20 text-brutal-orange border border-brutal-orange hover:bg-brutal-orange hover:text-brutal-black transition-all">
                #{{ $activeTag->name }}
                <i class="fas fa-times ml-0.5 text-[8px]"></i>
            </a>
            @endif
        </div>

        @if($articles->count() > 0)
        {{-- Results Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
            @foreach($articles as $article)
            <div>
                <x-article-card :article="$article" />
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-8 sm:mt-10">
            <x-pagination :paginator="$articles" />
        </div>
        @endif

        @else
        {{-- 3. EMPTY STATE --}}
        <div class="text-center py-10 sm:py-14 border-2 border-dark-border bg-dark-card px-4 sm:px-8">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-dark-bg border-2 border-dark-border flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-gamepad text-2xl sm:text-3xl text-gray-600"></i>
            </div>
            <h3 class="font-orbitron text-base sm:text-lg font-black text-white mb-2 uppercase tracking-wide">Hasil tidak ditemukan</h3>
            <p class="text-gray-500 max-w-md mx-auto text-xs sm:text-sm font-bold uppercase tracking-wider leading-relaxed">
                @if($query)
                Tidak ditemukan artikel dengan kata kunci "<strong class="text-gray-400"> {{ $query }} </strong>".
                @elseif($activeCategory || $activeTag)
                Tidak ditemukan artikel dengan filter yang dipilih.
                @else
                Belum ada artikel yang tersedia.
                @endif
                Coba kata kunci lain atau jelajahi kategori di bawah.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-2 mt-4">
                @if($query || $activeCategory || $activeTag)
                <a href="/search" class="btn-primary text-xs">Reset Pencarian</a>
                @endif
                <a href="/" class="btn-outline text-xs">Ke Beranda</a>
            </div>

            {{-- Category Recommendations --}}
            @if($categories->count())
            <div class="mt-8">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Jelajahi Kategori Populer</p>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    @php $sortedCats = $categories->sortByDesc('articles_count')->take(5); @endphp
                    @foreach($sortedCats as $cat)
                    @php $meta = $catMeta[$cat->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border']; @endphp
                    <a href="/search?category={{ $cat->slug }}"
                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] sm:text-xs font-black uppercase tracking-wider border-2 border-dark-border bg-dark-card text-gray-400 hover:border-brutal-orange hover:text-brutal-orange transition-all">
                        <i class="fas {{ $meta['icon'] }}"></i> {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Trending Articles --}}
            @if($trendingArticles->count())
            <div class="mt-8">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Artikel Populer Saat Ini</p>
                <div class="max-w-2xl mx-auto space-y-2">
                    @foreach($trendingArticles as $i => $ta)
                    <a href="/articles/{{ $ta->slug }}" class="flex items-center gap-3 p-2.5 bg-dark-bg border border-dark-border hover:border-brutal-orange transition-all text-left group">
                        <span class="font-orbitron text-sm sm:text-base font-black text-brutal-orange w-5 flex-shrink-0 text-center">{{ $i + 1 }}</span>
                        @if($ta->thumbnail_url)
                        <img src="{{ $ta->thumbnail_url }}" alt="" class="w-10 h-8 object-cover flex-shrink-0 border border-dark-border">
                        @endif
                        <span class="text-xs sm:text-sm text-gray-300 group-hover:text-brutal-orange transition-colors font-bold line-clamp-1 flex-1 uppercase tracking-wider">{{ $ta->title }}</span>
                        <span class="text-[10px] text-gray-600 flex-shrink-0 font-bold uppercase tracking-wider"><i class="fas fa-eye mr-0.5"></i>{{ number_format($ta->views) }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</section>

{{-- 4. TRENDING SEARCHES --}}
@if($trendingArticles->count() && $articles->count() > 0)
<section class="bg-dark-card border-y-4 border-brutal-orange py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-6 sm:mb-8">
            <div class="w-8 h-8 bg-brutal-red flex items-center justify-center flex-shrink-0 border-2 border-brutal-black">
                <i class="fas fa-fire text-brutal-black text-sm"></i>
            </div>
            <div>
                <h2 class="font-orbitron text-lg sm:text-xl lg:text-2xl font-black text-white uppercase tracking-wide">Trending Searches</h2>
                <div class="w-10 h-1 bg-brutal-red mt-1.5"></div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($trendingArticles as $ta)
            <a href="/articles/{{ $ta->slug }}" class="glass-card overflow-hidden flex flex-col group border-2 border-dark-border hover:border-brutal-red">
                <div class="relative w-full aspect-video flex-shrink-0 overflow-hidden">
                    @if($ta->thumbnail_url)
                    <img src="{{ $ta->thumbnail_url }}" alt="" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    @else
                    <div class="absolute inset-0 bg-dark-card flex items-center justify-center"><i class="fas fa-gamepad text-3xl text-gray-600"></i></div>
                    @endif
                    <span class="absolute top-2 left-2 z-10 w-6 h-6 bg-brutal-red border-2 border-brutal-black flex items-center justify-center">
                        <i class="fas fa-fire text-[10px] text-brutal-black"></i>
                    </span>
                </div>
                <div class="p-3 sm:p-4 flex flex-col flex-1">
                    <span class="text-[10px] text-brutal-red font-black uppercase tracking-wider mb-1">{{ $ta->category->name ?? '' }}</span>
                    <h3 class="font-bold text-white text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-brutal-red transition-colors">{{ $ta->title }}</h3>
                    <div class="flex items-center gap-2 mt-2 pt-2 border-t border-dark-border text-[10px] text-gray-500 font-bold uppercase tracking-wider">
                        <span><i class="fas fa-eye mr-0.5"></i>{{ number_format($ta->views) }}</span>
                        <span class="ml-auto">{{ $ta->published_at?->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 5. POPULAR CATEGORIES --}}
@if($categories->count())
<section class="py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-6 sm:mb-8">
            <div class="w-8 h-8 bg-brutal-orange flex items-center justify-center flex-shrink-0 border-2 border-brutal-black">
                <i class="fas fa-compass text-brutal-black text-sm"></i>
            </div>
            <div>
                <h2 class="font-orbitron text-lg sm:text-xl lg:text-2xl font-black text-white uppercase tracking-wide">Popular Searches</h2>
                <div class="w-10 h-1 bg-brutal-orange mt-1.5"></div>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">
            @php $sortedCats = $categories->sortByDesc('articles_count'); @endphp
            @foreach($sortedCats as $cat)
            @php $meta = $catMeta[$cat->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border']; @endphp
            <a href="/search?category={{ $cat->slug }}"
               class="glass-card p-4 sm:p-5 text-center flex flex-col items-center justify-center group border-2 border-dark-border hover:border-transparent">
                <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $meta['color'] }} flex items-center justify-center mb-2.5 border-2 border-brutal-black group-hover:scale-110 transition-transform duration-300">
                    <i class="fas {{ $meta['icon'] }} text-brutal-black text-sm sm:text-base"></i>
                </div>
                <h3 class="font-orbitron font-bold text-white text-[10px] sm:text-xs mb-0.5 uppercase tracking-wider group-hover:text-brutal-orange transition-colors">{{ $cat->name }}</h3>
                <p class="text-[9px] sm:text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $cat->articles_count }} artikel</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection