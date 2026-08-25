<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="perfumes-title">
        <div>
            <p class="eyebrow">Catalogo</p>
            <h1 id="perfumes-title">Perfumes</h1>
        </div>
        <div class="admin-page-header__actions">
            <p>{{ $perfumes->total() }} registros en el catalogo.</p>
            <a class="admin-button admin-button--primary" href="{{ route('admin.perfumes.create') }}">Nuevo perfume</a>
        </div>
    </section>

    <x-admin.flash />

    <form class="admin-filter-bar" method="GET" action="{{ route('admin.perfumes.index') }}">
        <label class="sr-only" for="perfume-search">Buscar perfumes</label>
        <input id="perfume-search" name="q" type="search" value="{{ $filters['search'] }}" placeholder="Buscar por nombre, slug, marca o categoria">

        <label class="sr-only" for="perfume-status">Estado</label>
        <select id="perfume-status" name="status">
            <option value="">Todos los estados</option>
            <option value="active" @selected($filters['status'] === 'active')>Activos</option>
            <option value="inactive" @selected($filters['status'] === 'inactive')>Inactivos</option>
        </select>

        <label class="sr-only" for="perfume-sort">Ordenar por</label>
        <select id="perfume-sort" name="sort">
            <option value="sort_order" @selected($filters['sort'] === 'sort_order')>Orden de catalogo</option>
            <option value="name" @selected($filters['sort'] === 'name')>Nombre</option>
            <option value="brand" @selected($filters['sort'] === 'brand')>Marca</option>
            <option value="category" @selected($filters['sort'] === 'category')>Categoria</option>
            <option value="status" @selected($filters['sort'] === 'status')>Estado</option>
        </select>

        <label class="sr-only" for="perfume-direction">Direccion</label>
        <select id="perfume-direction" name="direction">
            <option value="asc" @selected($filters['direction'] === 'asc')>Ascendente</option>
            <option value="desc" @selected($filters['direction'] === 'desc')>Descendente</option>
        </select>

        <button class="admin-button admin-button--secondary" type="submit">Aplicar</button>
    </form>

    <section class="admin-list" aria-label="Listado de perfumes">
        <div class="admin-list__heading" aria-hidden="true">
            <span>Perfume</span><span>Marca y categoria</span><span>Estado</span><span>Acciones</span>
        </div>

        @forelse ($perfumes as $perfume)
            <article class="admin-list__item">
                <div>
                    <h2>{{ $perfume->name }}</h2>
                    <p>/{{ $perfume->slug }}</p>
                </div>
                <div class="admin-list__metadata">
                    <span>{{ $perfume->brand->name }}</span>
                    <span>{{ $perfume->category->name }}</span>
                </div>
                <div><x-admin.status-badge :active="$perfume->is_active" /></div>
                <div class="admin-list__actions">
                    <a class="admin-text-link" href="{{ route('admin.perfumes.edit', $perfume) }}">Editar</a>
                    <x-admin.status-action :action="route('admin.perfumes.toggle', $perfume)" :active="$perfume->is_active" :subject="$perfume->name" />
                </div>
            </article>
        @empty
            <div class="admin-list__empty">
                <p>No encontramos perfumes con estos criterios.</p>
                <a class="admin-text-link" href="{{ route('admin.perfumes.index') }}">Limpiar filtros</a>
            </div>
        @endforelse
    </section>

    <x-admin.pagination :paginator="$perfumes" />
</x-layouts.admin>
