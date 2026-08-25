<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="occasion-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="occasion-form-title">{{ $occasion->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$occasion->is_active" /><p>Actualiza el momento de uso asociado a las fragancias de Parfum.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.occasions._form', ['action' => route('admin.occasions.update', $occasion), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="occasion-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="occasion-status-title">Estado de la ocasion</h2></div>
        <x-admin.status-action :action="route('admin.occasions.toggle', $occasion)" :active="$occasion->is_active" :subject="$occasion->name" />
    </section>
</x-layouts.admin>
