@if ($paginator->hasPages())
    <div class="mt-12 flex justify-center">
        <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex items-center gap-1 rounded-xl border border-gray-200 bg-white p-1.5 shadow-xs">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="cursor-not-allowed rounded-lg px-3 py-1.5 text-xs text-gray-300">Sebelumnya</span>
            @else
                <a rel="prev" href="{{ $paginator->previousPageUrl() }}" class="rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700 transition hover:bg-gray-100">Sebelumnya</a>
            @endif

            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span aria-current="page" class="rounded-lg bg-brand-700 px-3 py-1.5 text-xs font-bold text-white shadow-xs">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-100">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a rel="next" href="{{ $paginator->nextPageUrl() }}" class="rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700 transition hover:bg-gray-100">Berikutnya</a>
            @else
                <span aria-disabled="true" class="cursor-not-allowed rounded-lg px-3 py-1.5 text-xs text-gray-300">Berikutnya</span>
            @endif
        </nav>
    </div>
@endif
