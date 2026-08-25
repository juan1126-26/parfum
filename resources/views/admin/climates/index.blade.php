<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="climates-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="climates-title">Climas</h1></div>
        <div class="admin-page-header__actions"><p>{{ $climates->total() }} climas registrados.</p><a class="admin-button admin-button--primary" href="{{ route('admin.climates.create') }}">Nuevo clima</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.climates.index') }}">
        <label class="sr-only" for="climate-search">Buscar climas</label>
        <input id="climate-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--categories" aria-label="Listado de climas">
        <div class="admin-list__heading" aria-hidden="true"><span>Clima</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($climates as $climate)
            <article class="admin-list__item">
                <div><h2>{{ $climate->name }}</h2><p>/{{ $climate->slug }}</p></div>
                <div class="admin-list__count">{{ $climate->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$climate->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.climates.edit', $climate) }}">Editar</a><x-admin.status-action :action="route('admin.climates.toggle', $climate)" :active="$climate->is_active" :subject="$climate->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos climas con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.climates.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$climates" />
</x-layouts.admin>
