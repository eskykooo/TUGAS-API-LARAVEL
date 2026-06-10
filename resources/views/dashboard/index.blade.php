@extends('layouts.app')
@section('title', 'Dasbor - Nexus Gaming')
@section('meta_description', 'Dasbor penulis Nexus Gaming.')

@push('styles')
<style>
    .stat-card {
        background: #141414;
        border: 1px solid #1a1a1a;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        border-color: #FF6B35;
        box-shadow: 0 0 20px rgba(255, 107, 53, 0.15), 0 4px 12px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    .stat-card .stat-icon {
        transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon {
        box-shadow: 0 0 12px rgba(255, 107, 53, 0.3);
    }
    .stat-card .stat-value {
        background: linear-gradient(135deg, #ffffff 0%, #cccccc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .nav-item {
        position: relative;
        transition: all 0.25s ease;
    }
    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%) scaleY(0);
        width: 3px;
        height: 60%;
        background: #FF6B35;
        border-radius: 0 2px 2px 0;
        transition: transform 0.25s ease;
    }
    .nav-item:hover::before,
    .nav-item.active::before {
        transform: translateY(-50%) scaleY(1);
    }
    .nav-item:hover {
        background: rgba(255, 107, 53, 0.08);
        padding-left: 1rem;
    }
    .table-row {
        transition: all 0.2s ease;
    }
    .table-row:hover {
        background: rgba(20, 20, 20, 0.8);
    }
    .table-row td:first-child {
        border-left: 2px solid transparent;
    }
    .table-row:hover td:first-child {
        border-left-color: #FF6B35;
    }
    .action-btn {
        transition: all 0.2s ease;
        border: 1px solid #1a1a1a;
        background: #0A0A0A;
    }
    .action-btn:hover {
        transform: translateY(-1px);
    }
    .widget-card {
        background: #141414;
        border: 1px solid #1a1a1a;
        transition: border-color 0.3s ease;
    }
    .widget-card:hover {
        border-color: #FF6B35;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.6rem;
        font-size: 0.625rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 1px solid;
        border-radius: 2px;
    }
    .table-header th {
        font-size: 0.625rem;
        letter-spacing: 0.1em;
    }
    .comment-avatar {
        transition: all 0.3s ease;
    }
    .comment-item:hover .comment-avatar {
        border-color: #FF6B35;
    }
    @media (max-width: 1023px) {
        .mobile-nav-active {
            background: rgba(255, 107, 53, 0.15);
            border-left: 3px solid #FF6B35;
        }
    }
</style>
@endpush

@section('content')
<section class="bg-dark-bg py-6 sm:py-8 lg:py-10 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

            {{-- SIDEBAR --}}
            <aside class="lg:w-60 flex-shrink-0">
                <div class="sticky top-24 bg-[#0D0D0D] border border-dark-border p-4 sm:p-5">
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-dark-border">
                        <img src="{{ auth()->user()->avatarUrl(44) }}" alt="" class="w-9 h-9 sm:w-10 sm:h-10 rounded border border-brutal-orange" loading="lazy">
                        <div class="min-w-0">
                            <p class="font-bold text-white truncate text-xs sm:text-sm uppercase tracking-wider">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <nav class="space-y-0.5">
                        <a href="/dashboard" class="nav-item active flex items-center gap-3 px-3 py-2.5 bg-brutal-orange/10 text-brutal-orange font-bold text-xs uppercase tracking-wider border-l-2 border-brutal-orange">
                            <i class="fas fa-th-large w-4 text-center"></i> Dasbor
                        </a>
                        <a href="/dashboard/articles/create" class="nav-item flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:text-white font-bold text-xs uppercase tracking-wider">
                            <i class="fas fa-plus-circle w-4 text-center"></i> Buat Artikel
                        </a>
                        <a href="/profile" class="nav-item flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:text-white font-bold text-xs uppercase tracking-wider">
                            <i class="fas fa-user-cog w-4 text-center"></i> Edit Profil
                        </a>
                        <a href="/profile/security" class="nav-item flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:text-white font-bold text-xs uppercase tracking-wider">
                            <i class="fas fa-shield-alt w-4 text-center"></i> Keamanan
                        </a>
                        <hr class="border-dark-border my-2">
                        <a href="/" class="nav-item flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:text-white font-bold text-xs uppercase tracking-wider">
                            <i class="fas fa-globe w-4 text-center"></i> Lihat Website
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="nav-item w-full flex items-center gap-3 px-3 py-2.5 text-gray-500 hover:text-brutal-red font-bold text-xs uppercase tracking-wider">
                                <i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            {{-- MAIN --}}
            <div class="flex-1 min-w-0">

                {{-- Alert --}}
                @if(session('success'))
                <div class="border border-brutal-green/40 bg-brutal-green/5 text-brutal-green px-4 sm:px-5 py-3 mb-5 text-xs flex items-center gap-2 font-bold uppercase tracking-wider" x-data="{show:true}" x-show="show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button @click="show = false" class="ml-auto p-1 hover:bg-dark-border transition"><i class="fas fa-times"></i></button>
                </div>
                @endif

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div>
                        <h1 class="font-orbitron text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-wide">Dasbor</h1>
                        <p class="text-gray-500 text-xs sm:text-sm mt-1 font-bold uppercase tracking-wider">Selamat datang kembali, {{ auth()->user()->name }}!</p>
                    </div>
                    <a href="/dashboard/articles/create" class="btn-primary text-xs sm:text-sm whitespace-nowrap px-4 py-2">
                        <i class="fas fa-plus mr-1"></i> Tulis Baru
                    </a>
                </div>

                {{-- STATS --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                    <div class="stat-card p-4 sm:p-5">
                        <div class="stat-icon w-9 h-9 bg-brutal-orange/20 border border-brutal-orange/40 flex items-center justify-center mb-3">
                            <i class="fas fa-file-alt text-brutal-orange text-sm"></i>
                        </div>
                        <p class="stat-value text-xl sm:text-2xl font-black font-orbitron leading-none mb-1.5">{{ $totalArticles }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider leading-tight">Total Artikel</p>
                    </div>
                    <div class="stat-card p-4 sm:p-5">
                        <div class="stat-icon w-9 h-9 bg-brutal-green/20 border border-brutal-green/40 flex items-center justify-center mb-3">
                            <i class="fas fa-eye text-brutal-green text-sm"></i>
                        </div>
                        <p class="stat-value text-xl sm:text-2xl font-black font-orbitron leading-none mb-1.5">{{ number_format($totalViews) }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider leading-tight">Total Tayangan</p>
                    </div>
                    <div class="stat-card p-4 sm:p-5">
                        <div class="stat-icon w-9 h-9 bg-brutal-yellow/20 border border-brutal-yellow/40 flex items-center justify-center mb-3">
                            <i class="fas fa-comments text-brutal-yellow text-sm"></i>
                        </div>
                        <p class="stat-value text-xl sm:text-2xl font-black font-orbitron leading-none mb-1.5">{{ number_format($totalComments) }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider leading-tight">Total Komentar</p>
                    </div>
                    <div class="stat-card p-4 sm:p-5">
                        <div class="stat-icon w-9 h-9 bg-brutal-red/20 border border-brutal-red/40 flex items-center justify-center mb-3">
                            <i class="fas fa-pen text-brutal-red text-sm"></i>
                        </div>
                        <p class="stat-value text-xl sm:text-2xl font-black font-orbitron leading-none mb-1.5">{{ $draftCount }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider leading-tight">Draf</p>
                    </div>
                </div>

                {{-- WIDGETS ROW --}}
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 sm:gap-5 mb-6">

                    {{-- Recent Comments --}}
                    <div class="widget-card lg:col-span-3 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-orbitron font-bold text-white uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fas fa-clock text-brutal-orange text-[10px]"></i> Aktivitas Terbaru
                            </h3>
                        </div>
                        @if($recentComments->count())
                        <div class="space-y-2.5">
                            @foreach($recentComments as $rc)
                            <div class="comment-item flex items-start gap-2.5 pb-2.5 border-b border-dark-border last:border-0 last:pb-0">
                                <img src="{{ $rc->user->avatarUrl(28) }}" alt="" class="comment-avatar w-6 h-6 rounded border border-dark-border flex-shrink-0 mt-0.5" loading="lazy">
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] text-gray-300 font-bold leading-snug">
                                        <span class="text-brutal-orange">{{ $rc->user->name }}</span>
                                        {{-- comment preview --}}
                                        <span class="text-gray-500 font-normal">— {{ Str::limit(strip_tags($rc->content), 60) }}</span>
                                    </p>
                                    <p class="text-[10px] text-gray-600 mt-0.5 font-bold uppercase tracking-wider flex items-center gap-1.5">
                                        <span>{{ $rc->created_at->diffForHumans() }}</span>
                                        <span class="text-gray-700">·</span>
                                        <a href="/articles/{{ $rc->article->slug ?? '#' }}" class="hover:text-brutal-orange transition-colors truncate max-w-[140px]">{{ $rc->article->title ?? '-' }}</a>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Belum ada aktivitas komentar.</p>
                        @endif
                    </div>

                    {{-- Popular Articles --}}
                    <div class="widget-card lg:col-span-2 p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-orbitron font-bold text-white uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fas fa-chart-simple text-brutal-orange text-[10px]"></i> Artikel Populer
                            </h3>
                        </div>
                        @if($popularArticles->count())
                        <div class="space-y-2">
                            @foreach($popularArticles as $i => $pa)
                            <a href="/dashboard/articles/{{ $pa->id }}/edit" class="flex items-center gap-2.5 p-2 bg-dark-bg border border-dark-border hover:border-brutal-orange/30 transition-all group">
                                <span class="font-orbitron text-sm font-black text-brutal-orange w-5 flex-shrink-0 text-center leading-none">{{ $i + 1 }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] text-gray-300 group-hover:text-brutal-orange transition-colors font-bold leading-snug line-clamp-1 uppercase tracking-wider">{{ $pa->title }}</p>
                                    <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider mt-0.5">
                                        <i class="fas fa-eye mr-0.5"></i>{{ number_format($pa->views) }} tayangan
                                    </p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @else
                        <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Belum ada artikel populer.</p>
                        @endif
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="bg-[#0D0D0D] border border-dark-border overflow-hidden">
                    <div class="px-4 sm:px-5 py-3.5 border-b border-dark-border flex items-center justify-between">
                        <h3 class="font-orbitron font-bold text-white uppercase tracking-wider text-xs flex items-center gap-2">
                            <i class="fas fa-list text-brutal-orange text-[10px]"></i> Artikel Saya
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] text-gray-600 font-bold uppercase tracking-wider hidden sm:inline">{{ $articles->total() }} total</span>
                            <a href="/dashboard/articles/create" class="sm:hidden inline-flex items-center gap-1 text-brutal-orange text-xs font-bold uppercase tracking-wider"><i class="fas fa-plus"></i> Baru</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-dark-border">
                                    <th class="table-header text-left px-4 sm:px-5 py-3 font-bold text-gray-600 uppercase tracking-wider text-[10px]">Judul</th>
                                    <th class="table-header text-left px-4 sm:px-5 py-3 font-bold text-gray-600 uppercase tracking-wider text-[10px] hidden sm:table-cell">Kategori</th>
                                    <th class="table-header text-left px-4 sm:px-5 py-3 font-bold text-gray-600 uppercase tracking-wider text-[10px] hidden md:table-cell">Status</th>
                                    <th class="table-header text-left px-4 sm:px-5 py-3 font-bold text-gray-600 uppercase tracking-wider text-[10px] hidden md:table-cell">Tayangan</th>
                                    <th class="table-header text-right px-4 sm:px-5 py-3 font-bold text-gray-600 uppercase tracking-wider text-[10px]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articles as $article)
                                <tr class="table-row border-b border-dark-border/60">
                                    <td class="px-4 sm:px-5 py-3 sm:py-3.5">
                                        <div class="min-w-0 max-w-[200px] sm:max-w-xs">
                                            <p class="font-bold text-white text-xs sm:text-sm leading-snug truncate">{{ $article->title }}</p>
                                            <p class="text-[10px] text-gray-600 mt-1 font-bold uppercase tracking-wider">{{ $article->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-5 py-3 sm:py-3.5 hidden sm:table-cell">
                                        <x-category-badge :category="$article->category" />
                                    </td>
                                    <td class="px-4 sm:px-5 py-3 sm:py-3.5 hidden md:table-cell">
                                        @if($article->status === 'published')
                                        <span class="status-badge text-brutal-green border-brutal-green/40 bg-brutal-green/5"><i class="fas fa-check-circle text-[8px]"></i> Terbit</span>
                                        @elseif($article->status === 'pending')
                                        <span class="status-badge text-brutal-yellow border-brutal-yellow/40 bg-brutal-yellow/5"><i class="fas fa-clock text-[8px]"></i> Pending</span>
                                        @elseif($article->status === 'draft')
                                        <span class="status-badge text-gray-400 border-gray-600 bg-gray-900/50"><i class="fas fa-pen text-[8px]"></i> Draf</span>
                                        @else
                                        <span class="status-badge text-gray-400 border-gray-600 bg-gray-900/50"><i class="fas fa-archive text-[8px]"></i> Arsip</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-5 py-3 sm:py-3.5 hidden md:table-cell">
                                        <span class="text-[11px] text-gray-500 font-bold">{{ number_format($article->views) }}</span>
                                    </td>
                                    <td class="px-4 sm:px-5 py-3 sm:py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            @if($article->status !== 'published')
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}/publish" class="inline">
                                                @csrf
                                                <button type="submit" class="action-btn w-7 h-7 flex items-center justify-center text-gray-500 hover:text-brutal-green hover:border-brutal-green/40" title="Publikasikan"><i class="fas fa-upload text-[10px]"></i></button>
                                            </form>
                                            @endif
                                            <a href="/dashboard/articles/{{ $article->id }}/edit" class="action-btn w-7 h-7 flex items-center justify-center text-gray-500 hover:text-brutal-orange hover:border-brutal-orange/40" title="Ubah"><i class="fas fa-edit text-[10px]"></i></a>
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn w-7 h-7 flex items-center justify-center text-gray-500 hover:text-brutal-red hover:border-brutal-red/40" title="Hapus"><i class="fas fa-trash text-[10px]"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 sm:px-5 py-14 text-center">
                                        <div class="w-12 h-12 border border-dark-border flex items-center justify-center mx-auto mb-3 bg-dark-bg">
                                            <i class="fas fa-file-alt text-gray-600 text-lg"></i>
                                        </div>
                                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-4">Belum ada artikel. Mulai tulis artikel pertamamu!</p>
                                        <a href="/dashboard/articles/create" class="btn-primary text-xs inline-flex px-4 py-2">Buat Artikel</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($articles->hasPages())
                    <div class="px-4 sm:px-5 py-3 border-t border-dark-border">
                        <x-pagination :paginator="$articles" />
                    </div>
                    @endif
                </div>

                {{-- FOOTER --}}
                <div class="mt-6 pt-4 border-t border-dark-border flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider">&copy; {{ date('Y') }} Nexus Gaming — Dasbor Penulis</p>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] text-gray-700 font-bold uppercase tracking-wider"><i class="fas fa-file-alt mr-0.5 text-brutal-orange/50"></i>{{ $totalArticles }} artikel</span>
                        <span class="text-[10px] text-gray-700 font-bold uppercase tracking-wider"><i class="fas fa-eye mr-0.5 text-brutal-green/50"></i>{{ number_format($totalViews) }} tayangan</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection