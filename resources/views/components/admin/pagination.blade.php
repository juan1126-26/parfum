@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="admin-pagination" aria-label="Paginacion de resultados">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
        @endif

        <span>Pagina {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
        @else
            <span aria-disabled="true">Siguiente</span>
        @endif
    </nav>
@endif
