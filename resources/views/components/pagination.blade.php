@props(['paginator' => null])
@if($paginator && $paginator->hasPages())
<div class="flex items-center justify-center gap-2 mt-10">
    @if($paginator->onFirstPage())
    <span class="px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider opacity-50"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</a>
    @endif
    @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if($page == $paginator->currentPage())
        <span class="w-10 h-10 bg-brutal-orange text-brutal-black border-2 border-brutal-black flex items-center justify-center text-sm font-black font-orbitron">{{ $page }}</span>
        @elseif($page <= 2 || $page >= $paginator->lastPage() - 1 || abs($page - $paginator->currentPage()) <= 1)
        <a href="{{ $url }}" class="w-10 h-10 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition flex items-center justify-center text-sm font-bold text-gray-400">{{ $page }}</a>
        @elseif($page == 3 && $paginator->currentPage() > 3)
        <span class="text-gray-600 font-bold">...</span>
        @elseif($page == $paginator->lastPage() - 2 && $paginator->currentPage() < $paginator->lastPage() - 2)
        <span class="text-gray-600 font-bold">...</span>
        @endif
    @endforeach
    @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange hover:text-brutal-orange transition text-sm font-bold uppercase tracking-wider">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></a>
    @else
    <span class="px-4 py-2 bg-dark-card border-2 border-dark-border text-gray-600 cursor-not-allowed text-sm font-bold uppercase tracking-wider opacity-50">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></span>
    @endif
</div>
@endif