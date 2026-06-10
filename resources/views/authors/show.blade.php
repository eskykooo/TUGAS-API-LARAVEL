@extends('layouts.app')
@section('title', $author->name . ' - Penulis Nexus Gaming')
@section('meta_description', 'Profil penulis ' . $author->name . ' di Nexus Gaming. Lihat artikel, statistik, dan kontribusi.')

@section('content')
{{-- Breadcrumb --}}
<div class="bg-dark-card border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <a href="/" class="hover:text-brutal-orange transition-colors font-bold uppercase tracking-wider whitespace-nowrap">Beranda</a>
            <span class="text-gray-600">/</span>
            <span class="text-gray-400 font-bold uppercase tracking-wider">Penulis</span>
            <span class="text-gray-600">/</span>
            <span class="text-brutal-orange font-bold truncate max-w-[200px] sm:max-w-xs uppercase tracking-wider">{{ $author->name }}</span>
        </nav>
    </div>
</div>

{{-- Author Hero --}}
<section class="relative overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 bg-gradient-to-b from-brutal-orange/5 to-transparent"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-brutal-orange/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-brutal-orange/3 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 relative z-10">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6 sm:gap-8 lg:gap-12">
            {{-- Avatar --}}
            <div class="relative flex-shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-2xl overflow-hidden border-2 border-brutal-orange/20 ring-2 ring-brutal-orange/10 shadow-2xl shadow-brutal-orange/10">
                    <img src="{{ $author->avatarUrl(128) }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-brutal-green rounded-full border-2 border-dark-bg flex items-center justify-center">
                    <i class="fas fa-check text-[10px] text-dark-bg"></i>
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center lg:text-left min-w-0">
                <div class="flex items-center justify-center lg:justify-start gap-2 flex-wrap mb-2">
                    <h1 class="font-orbitron text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-wide">{{ $author->name }}</h1>
                    @if($author->isAdmin())
                    <span class="role-badge admin text-xs"><i class="fas fa-crown"></i> Admin</span>
                    @elseif($author->role === 'editor')
                    <span class="role-badge editor text-xs"><i class="fas fa-edit"></i> Editor</span>
                    @elseif($author->role === 'author')
                    <span class="role-badge author text-xs"><i class="fas fa-pen-fancy"></i> Author</span>
                    @endif
                </div>

                @if($author->bio)
                <p class="text-gray-400 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">{{ $author->bio }}</p>
                @else
                <p class="text-gray-500 text-sm leading-relaxed max-w-2xl mx-auto lg:mx-0">Penulis di portal berita gaming Nexus Gaming.</p>
                @endif

                <div class="flex items-center justify-center lg:justify-start gap-4 sm:gap-6 mt-5">
                    <div class="text-center lg:text-left">
                        <p class="font-orbitron font-black text-xl sm:text-2xl text-white">{{ $author->articles_count }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Artikel</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center lg:text-left">
                        <p class="font-orbitron font-black text-xl sm:text-2xl text-white">{{ number_format($totalViews) }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Total Tayangan</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center lg:text-left">
                        <p class="font-orbitron font-black text-xl sm:text-2xl text-white">{{ number_format($totalComments) }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Komentar</p>
                    </div>
                </div>

                <div class="flex items-center justify-center lg:justify-start gap-3 mt-5">
                    <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider flex items-center gap-1"><i class="far fa-calendar mr-0.5"></i>Bergabung {{ $author->created_at->translatedFormat('F Y') }}</span>
                    <span class="text-gray-600">|</span>
                    <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider flex items-center gap-1"><i class="far fa-envelope mr-0.5"></i>{{ $author->email }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-[1fr_300px] lg:gap-10 xl:gap-14">
            {{-- Main: Articles --}}
            <div class="min-w-0">
                {{-- Tabs / Filter --}}
                <div class="flex items-center justify-between mb-8">
                    <h2 class="font-orbitron text-xl sm:text-2xl font-black text-white flex items-center gap-2 uppercase tracking-wide">
                        <i class="fas fa-newspaper text-brutal-orange"></i> Artikel
                    </h2>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $latestArticles->total() }} total</span>
                </div>

                @if($latestArticles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    @foreach($latestArticles as $article)
                    <x-article-card :article="$article" />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $latestArticles->links('components.pagination') }}
                </div>
                @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                        <i class="fas fa-newspaper text-2xl text-gray-600"></i>
                    </div>
                    <p class="font-bold text-gray-500 uppercase tracking-wider">Belum ada artikel.</p>
                    @auth
                    @if(auth()->id() === $author->id || auth()->user()->isAdmin())
                    <a href="/dashboard/articles/create" class="btn-primary text-sm mt-4 inline-flex">Tulis Artikel</a>
                    @endif
                    @endauth
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:block">
                <div class="sidebar-premium">
                    {{-- Most Popular --}}
                    @if($popularArticles->count() > 0)
                    <div class="card-glow p-5 mb-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-fire text-brutal-orange text-[10px]"></i> Terpopuler
                        </h4>
                        <div class="space-y-3">
                            @foreach($popularArticles as $i => $article)
                            <a href="/articles/{{ $article->slug }}" class="flex gap-3 group">
                                <span class="font-orbitron font-black text-lg text-brutal-orange/30 leading-none flex-shrink-0 w-6 text-center">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-white group-hover:text-brutal-orange transition-colors line-clamp-2 uppercase tracking-wider leading-snug">{{ $article->title }}</p>
                                    <p class="text-[10px] text-gray-500 mt-1 flex items-center gap-1 font-bold uppercase tracking-wider">
                                        <i class="far fa-eye mr-0.5"></i>{{ number_format($article->views) }} tayangan
                                    </p>
                                </div>
                            </a>
                            @if(!$loop->last)
                            <div class="border-t border-white/5"></div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Categories --}}
                    @if($mostCategories->count() > 0)
                    <div class="card-glow p-5 mb-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-folder-open text-brutal-orange text-[10px]"></i> Kategori Favorit
                        </h4>
                        <div class="space-y-2">
                            @foreach($mostCategories as $categoryName => $count)
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-300 uppercase tracking-wider">{{ $categoryName }}</span>
                                <span class="text-[10px] font-bold text-brutal-orange">{{ $count }} artikel</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Quick Stats --}}
                    <div class="card-glow p-5">
                        <h4 class="font-orbitron font-bold text-white text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-simple text-brutal-orange text-[10px]"></i> Statistik
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Artikel</span>
                                <span class="text-sm font-bold text-white">{{ $author->articles_count }}</span>
                            </div>
                            <div class="w-full h-px bg-white/5"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Tayangan</span>
                                <span class="text-sm font-bold text-white">{{ number_format($totalViews) }}</span>
                            </div>
                            <div class="w-full h-px bg-white/5"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Komentar</span>
                                <span class="text-sm font-bold text-white">{{ number_format($totalComments) }}</span>
                            </div>
                            <div class="w-full h-px bg-white/5"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Rata-rata Tayangan</span>
                                <span class="text-sm font-bold text-white">{{ $author->articles_count > 0 ? number_format(round($totalViews / $author->articles_count)) : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
