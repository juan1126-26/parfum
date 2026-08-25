<x-layouts.admin :title="$title" :breadcrumbs="$breadcrumbs">
    <section class="admin-page-header" aria-labelledby="dashboard-title">
        <div>
            <p class="eyebrow">Vista general</p>
            <h1 id="dashboard-title">El universo Parfum, en orden.</h1>
        </div>
        <p>Una lectura clara de los elementos que dan forma a la experiencia publica.</p>
    </section>

    <section class="admin-stat-grid" aria-label="Indicadores del catalogo y recomendaciones">
        @foreach ($metrics as $metric)
            <x-admin.stat-card :label="$metric['label']" :value="$metric['value']" :detail="$metric['detail']" />
        @endforeach
    </section>
</x-layouts.admin>
