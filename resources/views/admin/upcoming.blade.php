<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-upcoming" aria-labelledby="upcoming-title">
        <p class="eyebrow">En preparacion</p>
        <h1 id="upcoming-title">{{ $module['label'] }}</h1>
        <p>Este modulo se integrara sobre la misma infraestructura administrativa en un Sprint posterior.</p>
        <a class="admin-button admin-button--secondary" href="{{ route('admin.dashboard') }}">Volver al dashboard</a>
    </section>
</x-layouts.admin>
