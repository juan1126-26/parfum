<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="accord-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="accord-form-title">Nuevo acorde</h1></div>
        <p>Define un perfil que ayude a leer el caracter de cada fragancia.</p>
    </section>
    <x-admin.flash />
    @include('admin.accords._form', ['action' => route('admin.accords.store'), 'method' => 'POST'])
</x-layouts.admin>
