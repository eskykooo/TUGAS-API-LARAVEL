@extends('layouts.app')
@section('title', $category->name . ' - Nexus Gaming')
@section('meta_description', $category->description ?? 'Kategori ' . $category->name)

@section('content')
<section class="bg-dark-card border-b-4 border-brutal-orange py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide" data-aos="fade-up">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-gray-400 mt-2 sm:mt-3 max-w-2xl mx-auto text-sm sm:text-base font-bold uppercase tracking-wider" data-aos="fade-up" data-aos-delay="100">{{ $category->description }}</p>
        @endif
        <p class="text-gray-500 mt-2 text-xs sm:text-sm font-bold uppercase tracking-wider" data-aos="fade-up" data-aos-delay="150">{{ $articles->total() }} artikel</p>
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
                    <i class="fas fa-folder-open text-4xl sm:text-5xl text-gray-600 mb-4"></i>
                    <p class="text-gray-500 font-bold uppercase tracking-wider">Belum ada artikel di kategori ini.</p>
                </div>
                @endif
            </div>
            <aside class="space-y-6">
                <div class="glass-card p-4 sm:p-5 sticky top-24">
                    <h4 class="font-orbitron font-bold text-white mb-3 sm:mb-4 uppercase tracking-wider text-sm">Kategori Lainnya</h4>
                    <div class="space-y-1 sm:space-y-2">
                        @foreach($categories as $cat)
                        <a href="/categories/{{ $cat->slug }}" class="flex items-center justify-between px-3 py-2.5 border-2 border-transparent hover:border-brutal-orange transition text-sm {{ $cat->id === $category->id ? 'bg-brutal-orange text-brutal-black font-bold' : 'text-gray-400 hover:text-white font-bold' }} uppercase tracking-wider">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-dark-bg px-2 py-0.5 ml-2 flex-shrink-0 border border-dark-border">{{ $cat->articles_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection