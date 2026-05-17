<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" x-init="darkMode && document.documentElement.classList.add('dark'); $watch('darkMode', val => { document.documentElement.classList.toggle('dark', val); localStorage.setItem('darkMode', val) })" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog CMS')</title>
    <meta name="description" content="@yield('meta_description', 'Blog CMS - Portal Berita & Blog')">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            plugins: [tailwindcss.typography],
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#0ea5e9', secondary: '#6366f1' }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .marquee-wrapper { overflow: hidden; position: relative; width: 100%; }
        .marquee-track { display: flex; animation: marquee 40s linear infinite; width: max-content; min-width: 100%; }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .marquee-track > span { white-space: nowrap; }
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body { overflow-x: hidden; }
        [x-cloak] { display: none !important; }
    </style>
    <style>
        .article-content h2 { font-size: 1.75rem; font-weight: 700; margin-top: 2.5rem; margin-bottom: 1rem; color: #1e293b; scroll-margin-top: 5rem; }
        .dark .article-content h2 { color: #f1f5f9; }
        .article-content h3 { font-size: 1.375rem; font-weight: 600; margin-top: 2rem; margin-bottom: 0.75rem; color: #1e293b; }
        .dark .article-content h3 { color: #e2e8f0; }
        .article-content p { margin-bottom: 1.25rem; line-height: 1.8; font-size: 1.125rem; }
        .article-content blockquote { border-left: 4px solid #0ea5e9; padding: 1rem 1.5rem; margin: 1.5rem 0; font-style: italic; color: #64748b; background: #f8fafc; border-radius: 0 0.75rem 0.75rem 0; }
        .dark .article-content blockquote { background: #1e293b; color: #94a3b8; }
        .article-content pre { background: #1e293b; color: #e2e8f0; padding: 1.25rem; border-radius: 0.75rem; overflow-x: auto; margin: 1.5rem 0; font-size: 0.875rem; }
        .article-content code { background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.875rem; }
        .dark .article-content code { background: #334155; }
        .article-content ul, .article-content ol { margin: 1rem 0; padding-left: 1.5rem; line-height: 1.8; }
        .article-content img { border-radius: 0.75rem; margin: 1.5rem auto; max-width: 100%; height: auto; }
        .article-content a { color: #0ea5e9; text-decoration: underline; text-underline-offset: 2px; }
        .article-content a:hover { color: #0284c7; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 transition-colors duration-300 flex flex-col min-h-screen">

    <nav x-data="{ scrolled: false, mobileOpen: false, catOpen: false }"
         @scroll.window="scrolled = window.scrollY > 50"
         :class="scrolled ? 'bg-white/95 dark:bg-slate-900/95 backdrop-blur-md shadow-lg' : 'bg-transparent'"
         class="fixed top-0 w-full z-50 transition-all duration-300 h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full gap-4">
                <a href="/" class="flex items-center gap-2 flex-shrink-0 mr-4">
                    <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-newspaper text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-sky-500 hidden sm:inline">BlogCMS</span>
                </a>

                <div class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a href="/" class="font-medium text-sm lg:text-base hover:text-sky-500 transition-colors whitespace-nowrap">Beranda</a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1 font-medium text-sm lg:text-base hover:text-sky-500 transition-colors whitespace-nowrap">
                            Kategori <i class="fas fa-chevron-down text-xs transition-transform" :class="open && 'rotate-180'"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 py-2 z-50"
                             @click.away="open = false">
                            @foreach(['teknologi','politik','olahraga','hiburan','bisnis'] as $cat)
                            <a href="/categories/{{ $cat }}" class="block px-4 py-2.5 hover:bg-sky-50 dark:hover:bg-slate-700 hover:text-sky-500 capitalize transition-colors text-sm">{{ ucfirst($cat) }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="/search" class="font-medium text-sm lg:text-base hover:text-sky-500 transition-colors whitespace-nowrap">Cari</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 ml-auto">
                    <button @click="darkMode = !darkMode" class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors flex-shrink-0" aria-label="Toggle dark mode">
                        <i x-show="!darkMode" class="fas fa-moon text-slate-600 dark:text-slate-300"></i>
                        <i x-show="darkMode" class="fas fa-sun text-yellow-400"></i>
                    </button>
                    @guest
                    <a href="/login" class="hidden md:inline-flex px-4 sm:px-5 py-2 text-sm font-medium border border-sky-500 text-sky-500 rounded-xl hover:bg-sky-500 hover:text-white transition-all whitespace-nowrap">Masuk</a>
                    <a href="/register" class="hidden md:inline-flex px-4 sm:px-5 py-2 text-sm font-medium bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors whitespace-nowrap">Daftar</a>
                    @endguest
                    @auth
                    <a href="/dashboard" class="hidden md:inline-flex items-center gap-2 px-3 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors text-sm whitespace-nowrap">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0ea5e9&color=fff&size=32" class="w-6 h-6 rounded-full flex-shrink-0">
                        <span class="truncate max-w-[100px]">Dasbor</span>
                    </a>
                    @endauth
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors flex-shrink-0" aria-label="Menu">
                        <i x-show="!mobileOpen" class="fas fa-bars text-slate-600 dark:text-slate-300"></i>
                        <i x-show="mobileOpen" class="fas fa-times text-slate-600 dark:text-slate-300"></i>
                    </button>
                </div>
            </div>

            <div x-show="mobileOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="md:hidden bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 mt-0 pt-4 pb-6 space-y-1 rounded-b-2xl shadow-xl absolute left-0 right-0 top-full">
                <a href="/" class="block px-4 py-3 rounded-xl hover:bg-sky-50 dark:hover:bg-slate-800 font-medium">Beranda</a>
                <a href="/categories" class="block px-4 py-3 rounded-xl hover:bg-sky-50 dark:hover:bg-slate-800 font-medium">Kategori</a>
                <a href="/search" class="block px-4 py-3 rounded-xl hover:bg-sky-50 dark:hover:bg-slate-800 font-medium">Cari</a>
                <hr class="border-slate-200 dark:border-slate-700 my-2 mx-4">
                @auth
                <a href="/dashboard" class="block px-4 py-3 rounded-xl hover:bg-sky-50 dark:hover:bg-slate-800 font-medium">Dasbor</a>
                <form method="POST" action="/logout" class="px-4">@csrf<button type="submit" class="w-full text-left px-3 py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 font-medium">Keluar</button></form>
                @else
                <a href="/login" class="block px-4 py-3 rounded-xl hover:bg-sky-50 dark:hover:bg-slate-800 font-medium text-sky-500">Masuk</a>
                <div class="px-4 pt-1">
                    <a href="/register" class="block w-full text-center px-4 py-3 bg-sky-500 text-white rounded-xl font-medium">Daftar</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-16 flex-1">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">
                <div class="md:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-newspaper text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-xl text-white">BlogCMS</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400 max-w-sm">Platform berita dan blog terpercaya untuk informasi terkini seputar teknologi, politik, olahraga, hiburan, dan bisnis Indonesia.</p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-sky-500 transition-colors" aria-label="Twitter"><i class="fab fa-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-sky-500 transition-colors" aria-label="Facebook"><i class="fab fa-facebook text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-sky-500 transition-colors" aria-label="Instagram"><i class="fab fa-instagram text-sm"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5">Kategori</h4>
                    <ul class="space-y-3 text-sm">
                        @foreach(['Teknologi','Politik','Olahraga','Hiburan','Bisnis'] as $cat)
                        <li><a href="/categories/{{ strtolower($cat) }}" class="hover:text-sky-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-sky-500"></i> {{ $cat }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5">Artikel Terbaru</h4>
                    <div class="space-y-4">
                        @isset($footerArticles)
                            @foreach($footerArticles as $fa)
                            <a href="/articles/{{ $fa->slug }}" class="flex gap-3 group">
                                <img src="https://picsum.photos/seed/{{ $fa->slug }}/80/60" alt="{{ $fa->title }}" class="w-16 h-12 rounded-lg object-cover flex-shrink-0" loading="lazy">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-slate-300 group-hover:text-sky-400 transition-colors line-clamp-2 leading-snug">{{ $fa->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1.5">{{ $fa->published_at?->diffForHumans() }}</p>
                                </div>
                            </a>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 lg:mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} BlogCMS. Dibuat dengan Laravel &amp; Tailwind CSS</p>
                <p class="text-xs text-slate-600">All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({ duration: 600, once: true, offset: 80, disable: window.innerWidth < 640 });
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                if (Alpine.store('darkMode')) document.documentElement.classList.add('dark');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>