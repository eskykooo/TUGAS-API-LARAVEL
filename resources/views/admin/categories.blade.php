@extends('layouts.app')
@section('title', 'Admin Kategori - Nexus Gaming')
@section('meta_description', 'Kelola kategori.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'categories'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-folder text-brutal-orange"></i>
                    Kategori
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Kelola kategori artikel</p>
            </div>
        </div>

        <div class="overflow-hidden border border-[#ffffff08] rounded-xl bg-[#0F0F0F]">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#ffffff08]">
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Nama</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden sm:table-cell">Slug</th>
                            <th class="text-right px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Artikel</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ffffff06]">
                        @forelse($categories as $category)
                        <tr class="hover:bg-[#ffffff02] transition">
                            <td class="px-5 py-4">
                                <p class="font-bold text-white">{{ $category->name }}</p>
                                @if($category->description)
                                <p class="text-[11px] text-gray-500 mt-0.5">{{ $category->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell text-gray-400 font-bold text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-4 text-right text-gray-500 font-bold uppercase tracking-wider text-xs">{{ $category->articles_count }} artikel</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
            <div class="px-5 py-4 border-t border-[#ffffff08]">
                <x-pagination :paginator="$categories" />
            </div>
            @endif
        </div>
    </main>
</div>
@endsection