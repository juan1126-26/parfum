<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="occasion-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="occasion-form-title">Nueva ocasion</h1></div>
        <p>Define un momento de uso para mejorar el contexto de cada fragancia.</p>
    </section>
    <x-admin.flash />
    @include('admin.occasions._form', ['action' => route('admin.occasions.store'), 'method' => 'POST'])
</x-layouts.admin>
