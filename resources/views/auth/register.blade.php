@extends('layouts.app')
@section('title', 'Daftar - BlogCMS')
@section('meta_description', 'Halaman pendaftaran akun BlogCMS.')

@section('content')
<section class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 to-sky-500 relative overflow-hidden items-center justify-center">
        <div class="relative text-white text-center px-8 lg:px-12 max-w-lg">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-rocket text-2xl sm:text-4xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Mulai Menulis!</h2>
            <p class="text-white/80 text-sm sm:text-lg">Bergabung dengan komunitas penulis dan bagikan pemikiranmu kepada dunia.</p>
            <div class="mt-8 sm:mt-10 space-y-3 sm:space-y-4 text-left">
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span class="text-xs sm:text-sm">Gratis dan mudah</span>
                </div>
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-globe text-blue-400"></i>
                    <span class="text-xs sm:text-sm">Jangkau pembaca luas</span>
                </div>
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-shield-alt text-amber-400"></i>
                    <span class="text-xs sm:text-sm">Kontrol penuh atas konten</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 sm:px-8 py-12 lg:py-0">
        <div class="w-full max-w-sm sm:max-w-md" data-aos="fade-up">
            <div class="text-center lg:text-left mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">Buat Akun</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 sm:mt-2 text-sm">Bergabung bersama kami</p>
            </div>
            <form method="POST" action="/register" class="space-y-4 sm:space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full pl-11 pr-4 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm @error('name') border-red-500 @enderror" placeholder="Nama lengkap" required autofocus>
                    </div>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm @error('email') border-red-500 @enderror" placeholder="contoh@email.com" required>
                    </div>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full pl-11 pr-11 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm @error('password') border-red-500 @enderror" placeholder="Min. 8 karakter" required>
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-500 transition p-1"><i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i></button>
                    </div>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" class="w-full pl-11 pr-11 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm" placeholder="Ulangi kata sandi" required>
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-500 transition p-1"><i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i></button>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 sm:py-3.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold transition shadow-md min-h-[44px] text-sm">Daftar</button>
            </form>
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6 sm:mt-8">Sudah punya akun? <a href="/login" class="text-sky-500 font-semibold hover:underline">Masuk</a></p>
        </div>
    </div>
</section>
@endsection