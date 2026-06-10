@extends('layouts.app')
@section('title', 'Keamanan Admin - Nexus Gaming')
@section('meta_description', 'Perbarui password administrator.')

@section('content')
<div class="admin-layout">
        @include('admin.partials.sidebar', ['current' => 'security'])
    <main class="admin-main">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-shield-alt text-brutal-orange"></i>
                    Keamanan
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Perbarui password administrator</p>
            </div>
        </div>

        @if(session('success'))
        <div class="flex items-center gap-2 px-4 py-3 mb-6 rounded-lg bg-brutal-green/10 border border-brutal-green/20 text-brutal-green text-sm font-bold uppercase tracking-wider">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="max-w-lg">
            <div class="border border-[#ffffff08] rounded-xl bg-[#0F0F0F] p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#ffffff08]">
                    <div class="w-10 h-10 rounded-lg bg-brutal-orange/10 border border-brutal-orange/20 flex items-center justify-center text-brutal-orange">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm uppercase tracking-wider">Ganti Password</p>
                        <p class="text-[11px] text-gray-500 font-bold mt-0.5">Password minimal 8 karakter</p>
                    </div>
                </div>

                <form method="POST" action="/admin/security" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full px-3.5 py-2.5 bg-[#0A0A0A] text-white border border-[#ffffff15] rounded-lg focus:border-brutal-orange/50 outline-none transition text-sm @error('current_password') border-brutal-red/50 @enderror" placeholder="Masukkan password saat ini" required autocomplete="current-password">
                        @error('current_password')<p class="text-brutal-red text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Password Baru</label>
                        <input type="password" name="password" class="w-full px-3.5 py-2.5 bg-[#0A0A0A] text-white border border-[#ffffff15] rounded-lg focus:border-brutal-orange/50 outline-none transition text-sm @error('password') border-brutal-red/50 @enderror" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                        @error('password')<p class="text-brutal-red text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full px-3.5 py-2.5 bg-[#0A0A0A] text-white border border-[#ffffff15] rounded-lg focus:border-brutal-orange/50 outline-none transition text-sm" placeholder="Ulangi password baru" required autocomplete="new-password">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-brutal-orange text-brutal-black font-bold text-sm uppercase tracking-wider hover:bg-brutal-orange/90 transition flex items-center gap-2">
                            <i class="fas fa-save text-xs"></i> Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
