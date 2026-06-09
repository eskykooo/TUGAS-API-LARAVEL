@extends('layouts.app')
@section('title', 'Admin Komentar - Nexus Gaming')
@section('meta_description', 'Kelola komentar.')

@section('content')
<section class="min-h-screen bg-dark-bg py-8 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <aside class="lg:w-64 flex-shrink-0">
                @include('admin.partials.sidebar', ['current' => 'comments'])
            </aside>
            <div class="flex-1 min-w-0">
                <div class="mb-6 sm:mb-8">
                    <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Komentar</h1>
                    <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Kelola komentar pengguna</p>
                </div>
                <div class="bg-dark-card border-2 border-dark-border overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-dark-bg">
                                <tr>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Komentar</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Artikel</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                                    <th class="text-right px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-border">
                                @forelse($comments as $comment)
                                <tr class="hover:bg-dark-bg transition">
                                    <td class="px-4 sm:px-6 py-3 sm:py-4">
                                        <p class="text-white text-sm line-clamp-2">{{ $comment->content }}</p>
                                        <p class="text-xs text-gray-500 mt-1 font-bold uppercase tracking-wider">{{ $comment->user->name }}</p>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                        <a href="/articles/{{ $comment->article->slug }}" class="text-brutal-orange hover:underline text-xs font-bold uppercase tracking-wider">{{ Str::limit($comment->article->title, 30) }}</a>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                        @if($comment->status === 'approved')
                                        <span class="tag-brutal text-brutal-green border-brutal-green">Disetujui</span>
                                        @elseif($comment->status === 'rejected')
                                        <span class="tag-brutal text-brutal-red border-brutal-red">Ditolak</span>
                                        @else
                                        <span class="tag-brutal text-brutal-yellow border-brutal-yellow">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            @if($comment->status !== 'approved')
                                            <form method="POST" action="/admin/comments/{{ $comment->id }}/approve" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-3 py-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-green hover:text-brutal-green transition text-gray-500 font-bold uppercase tracking-wider text-xs">Setuju</button>
                                            </form>
                                            @endif
                                            <form method="POST" action="/admin/comments/{{ $comment->id }}/delete" onsubmit="return confirm('Hapus komentar ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-red hover:text-brutal-red transition text-gray-500 font-bold uppercase tracking-wider text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 sm:px-6 py-12 text-center text-gray-500 font-bold uppercase tracking-wider">Belum ada komentar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($comments->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t-2 border-dark-border">
                        <x-pagination :paginator="$comments" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection