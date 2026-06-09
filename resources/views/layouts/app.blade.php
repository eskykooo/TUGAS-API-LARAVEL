<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus Gaming')</title>
    <meta name="description" content="@yield('meta_description', 'Nexus Gaming - Portal Berita Gaming Indonesia')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Orbitron:wght@600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com">
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        orbitron: ['Orbitron', 'sans-serif'],
                    },
                    colors: {
                        'dark-bg': '#0A0A0A',
                        'dark-card': '#141414',
                        'dark-border': '#1a1a1a',
                        'brutal-orange': '#FF6B35',
                        'brutal-red': '#FF1744',
                        'brutal-yellow': '#FFD600',
                        'brutal-green': '#00E676',
                        'brutal-white': '#FFFFFF',
                        'brutal-black': '#000000',
                        gray: {
                            300: '#cccccc',
                            400: '#999999',
                            500: '#888888',
                            600: '#777777',
                            700: '#666666',
                            800: '#444444',
                        }
                    },
                    boxShadow: {
                        'brutal': '4px 4px 0px 0px #000000',
                        'brutal-lg': '6px 6px 0px 0px #000000',
                        'brutal-orange': '4px 4px 0px 0px #FF6B35',
                        'brutal-white': '4px 4px 0px 0px #FFFFFF',
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-orbitron { font-family: 'Orbitron', sans-serif; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .marquee-wrapper { overflow: hidden; position: relative; width: 100%; }
        .marquee-track { display: flex; animation: marquee 40s linear infinite; width: max-content; min-width: 100%; }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .marquee-track > span { white-space: nowrap; }

        html { scroll-behavior: smooth; overflow-x: hidden; }
        body { overflow-x: hidden; background: #0A0A0A; color: #FFFFFF; }
        [x-cloak] { display: none !important; }

        .glass-card {
            background: #141414;
            border: 2px solid #FF6B35;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .glass-card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px 0px #FF6B35;
        }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.625rem 1.25rem; font-weight: 700; font-size: 0.875rem;
            text-transform: uppercase; letter-spacing: 0.05em;
            background: #FF6B35; color: #000000;
            border: 2px solid #000000; border-radius: 0.5rem;
            box-shadow: 4px 4px 0px 0px #000000;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #000000;
        }
        .btn-primary:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #000000;
        }

        .btn-outline {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.625rem 1.25rem; font-weight: 700; font-size: 0.875rem;
            text-transform: uppercase; letter-spacing: 0.05em;
            background: transparent; color: #FFFFFF;
            border: 2px solid #FFFFFF; border-radius: 0.5rem;
            box-shadow: 4px 4px 0px 0px #FFFFFF;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .btn-outline:hover {
            background: #FFFFFF; color: #0A0A0A;
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #FFFFFF;
        }
        .btn-outline:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #FFFFFF;
        }

        .btn-danger {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.625rem 1.25rem; font-weight: 700; font-size: 0.875rem;
            text-transform: uppercase; letter-spacing: 0.05em;
            background: #FF1744; color: #FFFFFF;
            border: 2px solid #000000; border-radius: 0.5rem;
            box-shadow: 4px 4px 0px 0px #000000;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .btn-danger:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #000000;
        }

        .btn-ghost {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.5rem 1rem; font-weight: 600; font-size: 0.875rem;
            background: transparent; color: #FFFFFF;
            border: 2px solid transparent; border-radius: 0.5rem;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .btn-ghost:hover {
            background: #1a1a1a;
            border-color: #FF6B35;
        }

        .input-brutal {
            width: 100%; padding: 0.75rem 1rem;
            background: #000000; color: #FFFFFF;
            border: 2px solid #1a1a1a; border-radius: 0.5rem;
            outline: none; font-size: 0.9375rem;
            transition: border-color 0.15s ease;
        }
        .input-brutal:focus {
            border-color: #FF6B35;
            box-shadow: none;
        }
        .input-brutal::placeholder { color: #555555; }

        .select-brutal {
            width: 100%; padding: 0.75rem 1rem;
            background: #000000; color: #FFFFFF;
            border: 2px solid #1a1a1a; border-radius: 0.5rem;
            outline: none; font-size: 0.9375rem;
            transition: border-color 0.15s ease;
            cursor: pointer;
        }
        .select-brutal:focus { border-color: #FF6B35; }

        .tag-brutal {
            display: inline-flex; align-items: center;
            padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            background: #000000; color: #FF6B35;
            border: 2px solid #FF6B35; border-radius: 0.25rem;
        }

        .trix-button-group { border-color: #1a1a1a !important; }
        .trix-button { color: #FFFFFF !important; border-bottom: none !important; }
        .trix-button::before { filter: brightness(0) invert(1); }
        .trix-button.trix-active { background: #FF6B35 !important; color: #000000 !important; }
        .trix-button.trix-active::before { filter: none; }
        trix-toolbar { margin-bottom: 0.75rem; }
        trix-toolbar .trix-button-row { gap: 0.25rem; flex-wrap: wrap; }
        trix-toolbar .trix-button { border-radius: 0.25rem; height: 2rem; background: #1a1a1a; }
        trix-toolbar .trix-button-group:not(:first-child) { margin-left: 0.5rem; }
        trix-dialog { background: #141414; border: 2px solid #FF6B35; border-radius: 0.5rem; }
        trix-dialog .trix-input { background: #000000; color: #FFFFFF; border: 2px solid #1a1a1a; border-radius: 0.25rem; padding: 0.5rem; }
        trix-dialog .trix-button--dialog { background: #1a1a1a; color: #FFFFFF !important; border: none; padding: 0.375rem 0.75rem; font-weight: bold; cursor: pointer; }
        trix-dialog .trix-button--dialog:hover { background: #FF6B35; color: #000000 !important; }

        .article-content h2 { font-size: 1.75rem; font-weight: 800; margin-top: 2.5rem; margin-bottom: 1rem; color: #FFFFFF; font-family: 'Orbitron', sans-serif; scroll-margin-top: 5rem; }
        .article-content h3 { font-size: 1.375rem; font-weight: 700; margin-top: 2rem; margin-bottom: 0.75rem; color: #FFFFFF; font-family: 'Orbitron', sans-serif; }
        .article-content p { margin-bottom: 1.25rem; line-height: 1.8; font-size: 1.125rem; color: #CCCCCC; }
        .article-content blockquote { border-left: 4px solid #FF6B35; padding: 1rem 1.5rem; margin: 1.5rem 0; font-style: italic; color: #AAAAAA; background: #141414; border-radius: 0; }
        .article-content pre { background: #000000; color: #FFFFFF; padding: 1.25rem; border: 2px solid #1a1a1a; border-radius: 0.5rem; overflow-x: auto; margin: 1.5rem 0; font-size: 0.875rem; }
        .article-content code { background: #1a1a1a; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.875rem; color: #FF6B35; }
        .article-content ul, .article-content ol { margin: 1rem 0; padding-left: 1.5rem; line-height: 1.8; color: #CCCCCC; }
        .article-content img { border: 2px solid #1a1a1a; border-radius: 0.5rem; margin: 1.5rem auto; max-width: 100%; height: auto; }
        .article-content a { color: #FF6B35; text-decoration: underline; text-underline-offset: 2px; }
        .article-content a:hover { color: #FFFFFF; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0A0A0A; }
        ::-webkit-scrollbar-thumb { background: #1a1a1a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF6B35; }
    </style>
    @stack('styles')
</head>
<body>

    <nav x-data="{ mobileOpen: false, catOpen: false }"
         class="fixed top-0 w-full z-50 bg-dark-bg border-b-2 border-brutal-orange h-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full gap-4">
                <a href="/" class="flex items-center gap-2 flex-shrink-0 mr-4">
                    <div class="w-8 h-8 bg-brutal-orange flex items-center justify-center flex-shrink-0 rounded">
                        <i class="fas fa-gamepad text-brutal-black text-sm"></i>
                    </div>
                    <span class="font-orbitron font-black text-lg text-brutal-orange hidden sm:inline tracking-wider uppercase">Nexus</span>
                </a>

                <div class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a href="/" class="font-bold text-sm lg:text-base text-white hover:text-brutal-orange transition-colors uppercase tracking-wider whitespace-nowrap">Beranda</a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1 font-bold text-sm lg:text-base text-white hover:text-brutal-orange transition-colors uppercase tracking-wider whitespace-nowrap">
                            Kategori <i class="fas fa-chevron-down text-xs transition-transform" :class="open && 'rotate-180'"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute top-full left-0 mt-2 w-48 bg-dark-card border-2 border-brutal-orange py-2 z-50"
                             @click.away="open = false">
                            @foreach(['pc-gaming','console','mobile','esports','gaming-news'] as $cat)
                            <a href="/categories/{{ $cat }}" class="block px-4 py-2.5 hover:bg-brutal-orange hover:text-brutal-black font-bold text-sm uppercase tracking-wider transition-colors">{{ str_replace('-', ' ', $cat) }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="/search" class="font-bold text-sm lg:text-base text-white hover:text-brutal-orange transition-colors uppercase tracking-wider whitespace-nowrap">Cari</a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 ml-auto">
                    @guest
                    <a href="/login" class="btn-outline text-xs px-3 py-1.5 hidden md:inline-flex">Masuk</a>
                    <a href="/register" class="btn-primary text-xs px-3 py-1.5 hidden md:inline-flex">Daftar</a>
                    @endguest
                    @auth
                    <div class="hidden md:flex items-center gap-2">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange transition-colors px-2 py-1">
                                <img src="{{ auth()->user()->avatarUrl(32) }}" alt="" class="w-7 h-7 rounded flex-shrink-0">
                                <span class="font-bold text-sm text-white truncate max-w-[80px] uppercase tracking-wider">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform" :class="open && 'rotate-180'"></i>
                            </button>
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute right-0 top-full mt-2 w-56 bg-dark-card border-2 border-brutal-orange shadow-brutal-lg z-50"
                                 @click.away="open = false">
                                <div class="px-4 py-3 border-b-2 border-dark-border flex items-center gap-3">
                                    <img src="{{ auth()->user()->avatarUrl(40) }}" alt="" class="w-10 h-10 rounded border-2 border-brutal-orange flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-bold text-white text-sm truncate uppercase tracking-wider">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="/dashboard" class="flex items-center gap-3 px-4 py-2.5 hover:bg-brutal-orange hover:text-brutal-black font-bold text-sm uppercase tracking-wider transition-colors"><i class="fas fa-th-large w-4 text-center"></i> Dasbor</a>
                                    <a href="/profile" class="flex items-center gap-3 px-4 py-2.5 hover:bg-brutal-orange hover:text-brutal-black font-bold text-sm uppercase tracking-wider transition-colors"><i class="fas fa-user-cog w-4 text-center"></i> Profil</a>
                                    <a href="/profile/security" class="flex items-center gap-3 px-4 py-2.5 hover:bg-brutal-orange hover:text-brutal-black font-bold text-sm uppercase tracking-wider transition-colors"><i class="fas fa-shield-alt w-4 text-center"></i> Keamanan</a>
                                </div>
                                <div class="border-t-2 border-dark-border py-1">
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-brutal-red hover:text-white font-bold text-sm uppercase tracking-wider transition-colors"><i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden w-9 h-9 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:border-brutal-orange transition-colors flex-shrink-0" aria-label="Menu">
                        <i x-show="!mobileOpen" class="fas fa-bars text-white"></i>
                        <i x-show="mobileOpen" class="fas fa-times text-white"></i>
                    </button>
                </div>
            </div>

            <div x-show="mobileOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="md:hidden bg-dark-card border-t-2 border-brutal-orange mt-0 pt-4 pb-6 space-y-1 absolute left-0 right-0 top-full">
                <a href="/" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors">Beranda</a>
                <a href="/categories" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors">Kategori</a>
                <a href="/search" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors">Cari</a>
                <hr class="border-dark-border my-2 mx-4">
                @auth
                <div class="flex items-center gap-3 px-4 py-3 border-b border-dark-border">
                    <img src="{{ auth()->user()->avatarUrl(40) }}" alt="" class="w-8 h-8 rounded border-2 border-brutal-orange flex-shrink-0">
                    <div class="min-w-0">
                        <p class="font-bold text-white text-sm truncate uppercase tracking-wider">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <a href="/profile" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors"><i class="fas fa-user-cog mr-2"></i> Edit Profil</a>
                <a href="/profile/security" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors"><i class="fas fa-shield-alt mr-2"></i> Keamanan</a>
                <a href="/dashboard" class="block px-4 py-3 font-bold uppercase tracking-wider hover:bg-brutal-orange hover:text-brutal-black transition-colors"><i class="fas fa-th-large mr-2"></i> Dasbor</a>
                <form method="POST" action="/logout" class="px-4">@csrf<button type="submit" class="w-full text-left px-3 py-3 font-bold uppercase tracking-wider hover:bg-brutal-red hover:text-white transition-colors"><i class="fas fa-sign-out-alt mr-2"></i> Keluar</button></form>
                @else
                <a href="/login" class="block px-4 py-3 font-bold uppercase tracking-wider text-brutal-orange hover:bg-brutal-orange hover:text-brutal-black transition-colors">Masuk</a>
                <div class="px-4 pt-1">
                    <a href="/register" class="block w-full text-center px-4 py-3 bg-brutal-orange text-brutal-black font-bold uppercase tracking-wider border-2 border-brutal-black">Daftar</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-14 flex-1">
        @yield('content')
    </main>

    <footer class="bg-dark-bg border-t-4 border-brutal-orange mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">
                <div class="md:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-brutal-orange flex items-center justify-center flex-shrink-0 rounded">
                            <i class="fas fa-gamepad text-brutal-black text-lg"></i>
                        </div>
                        <div>
                            <span class="font-orbitron font-black text-xl text-white tracking-wider uppercase block">Nexus</span>
                            <span class="font-orbitron font-bold text-xs text-brutal-orange tracking-widest uppercase">Gaming</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400 max-w-sm">Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game terkini.</p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:border-brutal-orange hover:text-brutal-orange transition-colors" aria-label="Twitter"><i class="fab fa-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:border-brutal-orange hover:text-brutal-orange transition-colors" aria-label="Discord"><i class="fab fa-discord text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:border-brutal-orange hover:text-brutal-orange transition-colors" aria-label="Instagram"><i class="fab fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:border-brutal-orange hover:text-brutal-orange transition-colors" aria-label="YouTube"><i class="fab fa-youtube text-sm"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-orbitron font-bold text-white mb-5 uppercase tracking-wider text-sm">Kategori</h4>
                    <ul class="space-y-3 text-sm">
                        @foreach(['pc-gaming','console','mobile','esports','gaming-news','review'] as $cat)
                        <li><a href="/categories/{{ $cat }}" class="text-gray-400 hover:text-brutal-orange transition-colors flex items-center gap-2 font-bold uppercase tracking-wider text-xs"><i class="fas fa-chevron-right text-xs text-brutal-orange"></i> {{ str_replace('-', ' ', $cat) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-orbitron font-bold text-white mb-5 uppercase tracking-wider text-sm">Artikel Terbaru</h4>
                    <div class="space-y-4">
                        @isset($footerArticles)
                            @foreach($footerArticles as $fa)
                            <a href="/articles/{{ $fa->slug }}" class="flex gap-3 group">
                                @if($fa->thumbnail_url)
                                <img src="{{ $fa->thumbnail_url }}" alt="{{ $fa->title }}" class="w-16 h-12 rounded object-cover flex-shrink-0 border border-dark-border" loading="lazy">
                                @else
                                <div class="w-16 h-12 rounded flex-shrink-0 bg-dark-card border-2 border-dark-border flex items-center justify-center"><i class="fas fa-gamepad text-gray-500 text-lg"></i></div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 group-hover:text-brutal-orange transition-colors line-clamp-2 leading-snug font-bold">{{ $fa->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1.5 font-bold uppercase tracking-wider">{{ $fa->published_at?->diffForHumans() }}</p>
                                </div>
                            </a>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
            <div class="border-t-2 border-dark-border mt-10 lg:mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-500">
                <p class="font-bold uppercase tracking-wider">&copy; {{ date('Y') }} Nexus Gaming. Powered by Laravel &amp; Tailwind CSS</p>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-600">All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({ duration: 400, once: true, offset: 60, disable: window.innerWidth < 640 });
    </script>
    @stack('scripts')
</body>
</html>