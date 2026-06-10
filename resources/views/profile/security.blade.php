@extends('layouts.app')
@section('title', 'Keamanan - Nexus Gaming')
@section('meta_description', 'Perbarui password akun.')

@section('content')
<section class="min-h-screen bg-dark-bg py-16 sm:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="/dashboard" class="p-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange transition flex-shrink-0"><i class="fas fa-arrow-left text-gray-500"></i></a>
            <div>
                <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Keamanan</h1>
                <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Perbarui password akun kamu</p>
            </div>
        </div>
        <div class="glass-card p-6 sm:p-8">
            @if(session('success'))
            <div class="bg-brutal-black border-2 border-brutal-green text-brutal-green px-4 sm:px-5 py-3 mb-4 sm:mb-6 text-sm flex items-center gap-2 font-bold uppercase tracking-wider">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="/profile/security" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Password Saat Ini</label>
                    <input type="password" name="current_password" class="input-brutal @error('current_password') border-brutal-red @enderror" placeholder="Masukkan password saat ini" required autocomplete="current-password">
                    @error('current_password')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Password Baru</label>
                    <input type="password" name="password" class="input-brutal @error('password') border-brutal-red @enderror" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                    @error('password')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="input-brutal" placeholder="Ulangi password baru" required autocomplete="new-password">
                </div>
                <div class="flex gap-3 pt-2">
                    <a href="/dashboard" class="btn-ghost text-sm hover:border-brutal-orange hover:text-brutal-orange">Kembali ke Dasbor</a>
                    <button type="submit" class="btn-primary text-sm">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
