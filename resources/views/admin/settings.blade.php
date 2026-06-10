@extends('layouts.app')
@section('title', 'Pengaturan Sistem - Nexus Gaming')
@section('meta_description', 'Pengaturan sistem administrasi.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'settings'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-cogs text-brutal-orange"></i>
                    Pengaturan Sistem
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Konfigurasi aplikasi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @php
            $sysCards = [
                ['icon' => 'fa-server', 'label' => 'Server', 'value' => 'Online', 'color' => 'green'],
                ['icon' => 'fa-database', 'label' => 'Database', 'value' => 'Terhubung', 'color' => 'green'],
                ['icon' => 'fa-globe', 'label' => 'App URL', 'value' => config('app.url'), 'color' => 'orange', 'small' => true],
                ['icon' => 'fa-code-branch', 'label' => 'Laravel', 'value' => app()->version(), 'color' => 'blue'],
                ['icon' => 'fa-php', 'label' => 'PHP', 'value' => PHP_VERSION, 'color' => 'purple'],
                ['icon' => 'fa-clock', 'label' => 'Zona Waktu', 'value' => config('app.timezone'), 'color' => 'yellow'],
            ];
            @endphp
            @foreach($sysCards as $card)
            <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 text-sm border"
                        @style([
                            'background: rgba(0,230,118,0.1); color: #00E676; border-color: rgba(0,230,118,0.2);' => $card['color'] === 'green',
                            'background: rgba(255,107,53,0.1); color: #FF6B35; border-color: rgba(255,107,53,0.2);' => $card['color'] === 'orange',
                            'background: rgba(59,130,246,0.1); color: #3B82F6; border-color: rgba(59,130,246,0.2);' => $card['color'] === 'blue',
                            'background: rgba(168,85,247,0.1); color: #A855F7; border-color: rgba(168,85,247,0.2);' => $card['color'] === 'purple',
                            'background: rgba(255,214,0,0.1); color: #FFD600; border-color: rgba(255,214,0,0.2);' => $card['color'] === 'yellow',
                        ])
                    ><i class="fas {{ $card['icon'] }}"></i></div>
                    <div class="min-w-0">
                        <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">{{ $card['label'] }}</p>
                        <p class="text-sm font-bold text-white truncate {{ isset($card['small']) ? 'text-xs' : '' }}">{{ $card['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] p-6">
            <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2 mb-4">
                <i class="fas fa-info-circle text-brutal-orange text-xs"></i>
                Informasi Aplikasi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Nama Aplikasi</span>
                    <span class="text-white font-bold">Nexus Gaming</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Versi</span>
                    <span class="text-white font-bold">2.1.0</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Environment</span>
                    <span class="text-white font-bold">{{ app()->environment() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Debug Mode</span>
                    <span class="text-white font-bold">{{ config('app.debug') ? 'ON' : 'OFF' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Cache Driver</span>
                    <span class="text-white font-bold">{{ config('cache.default') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#ffffff06]">
                    <span class="text-gray-400 font-bold">Session Driver</span>
                    <span class="text-white font-bold">{{ config('session.driver') }}</span>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection