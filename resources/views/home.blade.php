@extends('layouts.app')
@section('title', 'Beranda - BlogCMS')
@section('meta_description', 'Portal berita dan blog modern dengan informasi terkini.')

@section('content')

{{-- HERO --}}
<section class="relative min-h-[60vh] sm:min-h-[70vh] lg:min-h-[80vh] flex items-end overflow-hidden">
    @if($featured && $featured->thumbnail_url)
    <img src="{{ $featured->thumbnail_url }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover">
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-sky-600 to-indigo-800"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 to-transparent"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-16 lg:pb-20 w-full">
        @if($featured)
        <span class="inline-block px-3 py-1 bg-sky-500 text-white text-xs font-bold rounded-full mb-3 sm:mb-4 uppercase tracking-wider">{{ $featured->category->name ?? 'Unggulan' }}</span>
        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white max-w-3xl leading-tight mb-3 sm:mb-4">{{ $featured->title }}</h1>
        <p class="text-slate-300 text-sm sm:text-base lg:text-lg max-w-2xl mb-4 sm:mb-6 line-clamp-2">{{ $featured->excerpt }}</p>
        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <div class="flex items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($featured->user->name ?? 'A') }}&background=0ea5e9&color=fff&size=40" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border-2 border-sky-400" loading="lazy">
                <span class="text-slate-300 text-xs sm:text-sm">{{ $featured->user->name ?? '-' }}</span>
            </div>
            <span class="text-slate-400 text-xs sm:text-sm"><i class="fas fa-clock mr-1"></i>{{ $featured->published_at?->format('d M Y') }}</span>
            <span class="text-slate-400 text-xs sm:text-sm"><i class="fas fa-eye mr-1"></i>{{ number_format($featured->views) }} tayangan</span>
            <a href="/articles/{{ $featured->slug }}" class="w-full sm:w-auto text-center px-5 py-2.5 sm:px-6 sm:py-3 bg-sky-500 hover:bg-sky-400 text-white font-semibold rounded-xl transition-all hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base shadow-md">
                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- BREAKING NEWS --}}
<div class="bg-red-600 text-white">
    <div class="flex items-stretch min-h-[44px] sm:min-h-[48px]">
        <div class="flex-shrink-0 bg-red-800 px-4 sm:px-6 flex items-center gap-2 font-bold text-xs sm:text-sm tracking-wide">
            <span class="w-2 h-2 bg-white rounded-full animate-pulse flex-shrink-0"></span>
            <span class="hidden sm:inline">BREAKING</span>
            <span class="sm:hidden">BARU</span>
        </div>
        <div class="marquee-wrapper flex-1 flex items-center bg-red-700/50 px-0">
            <div class="marquee-track text-xs sm:text-sm font-medium flex items-center">
                @foreach($breaking as $b)
                <span class="flex items-center gap-2 px-6 flex-shrink-0 whitespace-nowrap"><span class="text-red-300 flex-shrink-0">📰</span> <span class="truncate">{{ $b->title }}</span></span>
                @endforeach
                @foreach($breaking as $b)
                <span class="flex items-center gap-2 px-6 flex-shrink-0 whitespace-nowrap"><span class="text-red-300 flex-shrink-0">📰</span> <span class="truncate">{{ $b->title }}</span></span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ARTIKEL TERBARU --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
    <div class="flex items-end justify-between mb-8 sm:mb-10">
        <div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 dark:text-white">Artikel Terbaru</h2>
            <div class="w-12 h-1 bg-sky-500 rounded-full mt-2 sm:mt-3"></div>
        </div>
        <a href="/search" class="text-sky-500 hover:text-sky-600 font-medium flex items-center gap-1 text-sm whitespace-nowrap transition-colors">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
        @foreach($latest as $index => $article)
        @php
        $catColors = ['teknologi'=>'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300','politik'=>'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300','olahraga'=>'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300','hiburan'=>'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300','bisnis'=>'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'];
        $color = $catColors[$article->category->slug ?? ''] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
        @endphp
        <article data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group flex flex-col">
            <div class="overflow-hidden h-48 flex-shrink-0">
                @if($article->thumbnail_url)
                <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-sky-500/30 to-indigo-600/30 flex items-center justify-center"><i class="fas fa-newspaper text-4xl text-slate-300 dark:text-slate-600"></i></div>
                @endif
            </div>
            <div class="p-5 flex flex-col flex-1">
                <span class="inline-block self-start px-2.5 py-1 {{ $color }} text-xs font-semibold rounded-lg mb-3">{{ $article->category->name ?? 'Umum' }}</span>
                <h3 class="font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 leading-snug group-hover:text-sky-500 transition-colors text-base md:text-lg">
                    <a href="/articles/{{ $article->slug }}">{{ $article->title }}</a>
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed">{{ $article->excerpt }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-700 mt-auto">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'A') }}&background=0ea5e9&color=fff&size=32" alt="" class="w-7 h-7 rounded-full flex-shrink-0" loading="lazy">
                    <span class="text-xs text-slate-500 truncate min-w-0">{{ $article->user->name ?? '-' }}</span>
                    <span class="text-xs text-slate-400 flex items-center gap-1 ml-auto flex-shrink-0"><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views) }}</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="mt-10 sm:mt-12 flex justify-center">
        <x-pagination :paginator="$latest" />
    </div>
</section>

{{-- KATEGORI POPULER --}}
<section class="bg-slate-100 dark:bg-slate-800 py-12 sm:py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 dark:text-white">Jelajahi Kategori</h2>
            <div class="w-12 h-1 bg-sky-500 rounded-full mt-2 sm:mt-3 mx-auto"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">
            @php
            $catIcons = ['teknologi'=>['icon'=>'fa-microchip','bg'=>'from-blue-500 to-blue-600'],'politik'=>['icon'=>'fa-landmark','bg'=>'from-red-500 to-red-600'],'olahraga'=>['icon'=>'fa-futbol','bg'=>'from-green-500 to-green-600'],'hiburan'=>['icon'=>'fa-film','bg'=>'from-purple-500 to-purple-600'],'bisnis'=>['icon'=>'fa-chart-line','bg'=>'from-yellow-500 to-yellow-600']];
            @endphp
            @foreach($categories as $index => $category)
            @php $meta = $catIcons[$category->slug] ?? ['icon'=>'fa-folder','bg'=>'from-slate-500 to-slate-600']; @endphp
            <a href="/categories/{{ $category->slug }}" data-aos="zoom-in" data-aos-delay="{{ $index * 80 }}"
               class="group bg-white dark:bg-slate-900 rounded-2xl p-5 sm:p-6 lg:p-7 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col items-center justify-center border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br {{ $meta['bg'] }} rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-md">
                    <i class="fas {{ $meta['icon'] }} text-white text-lg sm:text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-800 dark:text-white text-sm sm:text-base mb-0.5">{{ $category->name }}</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $category->articles_count }} artikel</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ARTIKEL POPULER + SIDEBAR --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6 sm:mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">Paling Banyak Dibaca</h2>
                    <div class="w-12 h-1 bg-sky-500 rounded-full mt-2"></div>
                </div>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @foreach($popular as $i => $article)
                <a href="/articles/{{ $article->slug }}" class="flex gap-3 sm:gap-4 bg-white dark:bg-slate-800 rounded-2xl p-3 sm:p-4 hover:shadow-md transition-all group border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                    <span class="text-2xl sm:text-3xl font-black text-slate-200 dark:text-slate-700 w-8 sm:w-10 flex-shrink-0 leading-none self-center">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                    @if($article->thumbnail_url)
                    <img src="{{ $article->thumbnail_url }}" alt="" class="w-16 h-14 sm:w-20 sm:h-16 object-cover rounded-xl flex-shrink-0 self-center" loading="lazy">
                    @else
                    <div class="w-16 h-14 sm:w-20 sm:h-16 rounded-xl flex-shrink-0 self-center bg-gradient-to-br from-sky-500/30 to-indigo-600/30 flex items-center justify-center"><i class="fas fa-newspaper text-slate-400 text-lg"></i></div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <span class="text-xs text-sky-500 font-semibold">{{ $article->category->name ?? '' }}</span>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-sky-500 transition-colors mt-0.5">{{ $article->title }}</h3>
                        <p class="text-xs text-slate-400 mt-1"><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} tayangan</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <aside class="space-y-6 lg:space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2"><i class="fas fa-tags text-sky-500"></i> Tag Populer</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <a href="/search?tag={{ $tag->slug }}" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-700 hover:bg-sky-500 hover:text-white text-slate-600 dark:text-slate-300 rounded-full text-sm transition-colors">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="bg-gradient-to-br from-sky-500 to-indigo-600 rounded-2xl p-5 sm:p-6 text-white">
                <div class="text-2xl mb-2">📬</div>
                <h3 class="font-bold text-lg mb-2">Newsletter</h3>
                <p class="text-sky-100 text-sm mb-4 leading-relaxed">Daftarkan email kamu dan dapatkan ringkasan berita terbaik setiap pagi, langsung di inbox-mu. Gratis selamanya.</p>
                <div class="flex flex-col gap-2">
                    <input type="email" placeholder="Email kamu..." class="w-full px-4 py-2.5 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-slate-400">
                    <button class="w-full py-2.5 bg-white text-sky-600 font-bold rounded-xl hover:bg-sky-50 transition-colors text-sm shadow-md">Berlangganan Gratis</button>
                </div>
            </div>
        </aside>
    </div>
</section>

@endsection