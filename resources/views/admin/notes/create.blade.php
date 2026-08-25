<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header admin-page-header--compact" aria-labelledby="note-form-title">
        <div><p class="eyebrow">Catalogo</p><h1 id="note-form-title">Nueva nota olfativa</h1></div>
        <p>Incorpora una materia para las piramides olfativas de las fragancias.</p>
    </section>
    <x-admin.flash />
    @include('admin.notes._form', ['action' => route('admin.notes.store'), 'method' => 'POST'])
</x-layouts.admin>
