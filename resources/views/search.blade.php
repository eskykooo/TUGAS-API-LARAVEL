@extends('layouts.app')
@section('title', 'Pencarian - Nexus Gaming')
@section('meta_description', 'Cari artikel di Nexus Gaming.')

@section('content')
<section class="py-12 sm:py-16 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-10" data-aos="fade-up">
            <h1 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide">Pencarian</h1>
            <div class="w-16 h-1 bg-brutal-orange mt-2 mx-auto"></div>
        </div>
        <form action="/search" method="GET" data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari artikel gaming..."
                           class="input-brutal pl-12 text-base sm:text-lg" autofocus>
                </div>
                <button type="submit" class="btn-primary text-sm">Cari</button>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3 mt-4 justify-center">
                <select name="category" class="select-brutal flex-1 sm:flex-none text-sm" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ ($categorySlug ?? '') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->articles_count }})</option>
                    @endforeach
                </select>
                <select name="tag" class="select-brutal flex-1 sm:flex-none text-sm" onchange="this.form.submit()">
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
        <p class="text-gray-500 mb-6 sm:mb-8 text-sm sm:text-base font-bold uppercase tracking-wider" data-aos="fade-up">Hasil untuk: <strong class="text-white">"{{ $query }}"</strong> ({{ $articles->total() }})</p>
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
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-dark-card border-2 border-dark-border flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-2xl sm:text-3xl text-gray-500"></i>
            </div>
            <h3 class="font-orbitron text-lg sm:text-xl font-black text-white mb-2 uppercase tracking-wide">Tidak ada hasil</h3>
            <p class="text-gray-500 max-w-md mx-auto text-sm sm:text-base font-bold uppercase tracking-wider">Tidak ditemukan artikel dengan kata kunci "{{ $query }}". Coba kata kunci lain.</p>
            <a href="/search" class="btn-outline mt-5 sm:mt-6 text-sm inline-flex">Reset Pencarian</a>
        </div>
        @endif
    </div>
</section>
@endsection