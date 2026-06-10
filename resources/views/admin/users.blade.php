@extends('layouts.app')
@section('title', 'Admin Pengguna - Nexus Gaming')
@section('meta_description', 'Kelola pengguna.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'users'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-users text-brutal-orange"></i>
                    Pengguna
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Kelola semua pengguna</p>
            </div>
        </div>

        <div class="overflow-hidden border border-[#ffffff08] rounded-xl bg-[#0F0F0F]">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#ffffff08]">
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Nama</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden sm:table-cell">Email</th>
                            <th class="text-left px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px] hidden md:table-cell">Role</th>
                            <th class="text-right px-5 py-3.5 font-bold text-gray-500 uppercase tracking-wider text-[11px]">Artikel</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ffffff06]">
                        @forelse($users as $user)
                        <tr class="hover:bg-[#ffffff02] transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $user->avatarUrl(32) }}" class="w-8 h-8 rounded-lg border border-brutal-orange/30 flex-shrink-0">
                                    <span class="font-bold text-white">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell text-gray-400 font-bold text-xs">{{ $user->email }}</td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-brutal-yellow/10 text-brutal-yellow border border-brutal-yellow/20">Admin</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-gray-500/10 text-gray-400 border border-gray-500/20">User</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right text-gray-500 font-bold uppercase tracking-wider text-xs">
                                {{ $user->articles_count }} artikel
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-500 text-xs font-bold uppercase tracking-wider">Tidak ada pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="px-5 py-4 border-t border-[#ffffff08]">
                <x-pagination :paginator="$users" />
            </div>
            @endif
        </div>
    </main>
</div>
@endsection