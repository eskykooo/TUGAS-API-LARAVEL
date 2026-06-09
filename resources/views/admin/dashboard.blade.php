@extends('layouts.app')
@section('title', 'Admin Dasbor - Nexus Gaming')
@section('meta_description', 'Panel administrasi Nexus Gaming.')

@section('content')
<section class="min-h-screen bg-dark-bg py-8 sm:py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <aside class="lg:w-64 flex-shrink-0">
                @include('admin.partials.sidebar', ['current' => 'dashboard'])
            </aside>
            <div class="flex-1 min-w-0">
                <div class="mb-6 sm:mb-8">
                    <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Admin Dasbor</h1>
                    <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Ringkasan sistem</p>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up">
                        <div class="w-10 h-10 bg-brutal-orange border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-newspaper text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $totalArticles ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Total Artikel</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="50">
                        <div class="w-10 h-10 bg-brutal-green border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-check-circle text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $draftCount ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Draf</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-10 h-10 bg-brutal-yellow border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-clock text-brutal-black"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $pendingComments ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Komentar Pending</p>
                    </div>
                    <div class="glass-card p-4 sm:p-5" data-aos="fade-up" data-aos-delay="150">
                        <div class="w-10 h-10 bg-brutal-red border-2 border-brutal-black flex items-center justify-center mb-2 sm:mb-3"><i class="fas fa-users text-white"></i></div>
                        <p class="text-xl sm:text-2xl font-black text-white font-orbitron">{{ $totalUsers ?? 0 }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">Total Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection