@extends('layouts.app')
@section('title', 'Beranda - Nexus Gaming')
@section('meta_description', 'Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game.')

@section('content')

{{-- HERO SLIDER --}}
<section class="relative min-h-[60vh] sm:min-h-[70vh] lg:min-h-[80vh] flex items-end overflow-hidden border-b-4 border-brutal-orange"
    x-data="{ current: 0, total: {{ $slides->count() }}, interval: null }"
    x-init="interval = setInterval(() => { current = (current + 1) % total }, 5000)"
    @mouseenter="clearInterval(interval)"
    @mouseleave="interval = setInterval(() => { current = (current + 1) % total }, 5000)">
    @forelse($slides as $i => $slide)
    <div x-show="current === {{ $i }}" x-cloak x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-105" class="absolute inset-0 w-full h-full">
        @if($slide->thumbnail_url)
        <img src="{{ $slide->thumbnail_url }}" alt="" class="absolute inset-0 w-full h-full object-cover">
        @else
        <div class="absolute inset-0 bg-dark-bg"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/70 to-transparent"></div>
    </div>
    @empty
    <div class="absolute inset-0 bg-dark-bg"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/70 to-transparent"></div>
    @endforelse

    @forelse($slides as $i => $slide)
    <div x-show="current === {{ $i }}" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-16 lg:pb-20 w-full">
        <span class="tag-brutal inline-block mb-3 sm:mb-4">{{ $slide->category->name ?? 'UNGGULAN' }}</span>
        <h1 class="font-orbitron text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white max-w-3xl leading-tight mb-3 sm:mb-4 uppercase tracking-wide">{{ $slide->title }}</h1>
        <p class="text-gray-400 text-sm sm:text-base lg:text-lg max-w-2xl mb-4 sm:mb-6 line-clamp-2">{{ $slide->excerpt }}</p>
        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ $slide->user->avatarUrl(40) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded border-2 border-brutal-orange" loading="lazy">
                <span class="text-gray-300 text-xs sm:text-sm font-bold uppercase tracking-wider">{{ $slide->user->name ?? '-' }}</span>
            </div>
            <span class="text-gray-500 text-xs sm:text-sm font-bold uppercase tracking-wider"><i class="fas fa-clock mr-1"></i>{{ $slide->published_at?->format('d M Y') }}</span>
            <span class="text-gray-500 text-xs sm:text-sm font-bold uppercase tracking-wider"><i class="fas fa-eye mr-1"></i>{{ number_format($slide->views) }} tayangan</span>
            <a href="/articles/{{ $slide->slug }}" class="btn-primary text-xs sm:text-sm">
                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-16 lg:pb-20 w-full">
        <h1 class="font-orbitron text-3xl sm:text-5xl font-black text-white max-w-3xl leading-tight uppercase tracking-wide">Nexus Gaming</h1>
        <p class="text-gray-400 text-lg max-w-2xl mt-4">Portal berita gaming Indonesia.</p>
    </div>
    @endforelse

    {{-- Dots --}}
    @if($slides->count() > 1)
    <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
        @foreach($slides as $i => $slide)
        <button @click="current = {{ $i }}; clearInterval(interval); interval = setInterval(() => { current = (current + 1) % total }, 5000)"
            class="w-3 h-3 rounded-full border-2 transition-all duration-300"
            :class="current === {{ $i }} ? 'bg-brutal-orange border-brutal-orange scale-125' : 'bg-transparent border-gray-500 hover:border-brutal-orange'">
        </button>
        @endforeach
    </div>
    @endif
</section>

{{-- BREAKING NEWS --}}
<div class="bg-brutal-black border-b-2 border-brutal-orange">
    <div class="flex items-stretch min-h-[44px] sm:min-h-[48px]">
        <div class="flex-shrink-0 bg-brutal-orange px-4 sm:px-6 flex items-center gap-2 font-orbitron font-black text-xs sm:text-sm uppercase tracking-wider text-brutal-black">
            <span class="w-2 h-2 bg-brutal-black flex-shrink-0"></span>
            <span class="hidden sm:inline">BREAKING</span>
            <span class="sm:hidden">BARU</span>
        </div>
        <div class="marquee-wrapper flex-1 flex items-center bg-dark-bg px-0">
            <div class="marquee-track text-xs sm:text-sm font-bold text-white flex items-center">
                @foreach($breaking as $b)
                <span class="flex items-center gap-2 px-6 flex-shrink-0 whitespace-nowrap"><span class="text-brutal-orange flex-shrink-0"><i class="fas fa-gamepad"></i></span> <span class="truncate">{{ $b->title }}</span></span>
                @endforeach
                @foreach($breaking as $b)
                <span class="flex items-center gap-2 px-6 flex-shrink-0 whitespace-nowrap"><span class="text-brutal-orange flex-shrink-0"><i class="fas fa-gamepad"></i></span> <span class="truncate">{{ $b->title }}</span></span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ARTIKEL TERBARU --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
    <div class="flex items-end justify-between mb-8 sm:mb-10">
        <div>
            <h2 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide">Artikel Terbaru</h2>
            <div class="w-16 h-1 bg-brutal-orange mt-2 sm:mt-3"></div>
        </div>
        <a href="/search" class="btn-outline text-xs px-3 py-1.5">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
        @foreach($latest as $index => $article)
        <x-article-card :article="$article" :index="$index" />
        @endforeach
    </div>
    <div class="mt-10 sm:mt-12 flex justify-center">
        <x-pagination :paginator="$latest" />
    </div>
</section>

{{-- KATEGORI POPULER --}}
<section class="bg-dark-card border-y-4 border-brutal-orange py-12 sm:py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide">Jelajahi Kategori</h2>
            <div class="w-16 h-1 bg-brutal-orange mt-2 sm:mt-3 mx-auto"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">
            @php
            $catMeta = [
                'pc-gaming' => ['icon'=>'fa-desktop','color'=>'bg-brutal-orange'],
                'console' => ['icon'=>'fa-gamepad','color'=>'bg-brutal-red'],
                'mobile' => ['icon'=>'fa-mobile-alt','color'=>'bg-brutal-yellow'],
                'esports' => ['icon'=>'fa-trophy','color'=>'bg-brutal-green'],
                'gaming-news' => ['icon'=>'fa-newspaper','color'=>'bg-brutal-orange'],
            ];
            @endphp
            @foreach($categories as $index => $category)
            @php $meta = $catMeta[$category->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border']; @endphp
            <a href="/categories/{{ $category->slug }}" data-aos="zoom-in" data-aos-delay="{{ $index * 80 }}"
               class="glass-card p-5 sm:p-6 lg:p-7 text-center flex flex-col items-center justify-center group">
                <div class="w-14 h-14 {{ $meta['color'] }} flex items-center justify-center mb-3 sm:mb-4 border-2 border-brutal-black">
                    <i class="fas {{ $meta['icon'] }} text-brutal-black text-lg sm:text-xl"></i>
                </div>
                <h3 class="font-orbitron font-bold text-white text-sm sm:text-base mb-0.5 uppercase tracking-wider">{{ $category->name }}</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $category->articles_count }} artikel</p>
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
                    <h2 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Paling Populer</h2>
                    <div class="w-16 h-1 bg-brutal-orange mt-2"></div>
                </div>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @foreach($popular as $i => $article)
                <a href="/articles/{{ $article->slug }}" class="glass-card flex gap-3 sm:gap-4 p-3 sm:p-4 items-center group">
                    <span class="font-orbitron text-2xl sm:text-3xl font-black text-brutal-orange w-8 sm:w-10 flex-shrink-0 leading-none self-center">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                    @if($article->thumbnail_url)
                    <img src="{{ $article->thumbnail_url }}" alt="" class="w-16 h-14 sm:w-20 sm:h-16 object-cover flex-shrink-0 self-center border-2 border-dark-border" loading="lazy">
                    @else
                    <div class="w-16 h-14 sm:w-20 sm:h-16 flex-shrink-0 self-center bg-dark-card border-2 border-dark-border flex items-center justify-center"><i class="fas fa-gamepad text-gray-500 text-lg"></i></div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <span class="text-xs text-brutal-orange font-bold uppercase tracking-wider">{{ $article->category->name ?? '' }}</span>
                        <h3 class="font-bold text-white text-sm line-clamp-2 group-hover:text-brutal-orange transition-colors mt-0.5">{{ $article->title }}</h3>
                        <p class="text-xs text-gray-500 mt-1 font-bold uppercase tracking-wider"><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }} tayangan</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <aside class="space-y-6 lg:space-y-8">
            <div class="glass-card p-5 sm:p-6">
                <h3 class="font-orbitron font-bold text-white mb-4 flex items-center gap-2 uppercase tracking-wider text-sm"><i class="fas fa-tags text-brutal-orange"></i> Tag Populer</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <a href="/search?tag={{ $tag->slug }}" class="tag-brutal hover:bg-brutal-orange hover:text-brutal-black transition-colors">#{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="bg-brutal-black border-4 border-brutal-orange p-5 sm:p-6">
                <div class="text-2xl mb-2 text-brutal-orange"><i class="fas fa-envelope"></i></div>
                <h3 class="font-orbitron font-black text-white uppercase tracking-wider text-lg mb-2">Newsletter</h3>
                <p class="text-gray-400 text-sm mb-4 leading-relaxed font-bold uppercase tracking-wider">Dapatkan update berita gaming terkini langsung di email kamu. Gratis.</p>
                <div class="flex flex-col gap-2">
                    <input type="email" placeholder="Email kamu..." class="input-brutal text-sm">
                    <button class="btn-primary w-full text-sm">Berlangganan</button>
                </div>
            </div>
        </aside>
    </div>
</section>

@endsection