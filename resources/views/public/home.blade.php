<x-layouts.public title="Inicio" active-route="home">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero__layout container">
            <div class="hero__content" data-reveal>
                <p class="eyebrow">Una experiencia de perfumería</p>
                <h1 id="hero-title">{{ config('parfum.brand.name') }}</h1>
                <p class="hero__tagline">{{ config('parfum.brand.tagline') }}</p>
                <p class="hero__description">Descubre perfumes como una extensión de tu personalidad: con calma, curiosidad y atención a cada matiz.</p>
                <a class="button button--gold" href="{{ route('catalog') }}">Explorar la colección</a>
            </div>

            <div data-reveal data-reveal-delay="1">
                <x-public.hero-media />
            </div>
        </div>
        <a class="hero__scroll" href="#our-story">
            <span>Descubrir</span>
            <span class="hero__scroll-mark" aria-hidden="true"></span>
        </a>
    </section>

    <section id="our-story" class="story" aria-labelledby="story-title">
        <div class="story__layout container">
            <div class="story__visual" aria-hidden="true" data-reveal>
                <div class="story__frame"></div>
                <div class="story__disc"></div>
                <div class="story__line"></div>
            </div>

            <div class="story__content" data-reveal data-reveal-delay="1">
                <p class="eyebrow">Nuestra historia</p>
                <h2 id="story-title">Un aroma puede decir algo antes que las palabras.</h2>
                <p class="story__lead">Parfum nace de la pasión por las experiencias que un perfume es capaz de crear.</p>
                <p class="story__body">Creemos que elegir una fragancia debe sentirse como un descubrimiento: una forma de encontrar aquello que mejor representa quién eres.</p>
                <a class="story__link" href="{{ route('about') }}">Conocer nuestra esencia <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>

    @if ($categories->isNotEmpty())
        <section class="collections" aria-labelledby="collections-title">
        <div class="collections__intro container" data-reveal>
            <p class="eyebrow">Para cada forma de expresarte</p>
            <h2 id="collections-title">Universos para descubrir un aroma propio.</h2>
            <p>Desde composiciones intensas hasta piezas de autor, cada categoría abre una forma distinta de explorar la perfumería.</p>
        </div>

        <div class="collections__grid container">
            @foreach ($categories as $category)
                <x-public.category-card :category="$category" />
            @endforeach
        </div>

        <div class="collections__action container" data-reveal>
            <a class="button button--outline" href="{{ route('catalog') }}">Explorar categorías</a>
        </div>
        </section>
    @endif

    @if ($featuredPerfumes->isNotEmpty())
        <section class="featured" aria-labelledby="featured-title">
        <div class="featured__intro container" data-reveal>
            <div>
                <p class="eyebrow">Una selección para comenzar</p>
                <h2 id="featured-title">Más vendidos</h2>
            </div>
            <p>Una selección temporal de perfumes para imaginar los matices que pronto podrás explorar en profundidad.</p>
        </div>

        <div class="featured__grid container">
            @foreach ($featuredPerfumes as $perfume)
                <x-public.featured-perfume :perfume="$perfume" />
            @endforeach
        </div>
        </section>
    @endif

    @if ($accords->isNotEmpty())
        <section class="accords" aria-labelledby="accords-title">
        <div class="accords__layout container">
            <div class="accords__intro" data-reveal>
                <p class="eyebrow">Aprender a percibir</p>
                <h2 id="accords-title">¿Cómo huele un perfume?</h2>
                <p>Los acordes son las sensaciones que una fragancia evoca al respirarla. Juntos construyen su carácter, como capas de una misma historia.</p>
                <div class="accords__vessel" aria-hidden="true"><span></span></div>
            </div>

            <div class="accords__example" data-reveal data-accords data-reveal-delay="1">
                <p class="accords__example-label">Ejemplo educativo de intensidad olfativa</p>
                <ul class="accords__list">
                    @foreach ($accords as $accord)
                        <x-public.accord-meter :accord="$accord" />
                    @endforeach
                </ul>
            </div>
        </div>
        </section>
    @endif

    <button class="back-to-top" type="button" aria-label="Volver al inicio" data-back-to-top hidden>
        <svg aria-hidden="true" viewBox="0 0 24 24" focusable="false">
            <path d="M12 18V6m0 0-5 5m5-5 5 5" />
        </svg>
    </button>
</x-layouts.public>
