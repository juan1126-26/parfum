<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="brand-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="brand-form-title">Nueva marca</h1></div>
        <p>Incorpora una nueva casa al universo Parfum.</p>
    </section>
    <x-admin.flash />
    @include('admin.brands._form', ['action' => route('admin.brands.store'), 'method' => 'POST'])
</x-layouts.admin>
