<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="brand-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="brand-form-title">{{ $brand->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$brand->is_active" /><p>Actualiza la presencia editorial de esta casa.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.brands._form', ['action' => route('admin.brands.update', $brand), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="brand-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="brand-status-title">Estado de la marca</h2></div>
        <x-admin.status-action :action="route('admin.brands.toggle', $brand)" :active="$brand->is_active" :subject="$brand->name" />
    </section>
</x-layouts.admin>
