@php
$catColors = [
    'teknologi' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
    'politik'   => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
    'olahraga'  => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
    'hiburan'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300',
    'bisnis'    => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
];
$slug = $article->category->slug ?? 'default';
$color = $catColors[$slug] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
@endphp

<article class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group flex flex-col border border-slate-100 dark:border-slate-700">
    <div class="overflow-hidden h-48 relative flex-shrink-0">
        @if($article->thumbnail_url)
        <img src="{{ $article->thumbnail_url }}"
             alt="{{ $article->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
             loading="lazy">
        @else
        <div class="w-full h-full bg-gradient-to-br from-sky-500/30 to-indigo-600/30 flex items-center justify-center">
            <i class="fas fa-newspaper text-4xl text-slate-300 dark:text-slate-600"></i>
        </div>
        @endif
        <span class="absolute top-3 left-3 px-2.5 py-1 {{ $color }} text-xs font-semibold rounded-lg backdrop-blur-sm">
            {{ $article->category->name ?? 'Umum' }}
        </span>
    </div>
    <div class="p-5 flex flex-col flex-1">
        <h3 class="font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 leading-snug group-hover:text-sky-500 transition-colors text-base md:text-lg">
            <a href="/articles/{{ $article->slug }}">{{ $article->title }}</a>
        </h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-4 flex-1 leading-relaxed">{{ $article->excerpt }}</p>
        <div class="flex items-center gap-2 pt-4 border-t border-slate-100 dark:border-slate-700 mt-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'A') }}&background=0ea5e9&color=fff&size=32"
                 alt="{{ $article->user->name ?? '' }}"
                 class="w-7 h-7 rounded-full flex-shrink-0">
            <span class="text-xs text-slate-500 truncate min-w-0">{{ $article->user->name ?? '-' }}</span>
            <span class="text-xs text-slate-400 flex items-center gap-1 ml-auto flex-shrink-0"><i class="fas fa-eye mr-0.5"></i>{{ number_format($article->views) }}</span>
        </div>
    </div>
</article>