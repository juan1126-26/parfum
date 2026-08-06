@props(['stages'])

@if ($stages->flatten()->isNotEmpty())
    <section class="olfactory-pyramid" aria-labelledby="olfactory-pyramid-title" data-reveal>
        <div class="container">
            <p class="eyebrow">La composición</p>
            <h2 id="olfactory-pyramid-title">Una pirámide que evoluciona con el tiempo.</h2>
            <div class="olfactory-pyramid__layers">
                @foreach (['top' => ['Salida', 'La primera impresión.'], 'heart' => ['Corazón', 'La identidad central.'], 'base' => ['Fondo', 'La estela que permanece.']] as $stage => [$label, $description])
                    @if ($stages->get($stage)?->isNotEmpty())
                        <article class="olfactory-pyramid__layer olfactory-pyramid__layer--{{ $stage }}">
                            <div><p>{{ $label }}</p><span>{{ $description }}</span></div>
                            <ul>@foreach ($stages->get($stage) as $note)<li>{{ $note->name }}</li>@endforeach</ul>
                        </article>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif
