<x-layouts.public :active-route="$activeRoute" :title="$title" :description="$description" :canonical="$canonical">
    <section class="compare-hero">
        <div class="container">
            <p class="eyebrow">Comparador Parfum</p>
            <h1>Dos aromas. Una mirada mas clara.</h1>
            <p>Contrasta composicion, presencia y momentos ideales desde los datos de cada fragancia.</p>
            <form class="compare-form" method="GET" action="{{ route('comparator') }}">
                <label>Primer perfume<select name="first"><option value="">Selecciona una fragancia</option>@foreach($options as $option)<option value="{{ $option->slug }}" @selected($first?->is($option))>{{ $option->name }} - {{ $option->brand->name }} - {{ $option->category->name }}</option>@endforeach</select></label>
                <label>Segundo perfume<select name="second"><option value="">Selecciona una fragancia</option>@foreach($options as $option)<option value="{{ $option->slug }}" @selected($second?->is($option))>{{ $option->name }} - {{ $option->brand->name }} - {{ $option->category->name }}</option>@endforeach</select></label>
                <button class="button button--gold" type="submit">Comparar</button>
            </form>
            @if($message)<p class="compare-message" role="status">{{ $message }}</p>@endif
        </div>
    </section>

    @if($first && $second)
        <section class="compare-results">
            <div class="container">
                <div class="compare-actions"><a href="{{ route('catalog') }}">Volver al catalogo</a><a href="{{ route('comparator', ['first' => $second->slug, 'second' => $first->slug]) }}">Intercambiar</a><a href="{{ route('comparator') }}">Limpiar</a></div>
                <div class="compare-pair" data-reveal>
                    @foreach([$first, $second] as $perfume)
                        <article><p>{{ $perfume->brand->name }} - {{ $perfume->category->name }}</p><h2>{{ $perfume->name }}</h2><span>{{ $perfume->short_description }}</span><a href="{{ route('catalog.show', $perfume) }}" target="_blank" rel="noopener noreferrer">Ver ficha<span class="sr-only"> de {{ $perfume->name }} (se abre en una nueva pestana)</span></a></article>
                    @endforeach
                </div>

                @foreach(['accords' => 'Acordes', 'notes' => 'Notas olfativas', 'climates' => 'Climas', 'seasons' => 'Temporadas', 'occasions' => 'Ocasiones'] as $key => $label)
                    <section class="compare-section">
                        <p class="eyebrow">{{ $label }}</p><h2>{{ $label }} en cada composicion.</h2>
                        <div @class(['compare-sets', 'compare-sets--with-shared' => $comparison['sets'][$key]['shared']->isNotEmpty()])>
                            <article><p>{{ $first->name }}</p><strong>{{ $first->$key->pluck('name')->join(' - ') ?: 'Aun no hay informacion registrada.' }}</strong></article>
                            <article><p>{{ $second->name }}</p><strong>{{ $second->$key->pluck('name')->join(' - ') ?: 'Aun no hay informacion registrada.' }}</strong></article>
                            @if($comparison['sets'][$key]['shared']->isNotEmpty())<article><p>Coinciden en</p><strong>{{ $comparison['sets'][$key]['shared']->pluck('name')->join(' - ') }}</strong></article>@endif
                        </div>
                        @if($comparison['sets'][$key]['first']->isNotEmpty() || $comparison['sets'][$key]['second']->isNotEmpty())
                            <div class="compare-differences">@if($comparison['sets'][$key]['first']->isNotEmpty())<p>Solo en {{ $first->name }}: {{ $comparison['sets'][$key]['first']->pluck('name')->join(' - ') }}</p>@endif @if($comparison['sets'][$key]['second']->isNotEmpty())<p>Solo en {{ $second->name }}: {{ $comparison['sets'][$key]['second']->pluck('name')->join(' - ') }}</p>@endif</div>
                        @elseif($first->$key->isNotEmpty() && $second->$key->isNotEmpty())
                            <p class="compare-differences">Comparten toda la informacion registrada en este aspecto.</p>
                        @else
                            <p class="compare-differences compare-differences--empty">No existen coincidencias registradas en este aspecto.</p>
                        @endif
                    </section>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.public>
