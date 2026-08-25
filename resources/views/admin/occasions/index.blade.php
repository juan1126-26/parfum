<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="occasions-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="occasions-title">Ocasiones</h1></div>
        <div class="admin-page-header__actions"><p>{{ $occasions->total() }} ocasiones registradas.</p><a class="admin-button admin-button--primary" href="{{ route('admin.occasions.create') }}">Nueva ocasion</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.occasions.index') }}">
        <label class="sr-only" for="occasion-search">Buscar ocasiones</label>
        <input id="occasion-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--categories" aria-label="Listado de ocasiones">
        <div class="admin-list__heading" aria-hidden="true"><span>Ocasion</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($occasions as $occasion)
            <article class="admin-list__item">
                <div><h2>{{ $occasion->name }}</h2><p>/{{ $occasion->slug }}</p></div>
                <div class="admin-list__count">{{ $occasion->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$occasion->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.occasions.edit', $occasion) }}">Editar</a><x-admin.status-action :action="route('admin.occasions.toggle', $occasion)" :active="$occasion->is_active" :subject="$occasion->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos ocasiones con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.occasions.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$occasions" />
</x-layouts.admin>
