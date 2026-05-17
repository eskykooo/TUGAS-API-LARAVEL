@extends('layouts.app')
@section('title', 'Masuk - BlogCMS')
@section('meta_description', 'Halaman masuk akun BlogCMS.')

@section('content')
<section class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-sky-500 to-indigo-600 relative overflow-hidden items-center justify-center">
        <div class="relative text-white text-center px-8 lg:px-12 max-w-lg">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-newspaper text-2xl sm:text-4xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Selamat Datang Kembali!</h2>
            <p class="text-white/80 text-sm sm:text-lg">Masuk untuk mengelola artikel, menulis konten baru, dan berinteraksi dengan pembaca.</p>
            <div class="mt-8 sm:mt-10 space-y-3 sm:space-y-4 text-left">
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-pen-fancy text-sky-300"></i>
                    <span class="text-xs sm:text-sm">Tulis dan kelola artikel</span>
                </div>
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-comments text-indigo-300"></i>
                    <span class="text-xs sm:text-sm">Berinteraksi dengan pembaca</span>
                </div>
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2.5 sm:py-3">
                    <i class="fas fa-chart-line text-amber-300"></i>
                    <span class="text-xs sm:text-sm">Pantau performa konten</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 sm:px-8 py-12 lg:py-0">
        <div class="w-full max-w-sm sm:max-w-md" data-aos="fade-up">
            <div class="text-center lg:text-left mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">Masuk</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 sm:mt-2 text-sm">Masuk ke akun Anda</p>
            </div>
            <form method="POST" action="/login" class="space-y-4 sm:space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Alamat Email</label>
                    <div class="relative" x-data="{ focus: false }">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" :class="focus && 'text-sky-500'"></i>
                        <input type="email" name="email" value="{{ old('email') }}" @focus="focus = true" @blur="focus = false"
                               class="w-full pl-11 pr-4 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 rounded-xl outline-none transition text-sm @error('email') border-red-500 @enderror"
                               :class="focus && !{{ $errors->has('email') ? 'true' : 'false' }} ? 'border-sky-500 ring-2 ring-sky-500/20' : 'border-slate-200 dark:border-slate-700'"
                               placeholder="contoh@email.com" required autofocus>
                    </div>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                    <div class="relative" x-data="{ show: false, focus: false }">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" :class="focus && 'text-sky-500'"></i>
                        <input :type="show ? 'text' : 'password'" name="password" @focus="focus = true" @blur="focus = false"
                               class="w-full pl-11 pr-11 py-3 sm:py-3.5 bg-slate-50 dark:bg-slate-800 border-2 rounded-xl outline-none transition text-sm"
                               :class="focus ? 'border-sky-500 ring-2 ring-sky-500/20' : 'border-slate-200 dark:border-slate-700'"
                               placeholder="Min. 8 karakter" required>
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-500 transition p-1"><i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i></button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-sky-500 hover:underline">Lupa Kata Sandi?</a>
                </div>
                <button type="submit" class="w-full py-3 sm:py-3.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold transition shadow-md min-h-[44px] text-sm">Masuk</button>
            </form>
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6 sm:mt-8">Belum punya akun? <a href="/register" class="text-sky-500 font-semibold hover:underline">Daftar sekarang</a></p>
        </div>
    </div>
</section>
@endsection