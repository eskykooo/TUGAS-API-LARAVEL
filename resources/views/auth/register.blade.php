@extends('layouts.app')
@section('title', 'Daftar - Nexus Gaming')
@section('meta_description', 'Daftar akun Nexus Gaming.')

@section('content')
<section class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 bg-dark-card border-r-4 border-brutal-orange relative overflow-hidden items-center justify-center">
        <div class="relative text-white text-center px-8 lg:px-12 max-w-lg">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-brutal-yellow border-4 border-brutal-black flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-rocket text-2xl sm:text-4xl text-brutal-black"></i>
            </div>
            <h2 class="font-orbitron text-2xl sm:text-3xl font-black mb-3 sm:mb-4 uppercase tracking-wide">Mulai Menulis!</h2>
            <p class="text-gray-400 text-sm sm:text-lg font-bold uppercase tracking-wider">Bergabung dengan komunitas penulis gaming dan bagikan kontenmu.</p>
            <div class="mt-8 sm:mt-10 space-y-3 sm:space-y-4 text-left">
                <div class="flex items-center gap-3 bg-dark-bg border-2 border-dark-border px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-check-circle text-brutal-green"></i>
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider">Gratis dan mudah</span>
                </div>
                <div class="flex items-center gap-3 bg-dark-bg border-2 border-dark-border px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-globe text-brutal-orange"></i>
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider">Jangkau pembaca luas</span>
                </div>
                <div class="flex items-center gap-3 bg-dark-bg border-2 border-dark-border px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-shield-alt text-brutal-yellow"></i>
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider">Kontrol penuh atas konten</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 sm:px-8 py-12 lg:py-0 bg-dark-bg">
        <div class="w-full max-w-sm sm:max-w-md" data-aos="fade-up">
            <div class="text-center lg:text-left mb-6 sm:mb-8">
                <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Buat Akun</h1>
                <p class="text-gray-500 mt-1 sm:mt-2 text-sm font-bold uppercase tracking-wider">Bergabung bersama kami</p>
            </div>
            <form method="POST" action="/register" class="space-y-4 sm:space-y-5" autocomplete="off">
                @csrf
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                <input type="text" class="hidden" aria-hidden="true" tabindex="-1">
                <input type="password" class="hidden" aria-hidden="true" tabindex="-1">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="text" name="name" value="{{ old('name') }}" class="input-brutal pl-11 @error('name') border-brutal-red @enderror" placeholder="Nama lengkap" required autofocus autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    </div>
                    @error('name')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-brutal pl-11 @error('email') border-brutal-red @enderror" placeholder="contoh@email.com" required autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    </div>
                    @error('email')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input :type="show ? 'text' : 'password'" name="password" class="input-brutal pl-11 pr-11 @error('password') border-brutal-red @enderror" placeholder="Min. 8 karakter" required autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-brutal-orange transition p-1"><i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i></button>
                    </div>
                    @error('password')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Konfirmasi Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" class="input-brutal pl-11 pr-11" placeholder="Ulangi kata sandi" required autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-brutal-orange transition p-1"><i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i></button>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full text-sm">Daftar</button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6 sm:mt-8 font-bold uppercase tracking-wider">Sudah punya akun? <a href="/login" class="text-brutal-orange hover:underline">Masuk</a></p>
        </div>
    </div>
</section>
@endsection