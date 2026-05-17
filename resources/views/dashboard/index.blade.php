@extends('layouts.app')
@section('title', 'Dasbor - BlogCMS')
@section('meta_description', 'Dasbor penulis BlogCMS.')

@section('content')
<section class="min-h-screen bg-slate-50 dark:bg-slate-900 py-8 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- Sidebar --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 sm:p-6 sticky top-24">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0ea5e9&color=fff&size=56" alt="" class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl" loading="lazy">
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 dark:text-white truncate text-sm sm:text-base">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <nav class="space-y-1">
                        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-sky-50 dark:bg-sky-900/20 text-sky-600 font-medium text-sm">
                            <i class="fas fa-th-large"></i> Dasbor
                        </a>
                        <a href="/dashboard/articles/create" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium text-sm transition">
                            <i class="fas fa-plus-circle"></i> Buat Artikel
                        </a>
                        <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium text-sm transition">
                            <i class="fas fa-globe"></i> Lihat Website
                        </a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-slate-600 dark:text-slate-300 hover:text-red-600 font-medium text-sm transition">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            {{-- Main --}}
            <div class="flex-1 min-w-0">
                @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 sm:px-5 py-3 rounded-xl mb-4 sm:mb-6 text-sm flex items-center gap-2" x-data="{show:true}" x-show="show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button @click="show = false" class="ml-auto p-1 hover:bg-green-100 dark:hover:bg-green-900/40 rounded-lg transition"><i class="fas fa-times"></i></button>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">Dasbor</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
                    </div>
                    <a href="/dashboard/articles/create" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-medium text-sm transition shadow-md min-h-[44px] whitespace-nowrap">
                        <i class="fas fa-plus"></i> Tulis Artikel Baru
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700" data-aos="fade-up">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-2 sm:mb-3"><i class="fas fa-file-alt"></i></div>
                        <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white">{{ $totalArticles }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Total Artikel</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="50">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-2 sm:mb-3"><i class="fas fa-eye"></i></div>
                        <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white">{{ number_format($totalViews) }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Total Tayangan</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-2 sm:mb-3"><i class="fas fa-comments"></i></div>
                        <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white">{{ number_format($totalComments) }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Total Komentar</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="150">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-2 sm:mb-3"><i class="fas fa-pen"></i></div>
                        <p class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white">{{ $draftCount }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Draf</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 dark:text-white">Artikel Saya</h3>
                        <a href="/dashboard/articles/create" class="sm:hidden inline-flex items-center gap-1 text-sky-500 text-sm font-medium"><i class="fas fa-plus"></i> Baru</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-900">
                                <tr>
                                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-slate-500 dark:text-slate-400">Judul</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-slate-500 dark:text-slate-400 hidden sm:table-cell">Kategori</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-slate-500 dark:text-slate-400 hidden md:table-cell">Status</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-medium text-slate-500 dark:text-slate-400 hidden md:table-cell">Tayangan</th>
                                    <th class="text-right px-4 sm:px-6 py-3 font-medium text-slate-500 dark:text-slate-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($articles as $article)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                    <td class="px-4 sm:px-6 py-3 sm:py-4">
                                        <div class="min-w-0 max-w-[180px] sm:max-w-xs">
                                            <p class="font-medium text-slate-800 dark:text-white truncate">{{ $article->title }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $article->created_at->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                        <x-category-badge :category="$article->category" />
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                        @if($article->status === 'published')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400"><i class="fas fa-check-circle"></i> Terbit</span>
                                        @elseif($article->status === 'draft')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400"><i class="fas fa-pen"></i> Draf</span>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400"><i class="fas fa-archive"></i> Diarsipkan</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell text-slate-500 dark:text-slate-400">{{ number_format($article->views) }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 sm:gap-2">
                                            @if($article->status !== 'published')
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}/publish" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 text-slate-400 hover:text-green-600 transition" title="Publikasikan"><i class="fas fa-upload"></i></button>
                                            </form>
                                            @endif
                                            <a href="/dashboard/articles/{{ $article->id }}/edit" class="p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 text-slate-400 hover:text-blue-600 transition" title="Ubah"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="/dashboard/articles/{{ $article->id }}" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-slate-400 hover:text-red-600 transition" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 sm:px-6 py-12 sm:py-16 text-center">
                                        <i class="fas fa-file-alt text-3xl sm:text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                                        <p class="text-slate-500 dark:text-slate-400">Belum ada artikel. Buat artikel pertamamu!</p>
                                        <a href="/dashboard/articles/create" class="inline-block mt-4 px-5 py-2.5 bg-sky-50 dark:bg-sky-900/20 text-sky-500 rounded-xl text-sm font-medium hover:bg-sky-500 hover:text-white transition min-h-[44px]">Buat Artikel</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($articles->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                        <x-pagination :paginator="$articles" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection