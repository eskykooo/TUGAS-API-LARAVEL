@extends('layouts.app')
@section('title', 'Kategori - BlogCMS')
@section('meta_description', 'Jelajahi semua kategori artikel.')

@section('content')
<section class="py-12 sm:py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-12" data-aos="fade-up">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 dark:text-white">Jelajahi Kategori</h1>
            <div class="w-12 h-1 bg-sky-500 rounded-full mt-2 mx-auto"></div>
            <p class="text-slate-500 dark:text-slate-400 mt-3 text-sm sm:text-base">Temukan artikel menarik berdasarkan kategori</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
            $catColors = [
                'teknologi' => ['bg'=>'from-blue-500 to-blue-700','icon'=>'fa-microchip','light'=>'bg-blue-50 dark:bg-blue-900/20','border'=>'hover:border-blue-200 dark:hover:border-blue-800'],
                'politik' => ['bg'=>'from-red-500 to-red-700','icon'=>'fa-landmark','light'=>'bg-red-50 dark:bg-red-900/20','border'=>'hover:border-red-200 dark:hover:border-red-800'],
                'olahraga' => ['bg'=>'from-green-500 to-green-700','icon'=>'fa-futbol','light'=>'bg-green-50 dark:bg-green-900/20','border'=>'hover:border-green-200 dark:hover:border-green-800'],
                'hiburan' => ['bg'=>'from-purple-500 to-purple-700','icon'=>'fa-film','light'=>'bg-purple-50 dark:bg-purple-900/20','border'=>'hover:border-purple-200 dark:hover:border-purple-800'],
                'bisnis' => ['bg'=>'from-yellow-500 to-yellow-700','icon'=>'fa-chart-line','light'=>'bg-yellow-50 dark:bg-yellow-900/20','border'=>'hover:border-yellow-200 dark:hover:border-yellow-800'],
            ];
            @endphp
            @foreach($categories as $cat)
            @php $c = $catColors[$cat->slug] ?? ['bg'=>'from-slate-500 to-slate-700','icon'=>'fa-folder','light'=>'bg-slate-50 dark:bg-slate-800','border'=>'hover:border-slate-300 dark:hover:border-slate-600']; @endphp
            <a href="/categories/{{ $cat->slug }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 {{ $c['border'] }}">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl {{ $c['light'] }} flex items-center justify-center text-xl sm:text-2xl flex-shrink-0">
                        <i class="fas {{ $c['icon'] }} bg-gradient-to-br {{ $c['bg'] }} bg-clip-text text-transparent"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-base sm:text-lg text-slate-800 dark:text-white group-hover:text-sky-500 transition">{{ $cat->name }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">{{ $cat->articles_count }} artikel</p>
                    </div>
                    <i class="fas fa-arrow-right text-slate-300 dark:text-slate-600 group-hover:text-sky-500 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@if(isset($latestArticles) && $latestArticles->count() > 0)
<section class="bg-slate-100 dark:bg-slate-800 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white mb-6 sm:mb-8">Artikel Terbaru</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($latestArticles as $article)
            <x-article-card :article="$article" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection