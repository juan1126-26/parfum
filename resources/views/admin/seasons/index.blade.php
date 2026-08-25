<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="seasons-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="seasons-title">Temporadas</h1></div>
        <div class="admin-page-header__actions"><p>{{ $seasons->total() }} temporadas registradas.</p><a class="admin-button admin-button--primary" href="{{ route('admin.seasons.create') }}">Nueva temporada</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.seasons.index') }}">
        <label class="sr-only" for="season-search">Buscar temporadas</label>
        <input id="season-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--categories" aria-label="Listado de temporadas">
        <div class="admin-list__heading" aria-hidden="true"><span>Temporada</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($seasons as $season)
            <article class="admin-list__item">
                <div><h2>{{ $season->name }}</h2><p>/{{ $season->slug }}</p></div>
                <div class="admin-list__count">{{ $season->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$season->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.seasons.edit', $season) }}">Editar</a><x-admin.status-action :action="route('admin.seasons.toggle', $season)" :active="$season->is_active" :subject="$season->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos temporadas con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.seasons.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$seasons" />
</x-layouts.admin>
