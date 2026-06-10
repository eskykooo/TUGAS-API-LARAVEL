<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus Gaming')</title>
    <meta name="description" content="@yield('meta_description', 'Nexus Gaming - Portal Berita Gaming Indonesia')">

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.svg">
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
                        'brutal-blue': '#3B82F6',
                        'brutal-purple': '#A855F7',
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
                        'brutal-blue': '4px 4px 0px 0px #3B82F6',
                        'brutal-purple': '4px 4px 0px 0px #A855F7',
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
        .glass-card.hover-shadow-red:hover { box-shadow: 4px 4px 0px 0px #FF1744; }
        .glass-card.hover-shadow-yellow:hover { box-shadow: 4px 4px 0px 0px #FFD600; }
        .glass-card.hover-shadow-green:hover { box-shadow: 4px 4px 0px 0px #00E676; }
        .glass-card.hover-shadow-blue:hover { box-shadow: 4px 4px 0px 0px #3B82F6; }
        .glass-card.hover-shadow-purple:hover { box-shadow: 4px 4px 0px 0px #A855F7; }

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

        /* ============================================================
               ADMIN SIDEBAR — Nexus Gaming Control Center v2
               ============================================================ */
            .admin-layout { display: flex; min-height: calc(100vh - 56px); }

            /* ── Sidebar Container ── */
            .admin-sidebar {
                width: 262px; flex-shrink: 0;
                background: linear-gradient(180deg, #0A0A0A 0%, #0D0D0D 100%);
                border-right: 1px solid rgba(255,107,53,0.12);
                position: sticky; top: 56px; height: calc(100vh - 56px);
                display: flex; flex-direction: column;
                transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
                overflow: clip;
                z-index: 40;
            }
            .admin-sidebar::after {
                content: ''; position: absolute; top: 0; right: 0;
                width: 1px; height: 100%;
                background: linear-gradient(180deg, transparent 0%, rgba(255,107,53,0.3) 20%, rgba(255,107,53,0.1) 80%, transparent 100%);
                pointer-events: none;
            }

            /* ── Collapsed State ── */
            .admin-sidebar.is-collapsed { width: 72px; }
            .admin-sidebar.is-collapsed .brand-text-wrap,
            .admin-sidebar.is-collapsed .profile-details,
            .admin-sidebar.is-collapsed .nav-section-label,
            .admin-sidebar.is-collapsed .link-text,
            .admin-sidebar.is-collapsed .nav-badge,
            .admin-sidebar.is-collapsed .nav-divider,
            .admin-sidebar.is-collapsed .sidebar-footer,
            .admin-sidebar.is-collapsed .link-ext-icon,
            .admin-sidebar.is-collapsed .badge-text {
                opacity: 0; width: 0; overflow: hidden; white-space: nowrap;
                transition: opacity 0.15s ease, width 0.15s ease;
            }
            .admin-sidebar:not(.is-collapsed) .brand-text-wrap,
            .admin-sidebar:not(.is-collapsed) .profile-details,
            .admin-sidebar:not(.is-collapsed) .nav-section-label,
            .admin-sidebar:not(.is-collapsed) .link-text,
            .admin-sidebar:not(.is-collapsed) .nav-badge,
            .admin-sidebar:not(.is-collapsed) .nav-divider,
            .admin-sidebar:not(.is-collapsed) .sidebar-footer,
            .admin-sidebar:not(.is-collapsed) .link-ext-icon,
            .admin-sidebar:not(.is-collapsed) .badge-text {
                opacity: 1; width: auto;
                transition: opacity 0.25s ease 0.1s, width 0.1s ease 0.05s;
            }

            /* ── Brand ── */
            .sidebar-brand {
                display: flex; align-items: center; justify-content: space-between;
                padding: 0.875rem 0.75rem 0.75rem;
                border-bottom: 1px solid rgba(255,255,255,0.04);
                position: relative;
                flex-shrink: 0;
            }
            .sidebar-brand-inner { display: flex; align-items: center; gap: 0.625rem; min-width: 0; }
            .brand-icon-wrap {
                width: 34px; height: 34px;
                background: linear-gradient(135deg, #FF6B35 0%, #FF8F5E 100%);
                border-radius: 0.5rem;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
                box-shadow: 0 2px 12px rgba(255,107,53,0.3);
                position: relative;
            }
            .brand-icon-wrap::after {
                content: ''; position: absolute; inset: -2px;
                border-radius: 0.625rem;
                background: linear-gradient(135deg, rgba(255,107,53,0.4), transparent);
                z-index: -1;
            }
            .brand-icon { color: #000; font-size: 0.9375rem; }
            .brand-text-wrap { min-width: 0; }
            .brand-title {
                display: block;
                font-family: 'Orbitron', sans-serif; font-weight: 900;
                font-size: 0.8125rem; color: #fff;
                text-transform: uppercase; letter-spacing: 0.08em;
                line-height: 1.1;
            }
            .brand-sub {
                display: block;
                font-family: 'Orbitron', sans-serif; font-weight: 700;
                font-size: 0.5rem; color: #FF6B35;
                text-transform: uppercase; letter-spacing: 0.15em;
                line-height: 1.2;
            }
            .sidebar-toggle-btn {
                width: 22px; height: 22px;
                display: flex; align-items: center; justify-content: center;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 0.375rem;
                color: rgba(255,255,255,0.25);
                cursor: pointer;
                transition: all 0.2s ease;
                flex-shrink: 0;
                font-size: 0.5625rem;
            }
            .sidebar-toggle-btn:hover {
                background: rgba(255,107,53,0.12);
                border-color: rgba(255,107,53,0.25);
                color: #FF6B35;
            }

            /* ── Profile Card ── */
            .sidebar-profile {
                display: flex; align-items: center; gap: 0.75rem;
                padding: 0.75rem;
                margin: 0.75rem 0.625rem 0.5rem;
                background: linear-gradient(135deg, rgba(255,107,53,0.06) 0%, rgba(255,107,53,0.02) 100%);
                border: 1px solid rgba(255,107,53,0.1);
                border-radius: 0.75rem;
                position: relative;
                overflow: hidden;
                flex-shrink: 0;
                transition: all 0.3s ease;
            }
            .sidebar-profile::before {
                content: ''; position: absolute; inset: 0;
                background: radial-gradient(120px circle at 30% 40%, rgba(255,107,53,0.08), transparent 70%);
                pointer-events: none;
            }
            .sidebar-profile:hover {
                border-color: rgba(255,107,53,0.2);
                box-shadow: 0 0 20px rgba(255,107,53,0.05);
            }
            .profile-avatar-wrap {
                position: relative; flex-shrink: 0;
            }
            .profile-avatar {
                width: 44px; height: 44px;
                border-radius: 0.625rem;
                border: 2px solid rgba(255,107,53,0.25);
                object-fit: cover;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }
            .sidebar-profile:hover .profile-avatar {
                border-color: rgba(255,107,53,0.5);
                box-shadow: 0 0 16px rgba(255,107,53,0.15);
            }
            .online-indicator {
                position: absolute; bottom: -1px; right: -1px;
                width: 11px; height: 11px;
                background: #00E676;
                border: 2px solid #0D0D0D;
                border-radius: 50%;
                z-index: 1;
            }
            .online-pulse {
                position: absolute; bottom: 0; right: 0;
                width: 15px; height: 15px;
                background: rgba(0,230,118,0.3);
                border-radius: 50%;
                animation: onlinePulse 2s ease-in-out infinite;
            }
            @keyframes onlinePulse {
                0%, 100% { transform: scale(1); opacity: 0.4; }
                50% { transform: scale(1.8); opacity: 0; }
            }
            .profile-details { min-width: 0; }
            .profile-name {
                font-size: 0.8125rem; font-weight: 800; color: #fff;
                text-transform: uppercase; letter-spacing: 0.03em;
                white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            }
            .profile-badge {
                display: inline-flex; align-items: center; gap: 0.25rem;
                margin-top: 0.125rem;
                font-size: 0.5625rem; font-weight: 800; color: #FF6B35;
                text-transform: uppercase; letter-spacing: 0.08em;
                white-space: nowrap;
            }
            .profile-badge i { font-size: 0.5rem; }

            /* ── Navigation ── */
            .sidebar-nav {
                flex: 1; overflow-y: auto; overflow-x: hidden;
                padding: 0 0.375rem 0.5rem;
                scrollbar-width: thin;
                scrollbar-color: rgba(255,255,255,0.06) transparent;
            }
            .sidebar-nav::-webkit-scrollbar { width: 3px; }
            .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
            .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 4px; }
            .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,107,53,0.3); }

            .nav-section-label {
                display: flex; align-items: center; gap: 0.5rem;
                padding: 0.75rem 0.5rem 0.25rem 0.5rem;
                white-space: nowrap;
                transition: opacity 0.25s ease;
            }
            .nav-label-dot { font-size: 0.3125rem; color: rgba(255,107,53,0.5); flex-shrink: 0; }
            .nav-label-text {
                font-size: 0.5625rem; font-weight: 800;
                text-transform: uppercase; letter-spacing: 0.12em;
                color: rgba(255,255,255,0.2);
            }
            .nav-section { display: flex; flex-direction: column; gap: 1px; }

            .nav-divider {
                height: 1px;
                background: linear-gradient(90deg, rgba(255,255,255,0.04), rgba(255,255,255,0.08), rgba(255,255,255,0.04));
                margin: 0.375rem 0.5rem;
                transition: opacity 0.25s ease;
            }

            /* ── Sidebar Link / Nav Item ── */
            .sidebar-link {
                display: flex; align-items: center; gap: 0.625rem;
                padding: 0.5rem 0.625rem;
                font-size: 0.75rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.04em;
                color: rgba(255,255,255,0.3);
                border-radius: 0.5rem;
                transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
                text-decoration: none;
                position: relative;
                white-space: nowrap;
                min-height: 34px;
            }
            .sidebar-link:hover {
                color: rgba(255,255,255,0.85);
                background: rgba(255,107,53,0.06);
            }
            .sidebar-link:active { transform: scale(0.98); }

            /* Active state — orange left accent bar + glow */
            .sidebar-link.active {
                color: #FF6B35;
                background: linear-gradient(90deg, rgba(255,107,53,0.12) 0%, rgba(255,107,53,0.04) 100%);
                box-shadow: inset 3px 0 0 #FF6B35, 0 0 20px rgba(255,107,53,0.06);
            }
            .sidebar-link.active::before {
                content: ''; position: absolute; left: -3px; top: 50%;
                transform: translateY(-50%);
                width: 3px; height: 60%;
                background: #FF6B35;
                border-radius: 0 2px 2px 0;
                box-shadow: 0 0 8px rgba(255,107,53,0.4);
            }
            .sidebar-link.active .link-icon-wrap i {
                filter: drop-shadow(0 0 6px rgba(255,107,53,0.3));
            }

            .link-icon-wrap {
                width: 22px; height: 22px;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .link-icon-wrap i {
                font-size: 0.8125rem;
                transition: transform 0.2s ease;
            }
            .sidebar-link:hover .link-icon-wrap i {
                transform: scale(1.1);
            }
            .link-text { transition: opacity 0.25s ease; min-width: 0; }

            .link-ext-icon {
                font-size: 0.5rem; color: rgba(255,255,255,0.15);
                margin-left: auto;
                transition: opacity 0.25s ease;
            }
            .sidebar-link-ext:hover .link-ext-icon { color: rgba(255,107,53,0.5); }

            /* Logout link */
            .sidebar-link-logout {
                width: 100%; text-align: left;
                cursor: pointer;
                background: none;
                border: none;
                font-family: 'Inter', sans-serif;
            }
            .sidebar-link-logout:hover {
                color: #FF1744 !important;
                background: rgba(255,23,68,0.06) !important;
            }

            /* ── Badges ── */
            .nav-badge {
                display: inline-flex; align-items: center; justify-content: center;
                min-width: 18px; height: 18px;
                padding: 0 5px;
                border-radius: 9px;
                font-size: 0.5625rem; font-weight: 800;
                letter-spacing: 0.02em;
                margin-left: auto;
                flex-shrink: 0;
                transition: opacity 0.25s ease;
                line-height: 1;
            }
            .nav-badge.orange {
                background: rgba(255,107,53,0.15);
                color: #FF6B35;
                border: 1px solid rgba(255,107,53,0.2);
                box-shadow: 0 0 8px rgba(255,107,53,0.08);
            }
            .nav-badge.blue {
                background: rgba(59,130,246,0.15);
                color: #3B82F6;
                border: 1px solid rgba(59,130,246,0.2);
            }
            .nav-badge.red {
                background: rgba(255,23,68,0.15);
                color: #FF1744;
                border: 1px solid rgba(255,23,68,0.2);
                box-shadow: 0 0 8px rgba(255,23,68,0.08);
            }

            /* ── Footer / System Info ── */
            .sidebar-footer {
                flex-shrink: 0;
                padding: 0.625rem 0.625rem 0.75rem;
                border-top: 1px solid rgba(255,255,255,0.04);
                background: rgba(0,0,0,0.3);
                transition: opacity 0.25s ease;
            }
            .sys-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.375rem;
            }
            .sys-item {
                display: flex; align-items: center; gap: 0.5rem;
                padding: 0.4375rem 0.5rem;
                background: rgba(255,255,255,0.02);
                border: 1px solid rgba(255,255,255,0.04);
                border-radius: 0.5rem;
                min-width: 0;
            }
            .sys-dot {
                width: 6px; height: 6px;
                border-radius: 50%;
                flex-shrink: 0;
            }
            .sys-dot-green { background: #00E676; box-shadow: 0 0 6px rgba(0,230,118,0.4); }
            .sys-dot-blue { background: #3B82F6; box-shadow: 0 0 6px rgba(59,130,246,0.4); }
            .sys-dot-orange { background: #FF6B35; box-shadow: 0 0 6px rgba(255,107,53,0.4); }
            .sys-item-text { min-width: 0; }
            .sys-label {
                display: block;
                font-size: 0.46875rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.08em;
                color: rgba(255,255,255,0.2);
                line-height: 1.1;
            }
            .sys-value {
                display: block;
                font-size: 0.625rem; font-weight: 800;
                color: rgba(255,255,255,0.6);
                line-height: 1.3;
            }

            .sys-health {
                margin-top: 0.5rem;
                padding: 0.5rem;
                background: rgba(255,255,255,0.015);
                border: 1px solid rgba(255,255,255,0.03);
                border-radius: 0.5rem;
            }
            .sys-health-header {
                display: flex; justify-content: space-between; align-items: center;
                margin-bottom: 0.375rem;
            }
            .sys-health-label {
                font-size: 0.5rem; font-weight: 700;
                text-transform: uppercase; letter-spacing: 0.08em;
                color: rgba(255,255,255,0.2);
            }
            .sys-health-pct {
                font-size: 0.5625rem; font-weight: 800;
                color: #00E676;
            }
            .sys-health-track {
                width: 100%; height: 3px;
                background: rgba(255,255,255,0.04);
                border-radius: 2px;
                overflow: hidden;
            }
            .sys-health-fill {
                height: 100%;
                background: linear-gradient(90deg, #00E676, #00E676);
                border-radius: 2px;
                transition: width 1s ease;
                box-shadow: 0 0 8px rgba(0,230,118,0.3);
            }

            /* ── Main Content Area ── */
            .admin-main { flex: 1; min-width: 0; padding: 1.25rem; }
    </style>

    {{-- Article Detail Styles --}}
    <style>
        /* ── Reading Progress Bar ── */
        #reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #FF6B35, #FF8F5E, #FF6B35);
            z-index: 9999;
            transition: width 0.1s linear;
            box-shadow: 0 0 12px rgba(255, 107, 53, 0.6), 0 0 24px rgba(255, 107, 53, 0.3);
        }

        /* ── Premium Article Content ── */
        .article-premium h2 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: #FFFFFF;
            font-family: 'Orbitron', sans-serif;
            scroll-margin-top: 5rem;
            letter-spacing: 0.02em;
            position: relative;
            padding-left: 1rem;
        }
        .article-premium h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.25rem;
            bottom: 0.25rem;
            width: 3px;
            background: #FF6B35;
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(255,107,53,0.4);
        }
        .article-premium h3 {
            font-size: 1.375rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            color: #FFFFFF;
            font-family: 'Orbitron', sans-serif;
        }
        .article-premium p {
            margin-bottom: 1.5rem;
            line-height: 1.9;
            font-size: 1.125rem;
            color: #d1d5db;
        }
        .article-premium blockquote {
            border-left: 3px solid #FF6B35;
            padding: 1.25rem 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #9ca3af;
            background: linear-gradient(135deg, rgba(255,107,53,0.06) 0%, transparent 100%);
            border-radius: 0 0.5rem 0.5rem 0;
            font-size: 1.0625rem;
            position: relative;
        }
        .article-premium blockquote::before {
            content: '"';
            position: absolute;
            top: -0.25rem;
            left: 0.75rem;
            font-size: 3rem;
            color: rgba(255,107,53,0.2);
            font-family: serif;
            line-height: 1;
        }
        .article-premium pre {
            background: #000000;
            color: #FFFFFF;
            padding: 1.25rem;
            border: 1px solid rgba(255,107,53,0.15);
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 2rem 0;
            font-size: 0.875rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .article-premium code {
            background: rgba(255,107,53,0.1);
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            color: #FF6B35;
        }
        .article-premium ul, .article-premium ol {
            margin: 1.25rem 0;
            padding-left: 1.5rem;
            line-height: 1.9;
            color: #d1d5db;
        }
        .article-premium li { margin-bottom: 0.5rem; }
        .article-premium img {
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 0.75rem;
            margin: 2rem auto;
            max-width: 100%;
            height: auto;
            box-shadow: 0 4px 24px rgba(0,0,0,0.4);
            transition: box-shadow 0.3s ease;
        }
        .article-premium img:hover {
            box-shadow: 0 8px 40px rgba(0,0,0,0.5), 0 0 20px rgba(255,107,53,0.08);
        }
        .article-premium a {
            color: #FF6B35;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,107,53,0.3);
            transition: all 0.2s ease;
        }
        .article-premium a:hover {
            color: #FFFFFF;
            border-bottom-color: #FFFFFF;
        }
        .article-premium iframe, .article-premium video {
            border-radius: 0.75rem;
            margin: 2rem 0;
            max-width: 100%;
            border: 1px solid rgba(255,255,255,0.06);
        }

        /* ── Premium Card Glow ── */
        .card-glow {
            background: #141414;
            border: 1px solid rgba(255,107,53,0.1);
            border-radius: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .card-glow::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(255,107,53,0.15), transparent 50%, rgba(255,107,53,0.05));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .card-glow:hover {
            border-color: rgba(255,107,53,0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3), 0 0 24px rgba(255,107,53,0.06);
        }
        .card-glow:hover::before { opacity: 1; }

        /* ── Sticky Sidebar ── */
        .sidebar-premium {
            position: sticky;
            top: 5rem;
            transition: all 0.3s ease;
        }

        /* ── Share Button ── */
        .btn-share {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 0.5rem;
            color: #888;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 0.9375rem;
        }
        .btn-share:hover {
            border-color: #FF6B35;
            color: #FF6B35;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,53,0.15);
        }
        .btn-share:active { transform: translateY(0); }

        /* ── Author Box ── */
        .author-box {
            background: linear-gradient(135deg, rgba(255,107,53,0.04) 0%, transparent 100%);
            border: 1px solid rgba(255,107,53,0.12);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .author-box:hover {
            border-color: rgba(255,107,53,0.25);
            box-shadow: 0 0 24px rgba(255,107,53,0.05);
        }

        /* ── Comment Styles ── */
        .comment-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .comment-card:hover {
            border-color: rgba(255,107,53,0.1);
        }
        .comment-card.is-reply {
            margin-left: 2rem;
            border-left: 2px solid rgba(255,107,53,0.15);
            border-radius: 0 0.75rem 0.75rem 0;
        }
        .comment-card.is-reply::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #FF6B35, transparent 80%);
            border-radius: 1px;
            opacity: 0.5;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.125rem 0.5rem;
            font-size: 0.625rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 0.25rem;
        }
        .role-badge.admin {
            background: rgba(255,107,53,0.12);
            color: #FF6B35;
            border: 1px solid rgba(255,107,53,0.2);
        }
        .role-badge.editor {
            background: rgba(59,130,246,0.12);
            color: #3B82F6;
            border: 1px solid rgba(59,130,246,0.2);
        }
        .role-badge.author {
            background: rgba(168,85,247,0.12);
            color: #A855F7;
            border: 1px solid rgba(168,85,247,0.2);
        }

        .reaction-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #666;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1;
        }
        .reaction-btn:hover {
            border-color: rgba(255,107,53,0.15);
            background: rgba(255,107,53,0.04);
        }
        .reaction-btn.is-active {
            color: #FF6B35;
            border-color: rgba(255,107,53,0.2);
            background: rgba(255,107,53,0.06);
        }
        .reaction-btn.is-active .reaction-count {
            color: #FF6B35;
        }

        .reply-form { display: none; }
        .reply-form.is-open { display: block; }

        /* ── Related Article Card ── */
        .related-card {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .related-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255,107,53,0.25);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4), 0 0 24px rgba(255,107,53,0.06);
        }
        .related-card .related-thumb {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .related-card:hover .related-thumb {
            transform: scale(1.05);
        }
        .related-card .related-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10,10,10,0.95) 100%);
            pointer-events: none;
        }
        .related-card .related-cat {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 2;
        }
        .related-card::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(255,107,53,0.2), transparent 50%, transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        .related-card:hover::after {
            opacity: 1;
        }
        .related-card .read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #666;
            transition: all 0.3s ease;
        }
        .related-card:hover .read-more {
            color: #FF6B35;
        }
        .related-card .read-more i {
            transition: transform 0.3s ease;
        }
        .related-card:hover .read-more i {
            transform: translateX(4px);
        }

        /* ── Section dividers ── */
        .section-divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,107,53,0.2), transparent);
            margin: 0;
            border: none;
        }

        /* ── Reading Time Badge ── */
        .read-time-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            background: rgba(255,107,53,0.08);
            border: 1px solid rgba(255,107,53,0.12);
            border-radius: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            color: #FF6B35;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ── Smooth scroll offset for anchor links ── */
        .scroll-offset {
            scroll-margin-top: 5rem;
        }

        /* ── Article hero gradient overlay ── */
        .hero-gradient {
            background: linear-gradient(180deg, transparent 30%, rgba(10,10,10,0.98) 100%);
        }

        /* ── Text gradient ── */
        .text-gradient-orange {
            background: linear-gradient(135deg, #FF6B35, #FF8F5E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Stat item in sidebar ── */
        .sidebar-stat {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5rem 0;
        }
        .sidebar-stat-icon {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,107,53,0.06);
            border: 1px solid rgba(255,107,53,0.08);
            border-radius: 0.5rem;
            color: #FF6B35;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        /* ── Sidebar Progress ── */
        .sidebar-progress-track {
            width: 100%;
            height: 3px;
            background: rgba(255,255,255,0.04);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 0.375rem;
        }
        .sidebar-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #FF6B35, #FF8F5E);
            border-radius: 2px;
            transition: width 0.2s ease;
            width: 0%;
        }

        /* ── Responsive tweaks ── */
        @media (max-width: 1023px) {
            .article-premium p { font-size: 1rem; }
            .article-premium h2 { font-size: 1.5rem; }
            .comment-card.is-reply { margin-left: 1rem; }
        }
        @media (max-width: 639px) {
            .comment-card.is-reply { margin-left: 0.75rem; }
        }

        /* ── Author Profile Page ── */
        .author-hero-glow {
            background: radial-gradient(600px circle at 50% 0%, rgba(255,107,53,0.06) 0%, transparent 70%);
        }
        .stat-card-author {
            background: linear-gradient(135deg, rgba(255,107,53,0.04) 0%, transparent 100%);
            border: 1px solid rgba(255,107,53,0.08);
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }
        .stat-card-author:hover {
            border-color: rgba(255,107,53,0.2);
            box-shadow: 0 0 20px rgba(255,107,53,0.04);
            transform: translateY(-1px);
        }
        .rank-number {
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            font-size: 1.25rem;
            color: rgba(255,107,53,0.15);
            line-height: 1;
        }
        .category-bar {
            height: 4px;
            background: rgba(255,255,255,0.04);
            border-radius: 2px;
            overflow: hidden;
        }
        .category-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #FF6B35, #FF8F5E);
            border-radius: 2px;
            transition: width 0.6s ease;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Reading Progress Bar --}}
    <div id="reading-progress" x-data="{}" x-init="window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        document.getElementById('reading-progress').style.width = progress + '%';
    })"></div>

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
                            @foreach(['pc-gaming','console','mobile','esports','gaming-news','reviews','guides'] as $cat)
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-6 lg:gap-8">
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-brutal-orange flex items-center justify-center flex-shrink-0 rounded border-2 border-brutal-black">
                            <i class="fas fa-gamepad text-brutal-black text-lg"></i>
                        </div>
                        <div>
                            <span class="font-orbitron font-black text-lg text-white tracking-wider uppercase block leading-none">Nexus</span>
                            <span class="font-orbitron font-bold text-[10px] text-brutal-orange tracking-widest uppercase">Gaming</span>
                        </div>
                    </a>
                    <p class="text-xs leading-relaxed text-gray-400 font-bold uppercase tracking-wider">Portal berita gaming Indonesia. Update terkini seputar PC gaming, console, mobile, esports, dan industri game terkini.</p>
                    <div class="flex gap-2 mt-4">
                        <a href="#" class="w-8 h-8 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200" aria-label="Twitter"><i class="fab fa-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200" aria-label="Discord"><i class="fab fa-discord text-xs"></i></a>
                        <a href="#" class="w-8 h-8 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200" aria-label="Instagram"><i class="fab fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200" aria-label="YouTube"><i class="fab fa-youtube text-xs"></i></a>
                        <a href="#" class="w-8 h-8 bg-dark-card border-2 border-dark-border rounded flex items-center justify-center hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200" aria-label="TikTok"><i class="fab fa-tiktok text-xs"></i></a>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-[10px] text-gray-600 font-bold uppercase tracking-wider">
                        <i class="fas fa-shield-alt text-brutal-orange"></i>
                        <span>Terpercaya &amp; Terverifikasi</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-orbitron font-bold text-white mb-4 uppercase tracking-wider text-xs">Kategori</h4>
                    <ul class="space-y-2.5">
                        @foreach(['pc-gaming','console','mobile','esports','gaming-news','reviews','guides'] as $cat)
                        <li><a href="/categories/{{ $cat }}" class="text-gray-400 hover:text-brutal-orange transition-colors flex items-center gap-2 font-bold uppercase tracking-wider text-[11px]"><i class="fas fa-chevron-right text-[9px] text-brutal-orange"></i> {{ str_replace('-', ' ', $cat) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-orbitron font-bold text-white mb-4 uppercase tracking-wider text-xs">Artikel Terbaru</h4>
                    <div class="space-y-3">
                        @isset($footerArticles)
                            @foreach($footerArticles as $fa)
                            <a href="/articles/{{ $fa->slug }}" class="flex gap-2.5 group">
                                @if($fa->thumbnail_url)
                                <img src="{{ $fa->thumbnail_url }}" alt="{{ $fa->title }}" class="w-14 h-10 rounded object-cover flex-shrink-0 border border-dark-border" loading="lazy">
                                @else
                                <div class="w-14 h-10 rounded flex-shrink-0 bg-dark-card border-2 border-dark-border flex items-center justify-center"><i class="fas fa-gamepad text-gray-500 text-base"></i></div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-gray-300 group-hover:text-brutal-orange transition-colors line-clamp-2 leading-snug font-bold">{{ $fa->title }}</p>
                                    <p class="text-[10px] text-gray-500 mt-1 font-bold uppercase tracking-wider">{{ $fa->published_at?->diffForHumans() }}</p>
                                </div>
                            </a>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <div>
                    <h4 class="font-orbitron font-bold text-white mb-4 uppercase tracking-wider text-xs">Tag Populer</h4>
                    <div class="flex flex-wrap gap-1.5">
                        @isset($tags)
                            @foreach($tags->take(10) as $tag)
                            <a href="/search?tag={{ $tag->slug }}" class="inline-block px-2 py-1 text-[10px] font-bold uppercase tracking-wider bg-dark-card text-gray-400 border border-dark-border hover:bg-brutal-orange hover:text-brutal-black hover:border-brutal-orange transition-all duration-200">#{{ $tag->name }}</a>
                            @endforeach
                        @endisset
                    </div>

                </div>
            </div>
            <div class="border-t-2 border-dark-border mt-8 lg:mt-10 pt-5 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">&copy; {{ date('Y') }} Nexus Gaming. All rights reserved.</p>
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600 flex items-center gap-1.5"><i class="fas fa-heart text-brutal-orange"></i> Made for Indonesian gamers</p>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({ duration: 400, once: true, offset: 60, disable: window.innerWidth < 640 });
    </script>
    @stack('scripts')
</body>
</html>