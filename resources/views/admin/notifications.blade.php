@extends('layouts.app')
@section('title', 'Notifikasi Admin - Nexus Gaming')
@section('meta_description', 'Notifikasi sistem.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'notifications'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-bell text-brutal-orange"></i>
                    Notifikasi
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Notifikasi dan permintaan yang memerlukan perhatian</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            {{-- Pending Articles --}}
            <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-[#ffffff08]">
                    <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-file-alt text-brutal-yellow text-xs"></i>
                        Artikel Menunggu
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brutal-yellow/10 text-brutal-yellow border border-brutal-yellow/20">{{ $pendingArticles->count() }}</span>
                </div>
                <div class="divide-y divide-[#ffffff06]">
                    @forelse($pendingArticles as $article)
                    <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#ffffff02] transition">
                        <div class="w-8 h-8 rounded-lg bg-brutal-yellow/10 border border-brutal-yellow/20 flex items-center justify-center text-brutal-yellow flex-shrink-0">
                            <i class="fas fa-clock text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ $article->title }}</p>
                            <p class="text-[11px] text-gray-500 font-bold mt-0.5">Oleh {{ $article->user->name ?? '—' }} · {{ $article->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <form method="POST" action="/admin/articles/{{ $article->id }}/approve" class="inline">
                                @csrf @method('PUT')
                                <button type="submit" class="px-3 py-1.5 rounded bg-brutal-green/10 border border-brutal-green/20 text-brutal-green hover:bg-brutal-green/20 transition text-[11px] font-bold uppercase tracking-wider">Setuju</button>
                            </form>
                            <form method="POST" action="/admin/articles/{{ $article->id }}/delete" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded bg-brutal-red/10 border border-brutal-red/20 text-brutal-red hover:bg-brutal-red/20 transition text-[11px] font-bold uppercase tracking-wider">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500 text-xs font-bold uppercase tracking-wider">Tidak ada artikel yang menunggu</div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Comments --}}
            <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-[#ffffff08]">
                    <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-comment text-brutal-blue text-xs"></i>
                        Komentar Baru
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-brutal-blue/10 text-brutal-blue border border-brutal-blue/20">{{ $pendingComments->count() }}</span>
                </div>
                <div class="divide-y divide-[#ffffff06]">
                    @forelse($pendingComments as $comment)
                    <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#ffffff02] transition">
                        <img src="{{ $comment->user->avatarUrl(32) }}" class="w-8 h-8 rounded-lg border border-[#ffffff0a] flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ Str::limit($comment->content, 60) }}</p>
                            <p class="text-[11px] text-gray-500 font-bold mt-0.5">{{ $comment->user->name }} · {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <form method="POST" action="/admin/comments/{{ $comment->id }}/approve" class="inline">
                                @csrf @method('PUT')
                                <button type="submit" class="px-3 py-1.5 rounded bg-brutal-green/10 border border-brutal-green/20 text-brutal-green hover:bg-brutal-green/20 transition text-[11px] font-bold uppercase tracking-wider">Setuju</button>
                            </form>
                            <form method="POST" action="/admin/comments/{{ $comment->id }}/reject" class="inline">
                                @csrf @method('PUT')
                                <button type="submit" class="px-3 py-1.5 rounded bg-brutal-red/10 border border-brutal-red/20 text-brutal-red hover:bg-brutal-red/20 transition text-[11px] font-bold uppercase tracking-wider">Tolak</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500 text-xs font-bold uppercase tracking-wider">Tidak ada komentar baru</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection