@extends('layouts.app')
@section('title', 'Nexus Gaming - Portal Berita Gaming Indonesia')
@section('meta_description', 'Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game.')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center bg-dark-bg">
    <div class="text-center px-4" data-aos="fade-up">
        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-brutal-orange border-4 border-brutal-black flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-gamepad text-3xl sm:text-4xl text-brutal-black"></i>
        </div>
        <h1 class="font-orbitron text-3xl sm:text-5xl lg:text-6xl font-black text-white uppercase tracking-wide mb-4">Nexus Gaming</h1>
        <p class="text-gray-500 text-sm sm:text-lg max-w-lg mx-auto mb-8 font-bold uppercase tracking-wider">Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
            <a href="/" class="btn-primary text-sm">Jelajahi Artikel</a>
            <a href="/register" class="btn-outline text-sm">Mulai Menulis</a>
        </div>
    </div>
</section>
@endsection
