<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="perfume-form-title">
        <div>
            <p class="eyebrow">Catalogo</p>
            <h1 id="perfume-form-title">{{ $perfume->name }}</h1>
        </div>
        <div class="admin-page-header__actions">
            <x-admin.status-badge :active="$perfume->is_active" />
            <p>Actualiza sus detalles y afinidades sin alterar la estructura del catalogo.</p>
        </div>
    </section>

    <x-admin.flash />
    @include('admin.perfumes._form', ['action' => route('admin.perfumes.update', $perfume), 'method' => 'PUT'])
    @include('admin.perfumes._images')

    <section class="admin-form-section admin-form-section--status" aria-labelledby="perfume-status-title">
        <div>
            <p class="eyebrow">Disponibilidad</p>
            <h2 id="perfume-status-title">Estado del perfume</h2>
        </div>
        <x-admin.status-action :action="route('admin.perfumes.toggle', $perfume)" :active="$perfume->is_active" :subject="$perfume->name" />
    </section>
</x-layouts.admin>
