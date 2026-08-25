<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="note-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="note-form-title">{{ $note->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$note->is_active" /><p>La etapa se define al asociar esta nota con cada perfume.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.notes._form', ['action' => route('admin.notes.update', $note), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="note-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="note-status-title">Estado de la nota</h2></div>
        <x-admin.status-action :action="route('admin.notes.toggle', $note)" :active="$note->is_active" :subject="$note->name" />
    </section>
</x-layouts.admin>
