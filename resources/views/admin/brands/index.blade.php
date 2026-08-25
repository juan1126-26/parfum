<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="brands-title">
        <div>
            <p class="eyebrow">Catalogo</p>
            <h1 id="brands-title">Marcas</h1>
        </div>
        <div class="admin-page-header__actions">
            <p>{{ $brands->total() }} casas registradas.</p>
            <a class="admin-button admin-button--primary" href="{{ route('admin.brands.create') }}">Nueva marca</a>
        </div>
    </section>

    <x-admin.flash />

    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.brands.index') }}">
        <label class="sr-only" for="brand-search">Buscar marcas</label>
        <input id="brand-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre, slug o pais">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>

    <section class="admin-list admin-list--catalog admin-list--brands" aria-label="Listado de marcas">
        <div class="admin-list__heading" aria-hidden="true">
            <span>Marca</span><span>Origen</span><span>Perfumes</span><span>Estado</span><span>Acciones</span>
        </div>

        @forelse ($brands as $brand)
            <article class="admin-list__item">
                <div><h2>{{ $brand->name }}</h2><p>/{{ $brand->slug }}</p></div>
                <div class="admin-list__metadata"><span>{{ $brand->country ?: 'Sin pais definido' }}</span></div>
                <div class="admin-list__count">{{ $brand->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$brand->is_active" /></div>
                <div class="admin-list__actions">
                    <a class="admin-text-link" href="{{ route('admin.brands.edit', $brand) }}">Editar</a>
                    <x-admin.status-action :action="route('admin.brands.toggle', $brand)" :active="$brand->is_active" :subject="$brand->name" />
                </div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos marcas con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.brands.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>

    <x-admin.pagination :paginator="$brands" />
</x-layouts.admin>
