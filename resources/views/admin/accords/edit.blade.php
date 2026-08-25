<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="accord-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="accord-form-title">{{ $accord->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$accord->is_active" /><p>Actualiza el perfil olfativo sin alterar sus asociaciones.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.accords._form', ['action' => route('admin.accords.update', $accord), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="accord-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="accord-status-title">Estado del acorde</h2></div>
        <x-admin.status-action :action="route('admin.accords.toggle', $accord)" :active="$accord->is_active" :subject="$accord->name" />
    </section>
</x-layouts.admin>
