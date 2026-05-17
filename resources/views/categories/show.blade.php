@extends('layouts.app')
@section('title', $category->name . ' - BlogCMS')
@section('meta_description', $category->description ?? 'Kategori ' . $category->name)

@php
$catColors = [
    'teknologi' => ['bg'=>'from-blue-600 to-blue-800','text'=>'text-blue-600'],
    'politik' => ['bg'=>'from-red-600 to-red-800','text'=>'text-red-600'],
    'olahraga' => ['bg'=>'from-green-600 to-green-800','text'=>'text-green-600'],
    'hiburan' => ['bg'=>'from-purple-600 to-purple-800','text'=>'text-purple-600'],
    'bisnis' => ['bg'=>'from-yellow-600 to-yellow-800','text'=>'text-yellow-600'],
];
$c = $catColors[$category->slug] ?? ['bg'=>'from-slate-600 to-slate-800','text'=>'text-slate-600'];
@endphp

@section('content')
<section class="relative bg-gradient-to-br {{ $c['bg'] }} py-16 sm:py-20">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white" data-aos="fade-up">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-white/80 mt-2 sm:mt-3 max-w-2xl mx-auto text-sm sm:text-base" data-aos="fade-up" data-aos-delay="100">{{ $category->description }}</p>
        @endif
        <p class="text-white/60 mt-2 text-xs sm:text-sm" data-aos="fade-up" data-aos-delay="150">{{ $articles->total() }} artikel</p>
    </div>
</section>

<section class="py-10 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
            <div class="lg:col-span-3">
                @if($articles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
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
                <div class="text-center py-16 sm:py-20">
                    <i class="fas fa-folder-open text-4xl sm:text-5xl text-slate-300 dark:text-slate-600 mb-4"></i>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada artikel di kategori ini.</p>
                </div>
                @endif
            </div>
            <aside class="space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700 sticky top-24">
                    <h4 class="font-bold text-slate-800 dark:text-white mb-3 sm:mb-4">Kategori Lainnya</h4>
                    <div class="space-y-1 sm:space-y-2">
                        @foreach($categories as $cat)
                        <a href="/categories/{{ $cat->slug }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm {{ $cat->id === $category->id ? 'bg-sky-50 dark:bg-sky-900/20 text-sky-600 font-semibold' : 'text-slate-600 dark:text-slate-300' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-full ml-2 flex-shrink-0">{{ $cat->articles_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection