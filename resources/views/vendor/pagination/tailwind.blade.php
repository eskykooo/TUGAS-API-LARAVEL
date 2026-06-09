@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between gap-4">
    <div class="flex flex-1 sm:hidden justify-between gap-2">
        @if ($paginator->onFirstPage())
        <span class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider text-center opacity-50"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider text-center"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</a>
        @endif
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider text-center">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></a>
        @else
        <span class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider text-center opacity-50">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></span>
        @endif
    </div>

    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">
                Menampilkan
                @if ($paginator->firstItem())
                <span class="font-bold text-white">{{ $paginator->firstItem() }}</span>
                - <span class="font-bold text-white">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                dari <span class="font-bold text-white">{{ $paginator->total() }}</span>
            </p>
        </div>

        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
            <span class="w-10 h-10 bg-dark-card border-2 border-dark-border flex items-center justify-center text-gray-600 cursor-not-allowed opacity-50"><i class="fas fa-chevron-left text-xs"></i></span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-500"><i class="fas fa-chevron-left text-xs"></i></a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                <span class="w-10 h-10 bg-dark-card border-2 border-dark-border flex items-center justify-center text-gray-600 font-bold text-sm">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <span class="w-10 h-10 bg-brutal-orange text-brutal-black border-2 border-brutal-black flex items-center justify-center text-sm font-black font-orbitron">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="w-10 h-10 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-sm font-bold text-gray-500">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-gray-500"><i class="fas fa-chevron-right text-xs"></i></a>
            @else
            <span class="w-10 h-10 bg-dark-card border-2 border-dark-border flex items-center justify-center text-gray-600 cursor-not-allowed opacity-50"><i class="fas fa-chevron-right text-xs"></i></span>
            @endif
        </div>
    </div>
</nav>
@endif
