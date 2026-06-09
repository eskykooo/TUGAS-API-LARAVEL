@props(['current' => 'dashboard'])

<div class="glass-card p-5 sm:p-6 sticky top-24">
    <div class="flex items-center gap-3 mb-5 pb-4 border-b-2 border-dark-border">
        <img src="{{ auth()->user()->avatarUrl(48) }}" alt="" class="w-10 h-10 sm:w-12 sm:h-12 rounded border-2 border-brutal-orange" loading="lazy">
        <div class="min-w-0">
            <p class="font-bold text-white truncate text-sm sm:text-base uppercase tracking-wider">{{ auth()->user()->name }}</p>
            <p class="text-xs text-brutal-yellow font-bold uppercase tracking-wider">Administrator</p>
        </div>
    </div>
    <nav class="space-y-1">
        <a href="/admin" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold uppercase tracking-wider transition
            {{ $current === 'dashboard' ? 'bg-brutal-orange text-brutal-black' : 'text-gray-400 hover:bg-dark-border hover:text-white' }}">
            <i class="fas fa-th-large"></i> Dasbor
        </a>
        <a href="/admin/articles" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold uppercase tracking-wider transition
            {{ $current === 'articles' ? 'bg-brutal-orange text-brutal-black' : 'text-gray-400 hover:bg-dark-border hover:text-white' }}">
            <i class="fas fa-file-alt"></i> Artikel
        </a>
        <a href="/admin/comments" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold uppercase tracking-wider transition
            {{ $current === 'comments' ? 'bg-brutal-orange text-brutal-black' : 'text-gray-400 hover:bg-dark-border hover:text-white' }}">
            <i class="fas fa-comments"></i> Komentar
        </a>
        <a href="/admin/users" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold uppercase tracking-wider transition
            {{ $current === 'users' ? 'bg-brutal-orange text-brutal-black' : 'text-gray-400 hover:bg-dark-border hover:text-white' }}">
            <i class="fas fa-users"></i> Pengguna
        </a>
        <hr class="border-dark-border my-2">
        <a href="/" class="flex items-center gap-3 px-3 py-2.5 text-gray-400 hover:bg-dark-border hover:text-white text-sm font-bold uppercase tracking-wider transition">
            <i class="fas fa-globe"></i> Lihat Website
        </a>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-gray-400 hover:bg-dark-border hover:text-brutal-red text-sm font-bold uppercase tracking-wider transition">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </nav>
</div>