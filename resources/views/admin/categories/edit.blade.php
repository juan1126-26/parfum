<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="category-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="category-form-title">{{ $category->name }}</h1></div>
        <div class="admin-page-header__actions"><x-admin.status-badge :active="$category->is_active" /><p>Actualiza esta agrupacion sin afectar sus perfumes.</p></div>
    </section>
    <x-admin.flash />
    @include('admin.categories._form', ['action' => route('admin.categories.update', $category), 'method' => 'PUT'])
    <section class="admin-form-section admin-form-section--status" aria-labelledby="category-status-title">
        <div><p class="eyebrow">Disponibilidad</p><h2 id="category-status-title">Estado de la categoria</h2></div>
        <x-admin.status-action :action="route('admin.categories.toggle', $category)" :active="$category->is_active" :subject="$category->name" />
    </section>
</x-layouts.admin>
