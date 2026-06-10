@php
$growthColor = fn($v) => $v >= 0 ? 'text-brutal-green' : 'text-brutal-red';
$growthIcon = fn($v) => $v >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
$statCards = [
    ['label' => 'Total Artikel', 'value' => $totalArticles, 'icon' => 'fa-newspaper', 'color' => 'orange', 'growth' => $articleGrowth],
    ['label' => 'Diterbitkan', 'value' => $publishedCount, 'icon' => 'fa-check-circle', 'color' => 'green', 'growth' => null],
    ['label' => 'Draf', 'value' => $draftCount, 'icon' => 'fa-pen-fancy', 'color' => 'yellow', 'growth' => null],
    ['label' => 'Total Pengguna', 'value' => $totalUsers, 'icon' => 'fa-users', 'color' => 'purple', 'growth' => $userGrowth],
];
$chartDataJson = json_encode($chartData);
@endphp

@extends('layouts.app')
@section('title', 'Admin Dashboard - Nexus Gaming')
@section('meta_description', 'Panel kontrol administrasi Nexus Gaming.')

@push('styles')
<style>
.stat-card {
    background: linear-gradient(135deg, #0F0F0F 0%, #141414 100%);
    border: 1px solid rgba(255,107,53,0.12);
    border-radius: 0.75rem;
    padding: 1.25rem;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(600px circle at var(--mx, 50%) var(--my, 50%), rgba(255,107,53,0.06), transparent 60%);
    opacity: 0; transition: opacity 0.4s ease;
    pointer-events: none;
}
.stat-card:hover::before { opacity: 1; }
.stat-card:hover {
    border-color: rgba(255,107,53,0.35);
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(255,107,53,0.08);
}
.stat-card .stat-icon {
    width: 2.5rem; height: 2.5rem; border-radius: 0.5rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
.widget-card {
    background: #0F0F0F;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 0.75rem;
    transition: border-color 0.2s ease;
}
.widget-card:hover { border-color: rgba(255,107,53,0.2); }
.widget-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.widget-body { padding: 0.75rem; }
.activity-item {
    display: flex; align-items: flex-start; gap: 0.75rem;
    padding: 0.625rem 0.5rem;
    border-radius: 0.5rem;
    transition: background 0.15s ease;
}
.activity-item:hover { background: rgba(255,255,255,0.02); }
.activity-dot {
    width: 8px; height: 8px; border-radius: 50%;
    flex-shrink: 0; margin-top: 6px;
}
.quick-comment-item {
    padding: 0.75rem; border-radius: 0.5rem;
    border: 1px solid rgba(255,255,255,0.04);
    transition: all 0.2s ease;
}
.quick-comment-item:hover {
    border-color: rgba(255,107,53,0.15);
    background: rgba(255,107,53,0.03);
}
.chart-container {
    padding: 1rem 1.25rem 1.25rem;
}
.neon-glow-orange { box-shadow: 0 0 20px rgba(255,107,53,0.06); }
.neon-glow-orange:hover { box-shadow: 0 0 30px rgba(255,107,53,0.12); }
</style>
@endpush

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar', ['current' => 'dashboard'])

    <main class="admin-main">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-orbitron text-xl font-black text-white uppercase tracking-wider flex items-center gap-3">
                    <i class="fas fa-th-large text-brutal-orange"></i>
                    Control Center
                </h1>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">
                    <i class="far fa-calendar-alt mr-1.5"></i>{{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/" class="px-3 py-2 bg-[#0F0F0F] border border-[#ffffff0a] rounded-lg text-gray-500 hover:text-white hover:border-brutal-orange/30 transition text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fas fa-external-link-alt text-[10px]"></i> Website
                </a>
                <a href="/admin/articles" class="px-3 py-2 bg-brutal-orange/10 border border-brutal-orange/20 rounded-lg text-brutal-orange hover:bg-brutal-orange/20 transition text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fas fa-plus text-[10px]"></i> Kelola
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 mb-6">
            @foreach($statCards as $card)
            <div class="stat-card" x-data x-on:mousemove="
                $el.style.setProperty('--mx', ($event.clientX - $el.getBoundingClientRect().left) / $el.offsetWidth * 100 + '%');
                $el.style.setProperty('--my', ($event.clientY - $el.getBoundingClientRect().top) / $el.offsetHeight * 100 + '%');
            ">
                <div class="flex items-center justify-between mb-3">
                    <div class="stat-icon"
                        @style([
                            'background: rgba(255,107,53,0.12); color: #FF6B35;' => $card['color'] === 'orange',
                            'background: rgba(0,230,118,0.12); color: #00E676;' => $card['color'] === 'green',
                            'background: rgba(255,214,0,0.12); color: #FFD600;' => $card['color'] === 'yellow',
                            'background: rgba(168,85,247,0.12); color: #A855F7;' => $card['color'] === 'purple',
                            'background: rgba(59,130,246,0.12); color: #3B82F6;' => $card['color'] === 'blue',
                            'background: rgba(255,23,68,0.12); color: #FF1744;' => $card['color'] === 'red',
                        ])
                    ><i class="fas {{ $card['icon'] }}"></i></div>
                    @if($card['growth'] !== null)
                    <span class="text-[11px] font-bold flex items-center gap-0.5 {{ $growthColor($card['growth']) }}">
                        <i class="fas {{ $growthIcon($card['growth']) }} text-[9px]"></i>
                        {{ abs($card['growth']) }}%
                    </span>
                    @endif
                </div>
                <p class="font-orbitron text-xl font-black text-white">{{ number_format($card['value'], 0, ',', '.') }}</p>
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">{{ $card['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Chart --}}
        <div class="widget-card mb-6" x-data="chart(@js($chartData))">
            <div class="widget-header">
                <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-chart-line text-brutal-orange text-xs"></i>
                    Aktivitas 30 Hari Terakhir
                </h3>
                <div class="flex items-center gap-3 text-xs">
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="chartMetric" value="articles" x-model="metric" class="accent-brutal-orange">
                        <span class="text-gray-400 font-bold uppercase tracking-wider text-[10px]">Artikel</span>
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="chartMetric" value="users" x-model="metric" class="accent-brutal-orange">
                        <span class="text-gray-400 font-bold uppercase tracking-wider text-[10px]">Pengguna</span>
                    </label>
                </div>
            </div>
            <div class="chart-container">
                <canvas x-ref="canvas" class="w-full" style="height: 220px"></canvas>
            </div>
        </div>

        {{-- Two-column widgets --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            {{-- Recent Articles --}}
            <div class="widget-card">
                <div class="widget-header">
                    <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-newspaper text-brutal-orange text-xs"></i>
                        Artikel Terbaru
                    </h3>
                    <a href="/admin/articles" class="text-[11px] text-brutal-orange hover:text-white font-bold uppercase tracking-wider transition">Lihat Semua</a>
                </div>
                <div class="widget-body">
                    @forelse($recentArticles as $article)
                    <div class="activity-item">
                        <div class="w-8 h-8 rounded-lg bg-[#0a0a0a] border border-[#ffffff08] flex items-center justify-center flex-shrink-0 text-xs text-gray-500">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-white truncate">{{ $article->title }}</p>
                                @if($article->status === 'published')
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-brutal-green/10 text-brutal-green font-bold uppercase tracking-wider flex-shrink-0">Terbit</span>
                                @elseif($article->status === 'pending')
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-brutal-yellow/10 text-brutal-yellow font-bold uppercase tracking-wider flex-shrink-0">Pending</span>
                                @else
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-500/10 text-gray-500 font-bold uppercase tracking-wider flex-shrink-0">Draf</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-gray-500 font-bold mt-0.5">
                                {{ $article->user->name ?? '—' }} · {{ $article->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada artikel</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Bottom two-column --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
            {{-- New Users --}}
            <div class="widget-card">
                <div class="widget-header">
                    <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-user-plus text-brutal-purple text-xs"></i>
                        Pengguna Baru
                    </h3>
                    <a href="/admin/users" class="text-[11px] text-brutal-orange hover:text-white font-bold uppercase tracking-wider transition">Lihat Semua</a>
                </div>
                <div class="widget-body">
                    @forelse($newUsers as $user)
                    <div class="activity-item">
                        <img src="{{ $user->avatarUrl(32) }}" alt="" class="w-8 h-8 rounded-lg border border-[#ffffff0a] flex-shrink-0" loading="lazy">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white">{{ $user->name }}</p>
                            <p class="text-[11px] text-gray-500 font-bold">{{ $user->email }}</p>
                        </div>
                        <span class="text-[10px] text-gray-600 font-bold uppercase tracking-wider flex-shrink-0">
                            @if($user->role === 'admin')
                            <span class="text-brutal-yellow">Admin</span>
                            @else
                            {{ $user->created_at->diffForHumans() }}
                            @endif
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada pengguna baru</div>
                    @endforelse
                </div>
            </div>

            {{-- Activity Log --}}
            <div class="widget-card">
                <div class="widget-header">
                    <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-history text-brutal-blue text-xs"></i>
                        Aktivitas Terkini
                    </h3>
                </div>
                <div class="widget-body max-h-[320px] overflow-y-auto">
                    @forelse($activities as $act)
                    <div class="activity-item">
                        <div class="activity-dot"
                            @style([
                                'background: #FF6B35;' => $act['color'] === 'orange',
                                'background: #00E676;' => $act['color'] === 'green',
                                'background: #3B82F6;' => $act['color'] === 'blue',
                                'background: #A855F7;' => $act['color'] === 'purple',
                                'background: #FFD600;' => $act['color'] === 'yellow',
                            ])
                        ></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-300">
                                <span class="font-bold text-white">{{ $act['user']->name ?? 'Sistem' }}</span>
                                {{ $act['description'] }}
                            </p>
                            <p class="text-[10px] text-gray-600 font-bold mt-0.5">{{ $act['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 text-xs font-bold uppercase tracking-wider">Belum ada aktivitas</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- System Notifications --}}
        <div class="widget-card">
            <div class="widget-header">
                <h3 class="font-orbitron text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-bell text-brutal-orange text-xs"></i>
                    Notifikasi Sistem
                </h3>
            </div>
            <div class="widget-body">
                @php
                $notifications = collect();
                $draftArticles = \App\Models\Article::where('status', 'draft')->count();
                if ($draftArticles > 0) {
                    $notifications->push([
                        'icon' => 'fa-pen-fancy',
                        'color' => 'text-brutal-blue',
                        'bg' => 'bg-brutal-blue/8',
                        'border' => 'border-brutal-blue/15',
                        'title' => "{$draftArticles} artikel masih berupa draf",
                        'desc' => 'Beberapa artikel belum selesai ditulis',
                        'action' => '/admin/articles',
                        'action_text' => 'Lihat',
                    ]);
                }

                $pendingArticles = \App\Models\Article::where('status', 'pending')->count();
                if ($pendingArticles > 0) {
                    $notifications->push([
                        'icon' => 'fa-clock',
                        'color' => 'text-brutal-orange',
                        'bg' => 'bg-brutal-orange/8',
                        'border' => 'border-brutal-orange/15',
                        'title' => "{$pendingArticles} artikel menunggu persetujuan",
                        'desc' => 'Penulis telah mengirim artikel untuk ditinjau',
                        'action' => '/admin/articles',
                        'action_text' => 'Tinjau',
                    ]);
                }

                if ($notifications->isEmpty()) {
                    $notifications->push([
                        'icon' => 'fa-check-circle',
                        'color' => 'text-brutal-green',
                        'bg' => 'bg-brutal-green/8',
                        'border' => 'border-brutal-green/15',
                        'title' => 'Semua sistem dalam kondisi baik',
                        'desc' => 'Tidak ada notifikasi yang perlu ditindaklanjuti',
                        'action' => null,
                        'action_text' => null,
                    ]);
                }
                @endphp

                <div class="space-y-2">
                    @foreach($notifications as $note)
                    <div class="flex items-start gap-3 p-3 rounded-lg {{ $note['bg'] }} border {{ $note['border'] }}">
                        <div class="w-8 h-8 rounded-lg bg-dark-bg border border-[#ffffff08] flex items-center justify-center flex-shrink-0 {{ $note['color'] }}">
                            <i class="fas {{ $note['icon'] }} text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white">{{ $note['title'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $note['desc'] }}</p>
                        </div>
                        @if($note['action'])
                        <a href="{{ $note['action'] }}" class="px-3 py-1.5 rounded bg-brutal-orange/10 border border-brutal-orange/20 text-brutal-orange hover:bg-brutal-orange/20 transition text-xs font-bold uppercase tracking-wider flex-shrink-0">
                            {{ $note['action_text'] }}
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
function chart(chartData) {
    return {
        metric: 'articles',
        chartData,
        init() {
            this.draw();
            this.$watch('metric', () => this.draw());
        },
        draw() {
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width * dpr;
            canvas.height = rect.height * dpr;
            ctx.scale(dpr, dpr);

            const W = rect.width;
            const H = rect.height;
            const pad = { top: 20, right: 16, bottom: 24, left: 36 };
            const cw = W - pad.left - pad.right;
            const ch = H - pad.top - pad.bottom;

            const values = this.chartData.map(d => d[this.metric]);
            const maxVal = Math.max(...values, 1);

            ctx.clearRect(0, 0, W, H);

            // Grid lines
            ctx.strokeStyle = 'rgba(255,255,255,0.04)';
            ctx.lineWidth = 1;
            for (let i = 0; i <= 4; i++) {
                const y = pad.top + (ch / 4) * i;
                ctx.beginPath();
                ctx.moveTo(pad.left, y);
                ctx.lineTo(W - pad.right, y);
                ctx.stroke();

                ctx.fillStyle = 'rgba(255,255,255,0.25)';
                ctx.font = '9px Inter, sans-serif';
                ctx.textAlign = 'right';
                ctx.fillText(Math.round(maxVal - (maxVal / 4) * i), pad.left - 6, y + 3);
            }

            // X labels (show every 5th)
            ctx.fillStyle = 'rgba(255,255,255,0.25)';
            ctx.font = '8px Inter, sans-serif';
            ctx.textAlign = 'center';

            // Gradient fill
            const gradient = ctx.createLinearGradient(0, pad.top, 0, H - pad.bottom);
            gradient.addColorStop(0, 'rgba(255,107,53,0.25)');
            gradient.addColorStop(1, 'rgba(255,107,53,0.01)');

            // Draw line + fill
            const points = values.map((v, i) => ({
                x: pad.left + (cw / (values.length - 1 || 1)) * i,
                y: pad.top + ch - (v / maxVal) * ch,
            }));

            // Fill
            ctx.beginPath();
            ctx.moveTo(points[0].x, pad.top + ch);
            points.forEach(p => ctx.lineTo(p.x, p.y));
            ctx.lineTo(points[points.length - 1].x, pad.top + ch);
            ctx.closePath();
            ctx.fillStyle = gradient;
            ctx.fill();

            // Line
            ctx.beginPath();
            points.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
            ctx.strokeStyle = '#FF6B35';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Glow line (behind)
            ctx.beginPath();
            points.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
            ctx.strokeStyle = 'rgba(255,107,53,0.3)';
            ctx.lineWidth = 6;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.stroke();

            // Re-draw main line on top
            ctx.beginPath();
            points.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
            ctx.strokeStyle = '#FF6B35';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Dots
            points.forEach((p, i) => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, 3, 0, Math.PI * 2);
                ctx.fillStyle = '#FF6B35';
                ctx.fill();
                ctx.strokeStyle = '#0F0F0F';
                ctx.lineWidth = 2;
                ctx.stroke();
            });

            // X labels
            this.chartData.forEach((d, i) => {
                if (i % 5 === 0 || i === this.chartData.length - 1) {
                    const x = pad.left + (cw / (this.chartData.length - 1 || 1)) * i;
                    ctx.fillStyle = 'rgba(255,255,255,0.2)';
                    ctx.font = '8px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(d.label, x, H - 4);
                }
            });
        }
    };
}
</script>
@endpush
