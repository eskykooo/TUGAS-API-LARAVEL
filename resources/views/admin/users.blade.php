@extends('layouts.app')
@section('title', 'Admin Pengguna - Nexus Gaming')
@section('meta_description', 'Kelola pengguna.')

@section('content')
<section class="min-h-screen bg-dark-bg py-8 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <aside class="lg:w-64 flex-shrink-0">
                @include('admin.partials.sidebar', ['current' => 'users'])
            </aside>
            <div class="flex-1 min-w-0">
                <div class="mb-6 sm:mb-8">
                    <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Pengguna</h1>
                    <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Kelola semua pengguna</p>
                </div>
                <div class="bg-dark-card border-2 border-dark-border overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-dark-bg">
                                <tr>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Email</th>
                                    <th class="text-left px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Role</th>
                                    <th class="text-right px-4 sm:px-6 py-3 font-bold text-gray-500 uppercase tracking-wider">Artikel</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-border">
                                @forelse($users as $user)
                                <tr class="hover:bg-dark-bg transition">
                                    <td class="px-4 sm:px-6 py-3 sm:py-4">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ $user->avatarUrl(32) }}" class="w-7 h-7 rounded border-2 border-brutal-orange flex-shrink-0">
                                            <span class="font-bold text-white">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden sm:table-cell text-gray-400 font-bold">{{ $user->email }}</td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                        @if($user->role === 'admin')
                                        <span class="tag-brutal text-brutal-yellow border-brutal-yellow">Admin</span>
                                        @else
                                        <span class="tag-brutal text-gray-400 border-gray-500">User</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-right text-gray-500 font-bold uppercase tracking-wider text-xs">
                                        {{ $user->articles_count ?? 0 }} artikel
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 sm:px-6 py-12 text-center text-gray-500 font-bold uppercase tracking-wider">Tidak ada pengguna.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($users->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t-2 border-dark-border">
                        <x-pagination :paginator="$users" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection