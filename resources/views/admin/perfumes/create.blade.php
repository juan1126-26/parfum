<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="perfume-form-title">
        <div>
            <p class="eyebrow">Catalogo</p>
            <h1 id="perfume-form-title">Nuevo perfume</h1>
        </div>
        <p>Define los rasgos que construyen una fragancia y su experiencia publica.</p>
    </section>

    <x-admin.flash />
    @include('admin.perfumes._form', ['action' => route('admin.perfumes.store'), 'method' => 'POST'])
</x-layouts.admin>
