<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="notes-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="notes-title">Notas Olfativas</h1></div>
        <div class="admin-page-header__actions"><p>{{ $notes->total() }} materias olfativas registradas.</p><a class="admin-button admin-button--primary" href="{{ route('admin.notes.create') }}">Nueva nota</a></div>
    </section>
    <x-admin.flash />
    <form class="admin-filter-bar admin-filter-bar--simple" method="GET" action="{{ route('admin.notes.index') }}">
        <label class="sr-only" for="note-search">Buscar notas</label>
        <input id="note-search" name="q" type="search" value="{{ $search }}" placeholder="Buscar por nombre o slug">
        <button class="admin-button admin-button--secondary" type="submit">Buscar</button>
    </form>
    <section class="admin-list admin-list--catalog admin-list--categories" aria-label="Listado de notas olfativas">
        <div class="admin-list__heading" aria-hidden="true"><span>Nota</span><span>Perfumes</span><span>Estado</span><span>Acciones</span></div>
        @forelse ($notes as $note)
            <article class="admin-list__item">
                <div><h2>{{ $note->name }}</h2><p>/{{ $note->slug }}</p></div>
                <div class="admin-list__count">{{ $note->perfumes_count }}</div>
                <div><x-admin.status-badge :active="$note->is_active" /></div>
                <div class="admin-list__actions"><a class="admin-text-link" href="{{ route('admin.notes.edit', $note) }}">Editar</a><x-admin.status-action :action="route('admin.notes.toggle', $note)" :active="$note->is_active" :subject="$note->name" /></div>
            </article>
        @empty
            <div class="admin-list__empty"><p>No encontramos notas con estos criterios.</p><a class="admin-text-link" href="{{ route('admin.notes.index') }}">Limpiar busqueda</a></div>
        @endforelse
    </section>
    <x-admin.pagination :paginator="$notes" />
</x-layouts.admin>
