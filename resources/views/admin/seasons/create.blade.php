<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="season-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="season-form-title">Nueva temporada</h1></div>
        <p>Incorpora una estacion para contextualizar cada composicion.</p>
    </section>
    <x-admin.flash />
    @include('admin.seasons._form', ['action' => route('admin.seasons.store'), 'method' => 'POST'])
</x-layouts.admin>
