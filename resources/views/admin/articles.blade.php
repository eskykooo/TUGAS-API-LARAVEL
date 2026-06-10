@extends('layouts.app')
@section('title', 'Admin Artikel - Nexus Gaming')
@section('meta_description', 'Kelola semua artikel.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'articles'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-file-alt text-brutal-orange"></i>
                    Artikel
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Kelola semua artikel</p>
            </div>
        </div>

        <div class="overflow-hidden border border-[#ffffff08] rounded-xl bg-[#0F0F0F]">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#ffffff08]">
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Judul</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden sm:table-cell">Penulis</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden md:table-cell">Status</th>
                            <th class="text-right px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ffffff06]">
                        @forelse($articles as $article)
                        <tr class="hover:bg-[#ffffff02] transition">
                            <td class="px-5 py-4">
                                <p class="font-bold text-white truncate max-w-[240px]">{{ $article->title }}</p>
                                <p class="text-[11px] text-gray-500 mt-0.5 font-bold uppercase tracking-wider">{{ $article->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                <span class="text-gray-400 font-bold uppercase tracking-wider text-xs">{{ $article->user->name }}</span>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                @if($article->status === 'published')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-brutal-green/10 text-brutal-green border border-brutal-green/20"><i class="fas fa-check-circle text-[10px]"></i> Terbit</span>
                                @elseif($article->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-brutal-yellow/10 text-brutal-yellow border border-brutal-yellow/20"><i class="fas fa-clock text-[10px]"></i> Pending</span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20"><i class="fas fa-pen text-[10px]"></i> Draf</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($article->status === 'pending')
                                    <form method="POST" action="/admin/articles/{{ $article->id }}/approve" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-3 py-1.5 rounded bg-brutal-green/10 border border-brutal-green/20 text-brutal-green hover:bg-brutal-green/20 transition text-[11px] font-bold uppercase tracking-wider">Setuju</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="/admin/articles/{{ $article->id }}/delete" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded bg-brutal-red/10 border border-brutal-red/20 text-brutal-red hover:bg-brutal-red/20 transition text-[11px] font-bold uppercase tracking-wider">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada artikel.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($articles->hasPages())
            <div class="px-5 py-4 border-t border-[#ffffff08]">
                <x-pagination :paginator="$articles" />
            </div>
            @endif
        </div>
    </main>
</div>
@endsection