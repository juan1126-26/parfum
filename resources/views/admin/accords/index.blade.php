<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="accords-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="accords-title">Acordes</h1></div>
        <div class="admin-page-header__actions"><p>{{ $accords->total() }} perfiles olfativos registrados.</p><a class="admin-button admin-button--primary" href="{{ route('admin.accords.create') }}">Nuevo acorde</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.accords.index') }}">
        <label class="sr-only" for="accord-search">Buscar acordes</label>
        <input id="accord-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--accords" aria-label="Listado de acordes">
        <div class="admin-list__heading" aria-hidden="true"><span>Acorde</span><span>Color</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($accords as $accord)
            <article class="admin-list__item">
                <div><h2>{{ $accord->name }}</h2><p>/{{ $accord->slug }}</p></div>
                <div><span class="admin-color-swatch" style="--accord-color: {{ $accord->color ?: '#b28a43' }}" aria-label="Color {{ $accord->color ?: 'sin definir' }}"></span></div>
                <div class="admin-list__count">{{ $accord->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$accord->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.accords.edit', $accord) }}">Editar</a><x-admin.status-action :action="route('admin.accords.toggle', $accord)" :active="$accord->is_active" :subject="$accord->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos acordes con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.accords.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$accords" />
</x-layouts.admin>
