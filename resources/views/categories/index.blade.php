@extends('layouts.app')
@section('title', 'Kategori - Nexus Gaming')
@section('meta_description', 'Jelajahi semua kategori artikel gaming.')

@section('content')
<section class="py-12 sm:py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-12" data-aos="fade-up">
            <h1 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide">Jelajahi Kategori</h1>
            <div class="w-16 h-1 bg-brutal-orange mt-2 mx-auto"></div>
            <p class="text-gray-500 mt-3 text-sm sm:text-base font-bold uppercase tracking-wider">Temukan artikel gaming berdasarkan kategori</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
            $catMeta = [
                'pc-gaming' => ['icon'=>'fa-desktop','color'=>'bg-brutal-orange','shadow'=>'shadow-brutal-orange'],
                'console' => ['icon'=>'fa-gamepad','color'=>'bg-brutal-red','shadow'=>'shadow-brutal-red'],
                'mobile' => ['icon'=>'fa-mobile-alt','color'=>'bg-brutal-yellow','shadow'=>'shadow-brutal-yellow'],
                'esports' => ['icon'=>'fa-trophy','color'=>'bg-brutal-green','shadow'=>'shadow-brutal-green'],
                'gaming-news' => ['icon'=>'fa-newspaper','color'=>'bg-brutal-orange','shadow'=>'shadow-brutal-orange'],
                'reviews' => ['icon'=>'fa-star','color'=>'bg-brutal-blue','shadow'=>'shadow-brutal-blue'],
                'tips-tricks' => ['icon'=>'fa-lightbulb','color'=>'bg-brutal-green','shadow'=>'shadow-brutal-green'],
                'guides' => ['icon'=>'fa-book','color'=>'bg-brutal-purple','shadow'=>'shadow-brutal-purple'],
                'hardware' => ['icon'=>'fa-microchip','color'=>'bg-brutal-red','shadow'=>'shadow-brutal-red'],
                'gaming-culture' => ['icon'=>'fa-users','color'=>'bg-brutal-yellow','shadow'=>'shadow-brutal-yellow'],
            ];
            $shadowMap = [
                'bg-brutal-orange' => 'hover-shadow-orange',
                'bg-brutal-red' => 'hover-shadow-red',
                'bg-brutal-yellow' => 'hover-shadow-yellow',
                'bg-brutal-green' => 'hover-shadow-green',
                'bg-brutal-blue' => 'hover-shadow-blue',
                'bg-brutal-purple' => 'hover-shadow-purple',
            ];
            @endphp
            @foreach($categories as $cat)
            @php
            $meta = $catMeta[$cat->slug] ?? ['icon'=>'fa-folder','color'=>'bg-dark-border'];
            $hoverShadow = $shadowMap[$meta['color']] ?? 'hover-shadow-orange';
            @endphp
            <a href="/categories/{{ $cat->slug }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}" class="glass-card {{ $hoverShadow }} p-4 sm:p-6 flex items-center gap-3 sm:gap-4 group">
                <div class="w-12 h-12 sm:w-14 sm:h-14 {{ $meta['color'] }} border-2 border-brutal-black flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $meta['icon'] }} text-brutal-black text-xl sm:text-2xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-orbitron font-bold text-base sm:text-lg text-white group-hover:text-brutal-orange transition uppercase tracking-wider">{{ $cat->name }}</h3>
                    <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">{{ $cat->articles_count }} artikel</p>
                </div>
                <i class="fas fa-arrow-right text-gray-600 group-hover:text-brutal-orange group-hover:translate-x-1 transition-all flex-shrink-0"></i>
            </a>
            @endforeach
        </div>
    </div>
</section>

@if(isset($latestArticles) && $latestArticles->count() > 0)
<section class="bg-dark-card border-t-4 border-brutal-orange py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white mb-6 sm:mb-8 uppercase tracking-wide">Artikel Terbaru</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($latestArticles as $article)
            <x-article-card :article="$article" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection