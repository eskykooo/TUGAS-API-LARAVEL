@php
$catColors = [
    'pc-gaming' => 'border-brutal-orange text-brutal-orange',
    'console' => 'border-brutal-red text-brutal-red',
    'mobile' => 'border-brutal-yellow text-brutal-yellow',
    'esports' => 'border-brutal-green text-brutal-green',
    'gaming-news' => 'border-brutal-orange text-brutal-orange',
    'reviews' => 'border-brutal-blue text-brutal-blue',
    'guides' => 'border-brutal-purple text-brutal-purple',
];
$bgColors = [
    'pc-gaming' => 'rgba(255,107,53,0.06)',
    'console' => 'rgba(255,23,68,0.06)',
    'mobile' => 'rgba(255,214,0,0.06)',
    'esports' => 'rgba(0,230,118,0.06)',
    'gaming-news' => 'rgba(255,107,53,0.06)',
    'reviews' => 'rgba(59,130,246,0.06)',
    'guides' => 'rgba(168,85,247,0.06)',
];
$slug = $article->category->slug ?? 'default';
$color = $catColors[$slug] ?? 'border-gray-500 text-gray-400';
$bg = $bgColors[$slug] ?? 'rgba(255,255,255,0.02)';
@endphp

<article class="related-card flex flex-col group">
    <div class="relative w-full aspect-video sm:aspect-[16/9] flex-shrink-0 overflow-hidden">
        @if($article->thumbnail_url)
        <img src="{{ $article->thumbnail_url }}"
             alt="{{ $article->title }}"
             class="related-thumb absolute inset-0 w-full h-full object-cover"
             loading="lazy">
        @else
        <div class="absolute inset-0 bg-gradient-to-br from-dark-card to-dark-bg flex items-center justify-center">
            <i class="fas fa-gamepad text-4xl text-gray-700"></i>
        </div>
        @endif
        <div class="related-overlay"></div>
        <div class="related-cat">
            <span class="tag-brutal text-[9px] {{ $color }}">{{ $article->category->name ?? 'Umum' }}</span>
        </div>
    </div>
    <div class="p-5 flex flex-col flex-1 relative">
        <h3 class="font-orbitron font-bold text-white mb-2 line-clamp-2 leading-snug group-hover:text-brutal-orange transition-colors text-base md:text-lg uppercase tracking-wide">
            <a href="/articles/{{ $article->slug }}">{{ $article->title }}</a>
        </h3>
        <p class="text-gray-400 text-xs line-clamp-2 mb-4 flex-1 leading-relaxed font-bold uppercase tracking-wider">{{ $article->excerpt ?? strip_tags(Str::limit($article->content, 120)) }}</p>
        <div class="flex items-center gap-2 pt-3 border-t border-white/5 mt-auto">
            <img src="{{ $article->user->avatarUrl(28) }}"
                 alt="{{ $article->user->name ?? '' }}"
                 class="w-6 h-6 rounded border border-brutal-orange/30 flex-shrink-0">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider truncate min-w-0">{{ $article->user->name ?? '-' }}</span>
            <span class="text-[10px] text-gray-600 flex items-center gap-1 ml-auto flex-shrink-0 font-bold uppercase tracking-wider"><i class="far fa-eye mr-0.5"></i>{{ number_format($article->views) }}</span>
        </div>
        <div class="mt-3">
            <span class="read-more">Baca Artikel <i class="fas fa-arrow-right"></i></span>
        </div>
    </div>
</article>