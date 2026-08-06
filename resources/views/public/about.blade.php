<x-layouts.public :active-route="$activeRoute" :title="$title" :description="$description" :canonical="$canonical">
    <section class="institutional-hero institutional-hero--about" aria-labelledby="about-title">
        <div class="institutional-hero__orb" aria-hidden="true"></div>
        <div class="container institutional-hero__inner" data-reveal>
            <p class="eyebrow">{{ $content['hero']['eyebrow'] }}</p>
            <h1 id="about-title">{{ $content['hero']['title'] }}</h1>
            <p>{{ $content['hero']['description'] }}</p>
            <a class="button button--gold" href="#historia">Conocer nuestra esencia</a>
        </div>
    </section>

    <section id="historia" class="about-story" aria-labelledby="story-title">
        <div class="container about-story__layout">
            <div class="about-story__visual" aria-hidden="true" data-reveal><span></span><i></i><b>Parfum</b></div>
            <div data-reveal data-reveal-delay="1"><p class="eyebrow">{{ $content['story']['eyebrow'] }}</p><h2 id="story-title">{{ $content['story']['title'] }}</h2><p>{{ $content['story']['body'] }}</p></div>
        </div>
    </section>

    <section id="filosofia" class="about-philosophy" aria-labelledby="philosophy-title">
        <div class="container about-philosophy__inner" data-reveal><p class="eyebrow">{{ $content['philosophy']['eyebrow'] }}</p><h2 id="philosophy-title">{{ $content['philosophy']['title'] }}</h2><p>{{ $content['philosophy']['body'] }}</p></div>
    </section>

    <section class="about-purpose" aria-label="Mision y vision">
        <div class="container about-purpose__grid">
            @foreach($content['purpose'] as $purpose)
                <article data-reveal><p class="eyebrow">{{ $purpose['label'] }}</p><h2>{{ $purpose['title'] }}</h2><p>{{ $purpose['body'] }}</p></article>
            @endforeach
        </div>
    </section>

    <section class="about-values" aria-labelledby="values-title">
        <div class="container"><div class="about-section-heading" data-reveal><p class="eyebrow">Lo que cuidamos</p><h2 id="values-title">Valores que se sienten en cada detalle.</h2></div>
            <div class="about-values__list">@foreach($content['values'] as $value)<article data-reveal><span>{{ $value['number'] }}</span><h3>{{ $value['title'] }}</h3><p>{{ $value['body'] }}</p></article>@endforeach</div>
        </div>
    </section>

    <section class="about-difference" aria-labelledby="difference-title">
        <div class="container"><div class="about-section-heading" data-reveal><p class="eyebrow">Una forma distinta de descubrir</p><h2 id="difference-title">La perfumeria se vuelve mas clara cuando se comparte.</h2></div>
            <div class="about-difference__grid">@foreach($content['differences'] as $difference)<article data-reveal><h3>{{ $difference['title'] }}</h3><p>{{ $difference['body'] }}</p></article>@endforeach</div>
        </div>
    </section>

    <section class="about-process" aria-labelledby="process-title">
        <div class="container"><div class="about-section-heading" data-reveal><p class="eyebrow">El recorrido</p><h2 id="process-title">Descubrir una fragancia puede comenzar con una pregunta.</h2></div>
            <ol class="about-process__list">@foreach($content['process'] as $process)<li data-reveal><span>{{ $process['step'] }}</span><h3>{{ $process['title'] }}</h3><p>{{ $process['body'] }}</p></li>@endforeach</ol>
        </div>
    </section>

    <section class="institutional-cta" aria-labelledby="about-cta-title">
        <div class="container" data-reveal><p class="eyebrow">Tu propio recorrido</p><h2 id="about-cta-title">Deja que tus preferencias revelen una afinidad.</h2><p>Mi Aroma Perfecto convierte lo que buscas en una seleccion de fragancias para explorar sin prisa.</p><a class="button button--gold" href="{{ route('perfect-aroma') }}">Descubrir Mi Aroma Perfecto</a></div>
    </section>
</x-layouts.public>
