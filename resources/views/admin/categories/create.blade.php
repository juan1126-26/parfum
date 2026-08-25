<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="category-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="category-form-title">Nueva categoria</h1></div>
        <p>Define una nueva forma de recorrer el catalogo.</p>
    </section>
    <x-admin.flash />
    @include('admin.categories._form', ['action' => route('admin.categories.store'), 'method' => 'POST'])
</x-layouts.admin>
