@extends('layouts.app')
@section('title', 'Beranda - Nexus Gaming')
@section('meta_description', 'Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game.')

@section('content')

{{-- 1. HERO SLIDER --}}
<section class="relative h-[340px] sm:h-[380px] lg:h-[450px] flex items-end overflow-hidden border-b-4 border-brutal-orange"
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
        <div class="absolute inset-0 bg-dark-bg/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/30 to-transparent"></div>
    </div>
    @empty
    <div class="absolute inset-0 bg-dark-bg"></div>
    <div class="absolute inset-0 bg-dark-bg/60"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg via-dark-bg/30 to-transparent"></div>
    @endforelse

    @forelse($slides as $i => $slide)
    <div x-show="current === {{ $i }}" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative z-10 w-full pb-4 sm:pb-5 lg:pb-6 px-4 sm:px-6 lg:px-8">
        <div class="w-full md:w-4/6 lg:w-3/5 xl:w-7/12 2xl:w-1/2">
            <div class="flex items-center gap-2 mb-1.5 sm:mb-2">
                <span class="inline-block px-2 py-0.5 text-[10px] sm:text-xs font-black uppercase tracking-wider bg-brutal-orange text-brutal-black border-2 border-brutal-black leading-none">{{ $slide->category->name ?? 'UNGGULAN' }}</span>
            </div>
            <h1 class="font-orbitron text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl font-black text-white leading-tight mb-1.5 sm:mb-2 uppercase tracking-wide line-clamp-2">{{ $slide->title }}</h1>
            <p class="text-gray-400 text-xs sm:text-sm md:text-base max-w-xl mb-2 sm:mb-3 line-clamp-2">{{ $slide->excerpt }}</p>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 md:gap-4">
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <img src="{{ $slide->user->avatarUrl(28) }}" class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-brutal-orange" loading="lazy">
                    <span class="text-gray-300 text-[10px] sm:text-xs md:text-sm font-bold uppercase tracking-wider">{{ $slide->user->name ?? '-' }}</span>
                </div>
                <span class="text-gray-500 text-[10px] sm:text-xs md:text-sm font-bold uppercase tracking-wider"><i class="fas fa-clock mr-1"></i>{{ $slide->published_at?->format('d M Y') }}</span>
                <span class="text-gray-500 text-[10px] sm:text-xs md:text-sm font-bold uppercase tracking-wider"><i class="fas fa-eye mr-1"></i>{{ number_format($slide->views) }} tayangan</span>
                <a href="/articles/{{ $slide->slug }}" class="btn-primary">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="relative z-10 w-full pb-4 sm:pb-5 lg:pb-6 px-4 sm:px-6 lg:px-8">
        <div class="w-full md:w-4/6 lg:w-3/5 xl:w-7/12 2xl:w-1/2">
            <h1 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white leading-tight uppercase tracking-wide">Nexus Gaming</h1>
            <p class="text-gray-400 text-sm sm:text-base mt-2">Portal berita gaming Indonesia.</p>
        </div>
    </div>
    @endforelse

    @if($slides->count() > 1)
    <div class="absolute bottom-2.5 sm:bottom-3 left-1/2 -translate-x-1/2 z-20 flex gap-2">
        @foreach($slides as $i => $slide)
        <button @click="current = {{ $i }}; clearInterval(interval); interval = setInterval(() => { current = (current + 1) % total }, 5000)"
            class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full border-2 transition-all duration-300"
            :class="current === {{ $i }} ? 'bg-brutal-orange border-brutal-orange scale-125' : 'bg-transparent border-gray-500 hover:border-brutal-orange'">
        </button>
        @endforeach
    </div>
    @endif
</section>

{{-- 2. BREAKING NEWS --}}
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

{{-- 3. ARTIKEL TERBARU --}}
@if($latest->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
    <div class="flex items-end justify-between mb-6 sm:mb-8">
        <div>
            <h2 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Artikel Terbaru</h2>
            <div class="w-12 h-1 bg-brutal-orange mt-2"></div>
        </div>
        <a href="/search" class="btn-outline text-xs px-3 py-1.5 flex-shrink-0">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
        {{-- Featured Article --}}
        <a href="/articles/{{ $latest[0]->slug }}" class="glass-card overflow-hidden flex flex-col group border-2 border-dark-border hover:border-brutal-orange lg:col-span-2">
            <div class="relative w-full aspect-[16/9] lg:aspect-[21/9] flex-shrink-0 overflow-hidden">
                @if($latest[0]->thumbnail_url)
                <img src="{{ $latest[0]->thumbnail_url }}" alt="{{ $latest[0]->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                @else
                <div class="absolute inset-0 bg-dark-card flex items-center justify-center"><i class="fas fa-gamepad text-5xl text-gray-600"></i></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/80 via-dark-bg/10 to-transparent"></div>
                <span class="absolute top-3 left-3 z-10 tag-brutal">{{ $latest[0]->category->name ?? 'Umum' }}</span>
            </div>
            <div class="p-4 sm:p-5 flex flex-col flex-1">
                <h3 class="font-orbitron font-bold text-white mb-2 line-clamp-2 leading-snug group-hover:text-brutal-orange transition-colors text-base sm:text-lg md:text-xl uppercase tracking-wide">{{ $latest[0]->title }}</h3>
                <p class="text-gray-400 text-xs sm:text-sm line-clamp-2 mb-3 flex-1 font-bold uppercase tracking-wider">{{ $latest[0]->excerpt }}</p>
                <div class="flex items-center gap-2 pt-3 border-t-2 border-dark-border mt-auto">
                    <img src="{{ $latest[0]->user->avatarUrl(28) }}" alt="" class="w-6 h-6 rounded-full border-2 border-brutal-orange flex-shrink-0" loading="lazy">
                    <span class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider truncate">{{ $latest[0]->user->name ?? '-' }}</span>
                    <span class="text-[10px] sm:text-xs text-gray-500 flex items-center gap-1 ml-auto font-bold uppercase tracking-wider"><i class="fas fa-eye mr-0.5"></i>{{ number_format($latest[0]->views) }}</span>
                </div>
            </div>
        </a>
        {{-- Article 2 --}}
        <x-article-card :article="$latest[1] ?? $latest[0]" :index="1" />
    </div>
    @if($latest->count() > 2)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 mt-4 sm:mt-5 lg:mt-6">
        @foreach($latest->slice(2)->take(4) as $index => $article)
        <x-article-card :article="$article" :index="$index + 2" />
        @endforeach
    </div>
    @endif
</section>
@endif

{{-- 4. TRENDING NOW --}}
@if($trending->count())
<section class="bg-dark-card border-y-4 border-brutal-orange py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-6 sm:mb-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brutal-red flex items-center justify-center flex-shrink-0 border-2 border-brutal-black">
                    <i class="fas fa-fire text-brutal-black text-sm"></i>
                </div>
                <div>
                    <h2 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Trending Now</h2>
                    <div class="w-12 h-1 bg-brutal-red mt-2"></div>
                </div>
            </div>
            <a href="/search?sort=trending" class="btn-outline text-xs px-3 py-1.5 flex-shrink-0">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
            @foreach($trending as $i => $article)
            <a href="/articles/{{ $article->slug }}" class="glass-card flex gap-3 sm:gap-4 p-3 sm:p-4 items-center group border-2 border-dark-border hover:border-brutal-red">
                <span class="font-orbitron text-xl sm:text-2xl font-black text-brutal-red w-7 sm:w-9 flex-shrink-0 leading-none self-center text-center">{{ $i + 1 }}</span>
                @if($article->thumbnail_url)
                <img src="{{ $article->thumbnail_url }}" alt="" class="w-14 h-12 sm:w-20 sm:h-16 object-cover flex-shrink-0 self-center border-2 border-dark-border" loading="lazy">
                @else
                <div class="w-14 h-12 sm:w-20 sm:h-16 flex-shrink-0 self-center bg-dark-card border-2 border-dark-border flex items-center justify-center"><i class="fas fa-gamepad text-gray-500 text-lg"></i></div>
                @endif
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] sm:text-xs text-brutal-red font-black uppercase tracking-wider">{{ $article->category->name ?? '' }}</span>
                    <h3 class="font-bold text-white text-xs sm:text-sm line-clamp-2 group-hover:text-brutal-red transition-colors mt-0.5 leading-snug">{{ $article->title }}</h3>
                    <p class="text-[10px] sm:text-xs text-gray-500 mt-1 font-bold uppercase tracking-wider flex items-center gap-2">
                        <span><i class="fas fa-user mr-0.5"></i>{{ $article->user->name ?? '-' }}</span>
                        <span><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views) }}</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 5. ARTIKEL POPULER --}}
@if($popular->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
    <div class="flex items-end justify-between mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-brutal-orange flex items-center justify-center flex-shrink-0 border-2 border-brutal-black">
                <i class="fas fa-chart-line text-brutal-black text-sm"></i>
            </div>
            <div>
                <h2 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Paling Populer</h2>
                <div class="w-12 h-1 bg-brutal-orange mt-2"></div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
        @foreach($popular as $i => $article)
        <a href="/articles/{{ $article->slug }}" class="glass-card flex gap-3 sm:gap-4 p-3 sm:p-4 items-center group border-2 border-dark-border hover:border-brutal-orange">
            <span class="font-orbitron text-lg sm:text-xl lg:text-2xl font-black text-brutal-orange w-7 sm:w-9 flex-shrink-0 leading-none self-center text-center">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
            @if($article->thumbnail_url)
            <img src="{{ $article->thumbnail_url }}" alt="" class="w-14 h-12 sm:w-20 sm:h-16 object-cover flex-shrink-0 self-center border-2 border-dark-border" loading="lazy">
            @else
            <div class="w-14 h-12 sm:w-20 sm:h-16 flex-shrink-0 self-center bg-dark-card border-2 border-dark-border flex items-center justify-center"><i class="fas fa-gamepad text-gray-500 text-lg"></i></div>
            @endif
            <div class="flex-1 min-w-0">
                <span class="text-[10px] sm:text-xs text-brutal-orange font-black uppercase tracking-wider">{{ $article->category->name ?? '' }}</span>
                <h3 class="font-bold text-white text-xs sm:text-sm line-clamp-2 group-hover:text-brutal-orange transition-colors mt-0.5 leading-snug">{{ $article->title }}</h3>
                <p class="text-[10px] sm:text-xs text-gray-500 mt-1 font-bold uppercase tracking-wider flex items-center gap-2">
                    <span><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views) }} tayangan</span>
                    <span><i class="fas fa-clock mr-0.5"></i>{{ $article->published_at?->format('d M Y') }}</span>
                </p>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- 6. JELAJAHI KATEGORI --}}
@if($categories->count())
<section class="bg-dark-card border-y-4 border-brutal-orange py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Jelajahi Kategori</h2>
            <div class="w-12 h-1 bg-brutal-orange mt-2 mx-auto"></div>
            <p class="text-gray-400 text-xs sm:text-sm mt-3 font-bold uppercase tracking-wider">Temukan berita gaming favoritmu berdasarkan kategori</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5 lg:gap-6">
            @php
            $catMeta = [
                'pc-gaming' => ['icon'=>'fa-desktop','color'=>'bg-brutal-orange','desc'=>'Hardware & PC gaming'],
                'console' => ['icon'=>'fa-gamepad','color'=>'bg-brutal-red','desc'=>'PlayStation, Xbox & Nintendo'],
                'mobile' => ['icon'=>'fa-mobile-alt','color'=>'bg-brutal-yellow','desc'=>'iOS, Android & mobile'],
                'esports' => ['icon'=>'fa-trophy','color'=>'bg-brutal-green','desc'=>'Turnamen & kompetisi'],
                'gaming-news' => ['icon'=>'fa-newspaper','color'=>'bg-brutal-orange','desc'=>'Berita industri game'],
                'reviews' => ['icon'=>'fa-star','color'=>'bg-brutal-blue','desc'=>'Review game terpercaya'],
                'guides' => ['icon'=>'fa-book','color'=>'bg-brutal-purple','desc'=>'Tips, trik & panduan'],
            ];
            @endphp
            @foreach($categories as $index => $category)
            @php $meta = $catMeta[$category->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border','desc'=>'Kategori artikel']; @endphp
            <a href="/categories/{{ $category->slug }}" data-aos="zoom-in" data-aos-delay="{{ $index * 60 }}"
               class="glass-card p-4 sm:p-5 lg:p-6 text-center flex flex-col items-center justify-center group border-2 border-dark-border hover:border-transparent relative overflow-hidden">
                <div class="w-12 h-12 sm:w-14 sm:h-14 {{ $meta['color'] }} flex items-center justify-center mb-3 border-2 border-brutal-black group-hover:scale-110 transition-transform duration-300">
                    <i class="fas {{ $meta['icon'] }} text-brutal-black text-base sm:text-lg"></i>
                </div>
                <h3 class="font-orbitron font-bold text-white text-xs sm:text-sm mb-0.5 uppercase tracking-wider group-hover:text-brutal-orange transition-colors">{{ $category->name }}</h3>
                <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">{{ $meta['desc'] }}</p>
                <div class="flex items-center gap-1 text-[10px] sm:text-xs text-brutal-orange font-black uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <span>{{ $category->articles_count }} artikel</span>
                    <i class="fas fa-arrow-right text-[8px]"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 7. NEWSLETTER --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
    <div class="bg-brutal-black border-4 border-brutal-orange p-6 sm:p-8 lg:p-10 flex flex-col lg:flex-row items-center gap-6 lg:gap-10">
        <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 bg-brutal-orange flex items-center justify-center border-2 border-brutal-black">
            <i class="fas fa-envelope-open-text text-brutal-black text-xl sm:text-2xl"></i>
        </div>
        <div class="flex-1 text-center lg:text-left">
            <h3 class="font-orbitron font-black text-white text-lg sm:text-xl lg:text-2xl uppercase tracking-wide mb-1">Berlangganan Newsletter</h3>
            <p class="text-gray-400 text-xs sm:text-sm font-bold uppercase tracking-wider">Dapatkan update berita gaming terkini langsung di email kamu. Gratis, tidak ada spam.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto flex-shrink-0">
            <input type="email" placeholder="Email kamu..." class="input-brutal text-sm min-w-[200px] sm:min-w-[240px]">
            <button class="btn-primary text-sm whitespace-nowrap">Berlangganan</button>
        </div>
    </div>
</section>

@endsection