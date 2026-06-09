@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-3">
    @if ($paginator->onFirstPage())
    <span class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider text-center opacity-50"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider text-center"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</a>
    @endif
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider text-center">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></a>
    @else
    <span class="flex-1 px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider text-center opacity-50">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></span>
    @endif
</nav>
@endif
