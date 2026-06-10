@extends('layouts.app')
@section('title', 'Aktivitas Admin - Nexus Gaming')
@section('meta_description', 'Log aktivitas administrasi.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'activity'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-history text-brutal-orange"></i>
                    Aktivitas
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Log aktivitas terkini</p>
            </div>
        </div>

        <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] overflow-hidden">
            <div class="divide-y divide-[#ffffff06]">
                @forelse($activities as $act)
                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#ffffff02] transition">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-xs border"
                        @style([
                            'background: rgba(255,107,53,0.1); color: #FF6B35; border-color: rgba(255,107,53,0.2);' => $act['color'] === 'orange',
                            'background: rgba(0,230,118,0.1); color: #00E676; border-color: rgba(0,230,118,0.2);' => $act['color'] === 'green',
                            'background: rgba(59,130,246,0.1); color: #3B82F6; border-color: rgba(59,130,246,0.2);' => $act['color'] === 'blue',
                        ])
                    ><i class="fas {{ $act['icon'] }}"></i></div>
                    <div class="flex-1 min-w-0 flex items-center gap-2">
                        @if(!empty($act['user']) && method_exists($act['user'], 'avatarUrl'))
                        <img src="{{ $act['user']->avatarUrl(24) }}" class="w-6 h-6 rounded border border-[#ffffff0a] flex-shrink-0">
                        @endif
                        <div>
                            <p class="text-sm text-gray-300">
                                <span class="font-bold text-white">{{ $act['user']->name ?? 'Sistem' }}</span>
                                {{ $act['description'] }}
                            </p>
                            <p class="text-[10px] text-gray-600 font-bold mt-0.5">{{ $act['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada aktivitas</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection