<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="climate-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="climate-form-title">Nuevo clima</h1></div>
        <p>Define un contexto climatico para orientar el descubrimiento de fragancias.</p>
    </section>
    <x-admin.flash />
    @include('admin.climates._form', ['action' => route('admin.climates.store'), 'method' => 'POST'])
</x-layouts.admin>
