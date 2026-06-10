@extends('layouts.app')
@section('title', 'Admin Komentar - Nexus Gaming')
@section('meta_description', 'Kelola komentar pengguna.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'comments'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-comments text-brutal-orange"></i>
                    Komentar
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Kelola komentar pengguna</p>
            </div>
        </div>

        @if(session('success'))
        <div class="flex items-center gap-2 px-4 py-3 mb-6 rounded-lg bg-brutal-green/10 border border-brutal-green/20 text-brutal-green text-sm font-bold uppercase tracking-wider">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="overflow-hidden border border-[#ffffff08] rounded-xl bg-[#0F0F0F]">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#ffffff08]">
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Komentar</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden sm:table-cell">Pengguna</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden md:table-cell">Artikel</th>
                            <th class="text-right px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ffffff06]">
                        @forelse($comments as $comment)
                        <tr class="hover:bg-[#ffffff02] transition">
                            <td class="px-5 py-4 max-w-[250px]">
                                <p class="font-bold text-white truncate">{{ Str::limit($comment->content, 60) }}</p>
                                <p class="text-[11px] text-gray-500 mt-0.5 font-bold uppercase tracking-wider">{{ $comment->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $comment->user->avatarUrl(24) }}" class="w-6 h-6 rounded border border-[#ffffff0a] flex-shrink-0">
                                    <span class="text-gray-400 font-bold text-xs">{{ $comment->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <a href="/articles/{{ $comment->article->slug }}" target="_blank" class="text-gray-400 font-bold text-xs hover:text-brutal-orange transition truncate max-w-[200px] inline-block">
                                    {{ Str::limit($comment->article->title, 30) }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($comment->status === 'pending')
                                    <form method="POST" action="/admin/comments/{{ $comment->id }}/approve" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-3 py-1.5 rounded bg-brutal-green/10 border border-brutal-green/20 text-brutal-green hover:bg-brutal-green/20 transition text-[11px] font-bold uppercase tracking-wider">Setuju</button>
                                    </form>
                                    <form method="POST" action="/admin/comments/{{ $comment->id }}/reject" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-3 py-1.5 rounded bg-brutal-red/10 border border-brutal-red/20 text-brutal-red hover:bg-brutal-red/20 transition text-[11px] font-bold uppercase tracking-wider">Tolak</button>
                                    </form>
                                    @endif
                                    <form method="POST" action="/admin/comments/{{ $comment->id }}/delete" onsubmit="return confirm('Hapus komentar ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded bg-gray-500/10 border border-gray-500/20 text-gray-400 hover:bg-brutal-red/20 hover:text-brutal-red hover:border-brutal-red/20 transition text-[11px] font-bold uppercase tracking-wider"><i class="fas fa-trash text-[10px]"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada komentar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($comments->hasPages())
            <div class="px-5 py-4 border-t border-[#ffffff08]">
                <x-pagination :paginator="$comments" />
            </div>
            @endif
        </div>
    </main>
</div>
@endsection