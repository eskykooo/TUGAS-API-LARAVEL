@props(['paginator' => null])
@if($paginator && $paginator->hasPages())
<div class="flex items-center justify-center gap-2 mt-10">
    @if($paginator->onFirstPage())
    <span class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed text-sm font-medium opacity-50"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-sky-500 hover:text-white transition text-sm font-medium"><i class="fas fa-chevron-left mr-1"></i> Sebelumnya</a>
    @endif
    @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if($page == $paginator->currentPage())
        <span class="w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center text-sm font-bold">{{ $page }}</span>
        @elseif($page <= 2 || $page >= $paginator->lastPage() - 1 || abs($page - $paginator->currentPage()) <= 1)
        <a href="{{ $url }}" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-sky-500 hover:text-white transition flex items-center justify-center text-sm font-medium">{{ $page }}</a>
        @elseif($page == 3 && $paginator->currentPage() > 3)
        <span class="text-slate-400">...</span>
        @elseif($page == $paginator->lastPage() - 2 && $paginator->currentPage() < $paginator->lastPage() - 2)
        <span class="text-slate-400">...</span>
        @endif
    @endforeach
    @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-sky-500 hover:text-white transition text-sm font-medium">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></a>
    @else
    <span class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed text-sm font-medium opacity-50">Selanjutnya <i class="fas fa-chevron-right ml-1"></i></span>
    @endif
</div>
@endif
