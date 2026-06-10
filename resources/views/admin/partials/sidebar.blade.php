@props(['current' => 'dashboard'])

<div x-data="{ collapsed: false }" :class="collapsed && 'is-collapsed'" class="admin-sidebar hidden lg:flex">

    {{-- Brand + Toggle --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-inner">
            <div class="brand-icon-wrap">
                <i class="fas fa-gamepad brand-icon"></i>
            </div>
            <div class="brand-text-wrap">
                <span class="brand-title">Nexus</span>
                <span class="brand-sub">Control Center</span>
            </div>
        </div>
        <button @click="collapsed = !collapsed" class="sidebar-toggle-btn" title="Toggle sidebar">
            <i class="fas" :class="collapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
        </button>
    </div>

    {{-- Profile Card --}}
    <div class="sidebar-profile">
        <div class="profile-avatar-wrap">
            <img src="{{ auth()->user()->avatarUrl(56) }}" alt="" class="profile-avatar" loading="lazy">
            <span class="online-indicator"></span>
            <span class="online-pulse"></span>
        </div>
        <div class="profile-details">
            <h4 class="profile-name">{{ auth()->user()->name }}</h4>
            <span class="profile-badge">
                <i class="fas fa-shield-alt"></i>
                <span class="badge-text">Administrator</span>
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        {{-- Main Menu --}}
        <div class="nav-section-label">
            <i class="fas fa-circle nav-label-dot"></i>
            <span class="nav-label-text">Menu Utama</span>
        </div>
        <div class="nav-section">
            <a href="/admin" class="sidebar-link {{ $current === 'dashboard' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-th-large"></i></div>
                <span class="link-text">Dashboard</span>
            </a>
        </div>

        {{-- Content --}}
        <div class="nav-section-label">
            <i class="fas fa-circle nav-label-dot"></i>
            <span class="nav-label-text">Konten</span>
        </div>
        <div class="nav-section">
            <a href="/admin/articles" class="sidebar-link {{ $current === 'articles' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-file-alt"></i></div>
                <span class="link-text">Artikel</span>
                @if(($sidebarCounts['pendingArticles'] ?? 0) > 0)
                <span class="nav-badge orange">{{ $sidebarCounts['pendingArticles'] }}</span>
                @endif
            </a>
            <a href="/admin/categories" class="sidebar-link {{ $current === 'categories' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-folder"></i></div>
                <span class="link-text">Kategori</span>
            </a>
            <a href="/admin/tags" class="sidebar-link {{ $current === 'tags' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-tags"></i></div>
                <span class="link-text">Tag</span>
            </a>
        </div>

        {{-- Engagement --}}
        <div class="nav-section-label">
            <i class="fas fa-circle nav-label-dot"></i>
            <span class="nav-label-text">Interaksi</span>
        </div>
        <div class="nav-section">
            <a href="/admin/comments" class="sidebar-link {{ $current === 'comments' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-comments"></i></div>
                <span class="link-text">Komentar</span>
                @if(($sidebarCounts['pendingComments'] ?? 0) > 0)
                <span class="nav-badge blue">{{ $sidebarCounts['pendingComments'] }}</span>
                @endif
            </a>
            <a href="/admin/users" class="sidebar-link {{ $current === 'users' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-users"></i></div>
                <span class="link-text">Pengguna</span>
            </a>
        </div>

        {{-- System --}}
        <div class="nav-section-label">
            <i class="fas fa-circle nav-label-dot"></i>
            <span class="nav-label-text">Sistem</span>
        </div>
        <div class="nav-section">
            <a href="/admin/notifications" class="sidebar-link {{ $current === 'notifications' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-bell"></i></div>
                <span class="link-text">Notifikasi</span>
                @php $totalPending = ($sidebarCounts['pendingArticles'] ?? 0) + ($sidebarCounts['pendingComments'] ?? 0); @endphp
                @if($totalPending > 0)
                <span class="nav-badge red">{{ $totalPending }}</span>
                @endif
            </a>
            <a href="/admin/activity" class="sidebar-link {{ $current === 'activity' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-history"></i></div>
                <span class="link-text">Aktivitas</span>
            </a>
            <a href="/admin/settings" class="sidebar-link {{ $current === 'settings' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-cogs"></i></div>
                <span class="link-text">Pengaturan</span>
            </a>
            <a href="/admin/security" class="sidebar-link {{ $current === 'security' ? 'active' : '' }}">
                <div class="link-icon-wrap"><i class="fas fa-shield-alt"></i></div>
                <span class="link-text">Keamanan</span>
            </a>
        </div>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- Extra Links --}}
        <div class="nav-section">
            <a href="/" target="_blank" class="sidebar-link sidebar-link-ext">
                <div class="link-icon-wrap"><i class="fas fa-globe"></i></div>
                <span class="link-text">Lihat Website</span>
                <i class="fas fa-external-link-alt link-ext-icon"></i>
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="sidebar-link sidebar-link-logout">
                    <div class="link-icon-wrap"><i class="fas fa-sign-out-alt"></i></div>
                    <span class="link-text">Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- System Info Footer --}}
    <div class="sidebar-footer">
        {{-- Status Grid --}}
        <div class="sys-grid">
            <div class="sys-item">
                <span class="sys-dot sys-dot-green"></span>
                <div class="sys-item-text">
                    <span class="sys-label">Server</span>
                    <span class="sys-value">Online</span>
                </div>
            </div>
            <div class="sys-item">
                <span class="sys-dot sys-dot-green"></span>
                <div class="sys-item-text">
                    <span class="sys-label">Database</span>
                    <span class="sys-value">Terhubung</span>
                </div>
            </div>
            <div class="sys-item">
                <span class="sys-dot sys-dot-blue"></span>
                <div class="sys-item-text">
                    <span class="sys-label">Online</span>
                    <span class="sys-value">{{ $sidebarCounts['onlineUsers'] ?? 0 }}</span>
                </div>
            </div>
            <div class="sys-item">
                <span class="sys-dot sys-dot-orange"></span>
                <div class="sys-item-text">
                    <span class="sys-label">Versi</span>
                    <span class="sys-value">{{ $sidebarCounts['appVersion'] }}</span>
                </div>
            </div>
        </div>

        {{-- Health Bar --}}
        <div class="sys-health">
            <div class="sys-health-header">
                <span class="sys-health-label">System Health</span>
                <span class="sys-health-pct">96%</span>
            </div>
            <div class="sys-health-track">
                <div class="sys-health-fill" style="width: 96%"></div>
            </div>
        </div>
    </div>
</div>
