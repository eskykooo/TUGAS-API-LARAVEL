@php
$catColors = [
    'pc-gaming' => 'border-brutal-orange text-brutal-orange',
    'console' => 'border-brutal-red text-brutal-red',
    'mobile' => 'border-brutal-yellow text-brutal-yellow',
    'esports' => 'border-brutal-green text-brutal-green',
    'gaming-news' => 'border-brutal-orange text-brutal-orange',
];
$slug = $article->category->slug ?? 'default';
$color = $catColors[$slug] ?? 'border-gray-500 text-gray-400';
@endphp

<article class="glass-card overflow-hidden flex flex-col group border-2 border-dark-border hover:border-brutal-orange">
    <div class="overflow-hidden h-48 relative flex-shrink-0">
        @if($article->thumbnail_url)
        <img src="{{ $article->thumbnail_url }}"
             alt="{{ $article->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
             loading="lazy">
        @else
        <div class="w-full h-full bg-dark-card flex items-center justify-center">
            <i class="fas fa-gamepad text-4xl text-gray-600"></i>
        </div>
        @endif
        <span class="absolute top-3 left-3 tag-brutal {{ $color }} border-2">
            {{ $article->category->name ?? 'Umum' }}
        </span>
    </div>
    <div class="p-5 flex flex-col flex-1">
        <h3 class="font-orbitron font-bold text-white mb-2 line-clamp-2 leading-snug group-hover:text-brutal-orange transition-colors text-base md:text-lg uppercase tracking-wide">
            <a href="/articles/{{ $article->slug }}">{{ $article->title }}</a>
        </h3>
        <p class="text-gray-400 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed font-bold uppercase tracking-wider">{{ $article->excerpt }}</p>
        <div class="flex items-center gap-2 pt-4 border-t-2 border-dark-border mt-auto">
            <img src="{{ $article->user->avatarUrl(32) }}"
                 alt="{{ $article->user->name ?? '' }}"
                 class="w-7 h-7 rounded border-2 border-brutal-orange flex-shrink-0">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider truncate min-w-0">{{ $article->user->name ?? '-' }}</span>
            <span class="text-xs text-gray-500 flex items-center gap-1 ml-auto flex-shrink-0 font-bold uppercase tracking-wider"><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views) }}</span>
        </div>
    </div>
</article>