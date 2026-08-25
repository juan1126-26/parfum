<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="categories-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="categories-title">Categorias</h1></div>
        <div class="admin-page-header__actions"><p>{{ $categories->total() }} colecciones registradas.</p><a class="admin-button admin-button--primary" href="{{ route('admin.categories.create') }}">Nueva categoria</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.categories.index') }}">
        <label class="sr-only" for="category-search">Buscar categorias</label>
        <input id="category-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--categories" aria-label="Listado de categorias">
        <div class="admin-list__heading" aria-hidden="true"><span>Categoria</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($categories as $category)
            <article class="admin-list__item">
                <div><h2>{{ $category->name }}</h2><p>/{{ $category->slug }}</p></div>
                <div class="admin-list__count">{{ $category->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$category->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.categories.edit', $category) }}">Editar</a><x-admin.status-action :action="route('admin.categories.toggle', $category)" :active="$category->is_active" :subject="$category->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos categorias con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.categories.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$categories" />
</x-layouts.admin>
