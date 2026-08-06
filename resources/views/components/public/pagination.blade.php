@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="catalog-pagination" aria-label="Paginación del catálogo">
        @if ($paginator->onFirstPage())
            <span class="catalog-pagination__control is-disabled" aria-disabled="true">Anterior</span>
        @else
            <a class="catalog-pagination__control" href="{{ $paginator->previousPageUrl() }}#catalog-results" rel="prev">Anterior</a>
        @endif

        <div class="catalog-pagination__pages">
            @foreach ($paginator->onEachSide(1)->linkCollection()->slice(1, -1) as $link)
                @if ($link['url'] === null)
                    <span class="catalog-pagination__ellipsis" aria-hidden="true">{{ $link['label'] }}</span>
                @elseif ($link['active'])
                    <span class="is-current" aria-current="page">{{ $link['label'] }}</span>
                @else
                    <a href="{{ $link['url'] }}#catalog-results">{{ $link['label'] }}</a>
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="catalog-pagination__control" href="{{ $paginator->nextPageUrl() }}#catalog-results" rel="next">Siguiente</a>
        @else
            <span class="catalog-pagination__control is-disabled" aria-disabled="true">Siguiente</span>
        @endif
    </nav>
@endif
