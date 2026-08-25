<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="climate-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="climate-form-title">{{ $climate->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$climate->is_active" /><p>Actualiza este contexto para las recomendaciones y la ficha del perfume.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.climates._form', ['action' => route('admin.climates.update', $climate), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="climate-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="climate-status-title">Estado del clima</h2></div>
        <x-admin.status-action :action="route('admin.climates.toggle', $climate)" :active="$climate->is_active" :subject="$climate->name" />
    </section>
</x-layouts.admin>
