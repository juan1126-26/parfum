<x-layouts.public
    title="Catálogo"
    description="Explora el catálogo de Parfum y descubre fragancias, acordes y composiciones para conocer con calma."
    :canonical="route('catalog')"
    active-route="catalog"
>
    <section class="catalog-hero" aria-labelledby="catalog-title">
        <div class="catalog-hero__inner container" data-reveal>
            <p class="eyebrow">Explorar con intención</p>
            <h1 id="catalog-title">Un universo de aromas para descubrir sin prisa.</h1>
            <p>Recorre composiciones seleccionadas por su carácter, sus matices y la historia que sugieren.</p>
            <div class="catalog-hero__object" aria-hidden="true"><span></span></div>
        </div>
    </section>

    <section class="catalog-explorer" aria-labelledby="catalog-explorer-title">
        <div class="container">
            <h2 id="catalog-explorer-title" class="sr-only">Buscar y filtrar perfumes</h2>

            <form class="catalog-form" action="{{ route('catalog') }}#catalog-results" method="GET">
                <div class="catalog-form__search">
                    <label for="catalog-search">Busca un aroma, una casa o una categoría</label>
                    <div class="catalog-search-field">
                        <svg aria-hidden="true" viewBox="0 0 24 24" focusable="false"><circle cx="11" cy="11" r="5.5" /><path d="m16 16 4 4" /></svg>
                        <input id="catalog-search" name="q" type="search" value="{{ $search }}" placeholder="Ej. ámbar, maderas, Estudio Parfum">
                    </div>
                </div>

                <div class="catalog-form__filters">
                    <div>
                        <label for="catalog-category">Categoría</label>
                        <select id="catalog-category" name="category">
                            <option value="">Todas las categorías</option>
                            @foreach ($categories as $filterCategory)
                                <option value="{{ $filterCategory->slug }}" @selected($category === $filterCategory->slug)>{{ $filterCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="catalog-brand">Marca</label>
                        <select id="catalog-brand" name="brand">
                            <option value="">Todas las marcas</option>
                            @foreach ($brands as $filterBrand)
                                <option value="{{ $filterBrand->slug }}" @selected($brand === $filterBrand->slug)>{{ $filterBrand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="button button--gold" type="submit">Explorar</button>
                </div>
            </form>

            <div id="catalog-results" class="catalog-results" aria-live="polite" tabindex="-1">
                <p>
                    @if ($perfumes->total() === 1)
                        1 perfume para descubrir.
                    @else
                        {{ $perfumes->total() }} perfumes para descubrir.
                    @endif
                </p>
                @if ($hasCriteria)
                    <a href="{{ route('catalog') }}">Limpiar exploración <span aria-hidden="true">→</span></a>
                @endif
            </div>

            @if ($perfumes->isNotEmpty())
                <div class="catalog-grid">
                    @foreach ($perfumes as $perfume)
                        <x-public.catalog-perfume :perfume="$perfume" />
                    @endforeach
                </div>

                <x-public.pagination :paginator="$perfumes" />
            @else
                <div class="catalog-empty" data-reveal>
                    <p class="eyebrow">La búsqueda continúa</p>
                    <h2>No encontramos un aroma con estos criterios.</h2>
                    <p>Prueba una combinación más amplia o vuelve a recorrer la selección completa.</p>
                    <a class="button button--outline" href="{{ route('catalog') }}">Ver todos los perfumes</a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
