@extends('layouts.app')
@section('title', 'Dasbor - Nexus Gaming')
@section('meta_description', 'Dasbor penulis Nexus Gaming.')

@section('content')
<section class="min-h-screen bg-dark-bg py-8 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- Sidebar --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="glass-card p-5 sm:p-6 sticky top-24">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b-2 border-dark-border">
                        <img src="{{ auth()->user()->avatarUrl(48) }}" alt="" class="w-10 h-10 sm:w-12 sm:h-12 rounded border-2 border-brutal-orange" loading="lazy">
                        <div class="min-w-0">
                            <p class="font-bold text-white truncate text-sm sm:text-base uppercase tracking-wider">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <nav class="space-y-1">
                        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 bg-brutal-orange text-brutal-black font-bold text-sm uppercase tracking-wider">
                            <i class="fas fa-th-large"></i> Dasbor
                        </a>
                        <a href="/dashboard/articles/create" class="flex items-center gap-3 px-3 py-2.5 hover:bg-dark-border text-gray-400 hover:text-white font-bold text-sm uppercase tracking-wider transition">
                            <i class="fas fa-plus-circle"></i> Buat Artikel
                        </a>
                        <a href="/profile" class="flex items-center gap-3 px-3 py-2.5 hover:bg-dark-border text-gray-400 hover:text-white font-bold text-sm uppercase tracking-wider transition">
                            <i class="fas fa-user-cog"></i> Edit Profil
                        </a>
                        <a href="/profile/security" class="flex items-center gap-3 px-3 py-2.5 hover:bg-dark-border text-gray-400 hover:text-white font-bold text-sm uppercase tracking-wider transition">
                            <i class="fas fa-shield-alt"></i> Keamanan
                        </a>
                        <a href="/" class="flex items-center gap-3 px-3 py-2.5 hover:bg-dark-border text-gray-400 hover:text-white font-bold text-sm uppercase tracking-wider transition">
                            <i class="fas fa-globe"></i> Lihat Website
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-dark-border text-gray-400 hover:text-brutal-red font-bold text-sm uppercase tracking-wider transition">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            {{-- Main --}}
            <div class="flex-1 min-w-0">
                @if(session('success'))
                <div class="bg-brutal-black border-2 border-brutal-green text-brutal-green px-4 sm:px-5 py-3 mb-4 sm:mb-6 text-sm flex items-center gap-2 font-bold uppercase tracking-wider" x-data="{show:true}" x-show="show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button @click="show = false" class="ml-auto p-1 hover:bg-dark-border transition"><i class="fas fa-times"></i></button>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8">
                    <div>
                        <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Dasbor</h1>
                        <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Selamat datang, {{ auth()->user()->name }}!</p>
                    </div>
                    <a href="/dashboard/articles/create" class="btn-primary text-sm whitespace-nowrap">
                        <i class="fas fa-plus"></i> Tulis Baru
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up">
                        <div class="w-10 h-10 bg-brutal-orange border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-file-alt text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $totalArticles }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Total Artikel</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="50">
                        <div class="w-10 h-10 bg-brutal-green border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-eye text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ number_format($totalViews) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Total Tayangan</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-10 h-10 bg-brutal-yellow border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-comments text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ number_format($totalComments) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Total Komentar</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="150">
                        <div class="w-10 h-10 bg-brutal-red border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-pen text-white"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $draftCount }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Draf</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="bg-dark-card border-2 border-dark-border overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b-2 border-dark-border flex items-center justify-between">
                        <h3 class="font-orbitron font-bold text-white uppercase tracking-wider text-sm">Artikel Saya</h3>
                        <a href="/dashboard/articles/create" class="sm:hidden inline-flex items-center gap-1 text-brutal-orange text-sm font-bold uppercase tracking-wider"><i class="fas fa-plus"></i> Baru</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-dark-bg">
                                <tr>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Kategori</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Tayangan</th>
                                    <th class="text-right px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-border">
                                @forelse($articles as $article)
                                <tr class="hover:bg-dark-bg transition">
                                    <td class="px-4 sm:px-6 py-3 sm:py-4">
                                        <div class="min-w-0 max-w-[180px] sm:max-w-xs">
                                            <p class="font-bold text-white truncate">{{ $article->title }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5 font-bold uppercase tracking-wider">{{ $article->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                        <x-category-badge :category="$article->category" />
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                        @if($article->status === 'published')
                                        <span class="tag-brutal text-brutal-green border-brutal-green"><i class="fas fa-check-circle mr-1"></i> Terbit</span>
                                        @elseif($article->status === 'pending')
                                        <span class="tag-brutal text-brutal-yellow border-brutal-yellow"><i class="fas fa-clock mr-1"></i> Pending</span>
                                        @elseif($article->status === 'draft')
                                        <span class="tag-brutal text-gray-500 border-gray-500"><i class="fas fa-pen mr-1"></i> Draf</span>
                                        @else
                                        <span class="tag-brutal text-gray-500 border-gray-500"><i class="fas fa-archive mr-1"></i> Arsip</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell text-gray-500 font-bold">{{ number_format($article->views) }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 sm:gap-2">
                                            @if($article->status !== 'published')
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}/publish" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-green hover:text-brutal-green transition text-gray-500" title="Publikasikan"><i class="fas fa-upload"></i></button>
                                            </form>
                                            @endif
                                            <a href="/dashboard/articles/{{ $article->id }}/edit" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-gray-500" title="Ubah"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-red hover:text-brutal-red transition text-gray-500" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 sm:px-6 py-12 sm:py-16 text-center">
                                        <i class="fas fa-file-alt text-3xl sm:text-4xl text-gray-600 mb-3"></i>
                                        <p class="text-gray-500 font-bold uppercase tracking-wider">Belum ada artikel. Buat artikel pertamamu!</p>
                                        <a href="/dashboard/articles/create" class="btn-primary mt-4 text-sm inline-flex">Buat Artikel</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($articles->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t-2 border-dark-border">
                        <x-pagination :paginator="$articles" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection