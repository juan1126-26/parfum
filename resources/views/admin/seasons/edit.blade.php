<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="season-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="season-form-title">{{ $season->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$season->is_active" /><p>Actualiza la temporada recomendada para las fragancias de Parfum.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.seasons._form', ['action' => route('admin.seasons.update', $season), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="season-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="season-status-title">Estado de la temporada</h2></div>
        <x-admin.status-action :action="route('admin.seasons.toggle', $season)" :active="$season->is_active" :subject="$season->name" />
    </section>
</x-layouts.admin>
