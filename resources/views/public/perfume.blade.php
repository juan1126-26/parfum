<x-layouts.public :active-route="$activeRoute" :title="$title" :description="$description" :canonical="$canonical">
    <section class="perfume-hero">
        <div class="container perfume-hero__layout">
            <div class="perfume-hero__content" data-reveal data-accords>
                <a class="perfume-back" href="{{ route('catalog') }}">← Volver al catálogo</a>
                <p class="eyebrow">{{ $perfume->brand->name }} · {{ $perfume->category->name }}</p>
                <a class="perfume-compare" href="{{ route('comparator', ['first' => $perfume->slug]) }}">Comparar esta fragancia</a>
                <h1>{{ $perfume->name }}</h1>
                @if ($perfume->short_description)
                    <p class="perfume-hero__lead">{{ $perfume->short_description }}</p>
                @endif
                @if ($perfume->accords->isNotEmpty())
                    <div class="perfume-hero__accords" aria-label="Acordes principales">
                        @foreach ($perfume->accords->take(3) as $accord)
                            <x-public.accord-meter :accord="$accord" compact />
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="perfume-hero__visual" data-reveal data-reveal-delay="1">
                @if ($coverImage)
                    <img src="{{ asset($coverImage->path) }}" alt="{{ $coverImage->alt_text }}" decoding="async" fetchpriority="high">
                @else
                    <div class="perfume-hero__placeholder" aria-label="Presentación de {{ $perfume->name }}">
                        <span></span><i></i><b>{{ $perfume->name }}</b>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($perfume->editorial_story)
        <section class="perfume-story" data-reveal><div class="container perfume-story__inner"><p class="eyebrow">La historia</p><blockquote>{{ $perfume->editorial_story }}</blockquote></div></section>
    @endif

    <x-public.olfactory-pyramid :stages="$notesByStage" />

    @if ($perfume->accords->isNotEmpty())
        <section class="perfume-accords" aria-labelledby="perfume-accords-title" data-reveal><div class="container"><p class="eyebrow">Los acordes</p><h2 id="perfume-accords-title">El carácter, medido con sutileza.</h2><div class="perfume-accords__grid">@foreach ($perfume->accords as $accord)<x-public.accord-meter :accord="$accord" />@endforeach</div></div></section>
    @endif

    <section class="perfume-experience" aria-labelledby="perfume-experience-title" data-reveal><div class="container"><p class="eyebrow">La experiencia</p><h2 id="perfume-experience-title">Cómo acompaña cada momento.</h2><div class="perfume-experience__grid">
        @foreach (['Duración' => $perfume->longevity_level, 'Proyección' => $perfume->projection_level, 'Intensidad' => $perfume->intensity_level] as $label => $level)
            @if ($level)<article><p>{{ $label }}</p><strong>{{ $level->label() }}</strong><span aria-hidden="true" class="experience-scale experience-scale--{{ $level->value }}"></span></article>@endif
        @endforeach
        @if ($perfume->climates->isNotEmpty())<article><p>Clima</p><strong>{{ $perfume->climates->pluck('name')->join(' · ') }}</strong></article>@endif
        @if ($perfume->seasons->isNotEmpty())<article><p>Temporada</p><strong>{{ $perfume->seasons->pluck('name')->join(' · ') }}</strong></article>@endif
        @if ($perfume->occasions->isNotEmpty())<article><p>Ocasiones</p><strong>{{ $perfume->occasions->pluck('name')->join(' · ') }}</strong></article>@endif
    </div></div></section>

    @if ($perfume->description)<section class="perfume-description" data-reveal><div class="container"><p class="eyebrow">En detalle</p><div><h2>Una composición para descubrir sin prisa.</h2><p>{{ $perfume->description }}</p></div></div></section>@endif

    @if ($perfume->images->count() > 1)<section class="perfume-gallery" aria-labelledby="perfume-gallery-title" data-reveal><div class="container"><p class="eyebrow">Galería</p><h2 id="perfume-gallery-title">Materia, luz y presencia.</h2><div class="perfume-gallery__grid">@foreach ($perfume->images as $image)<figure><img src="{{ asset($image->path) }}" alt="{{ $image->alt_text }}" loading="lazy" decoding="async"></figure>@endforeach</div></div></section>@endif

    @if ($relatedPerfumes->isNotEmpty())<section class="perfume-related" aria-labelledby="perfume-related-title"><div class="container"><p class="eyebrow">También podrías descubrir</p><h2 id="perfume-related-title">Afinidades para seguir explorando.</h2><div class="catalog-grid">@foreach ($relatedPerfumes as $relatedPerfume)<x-public.catalog-perfume :perfume="$relatedPerfume" />@endforeach</div></div></section>@endif
</x-layouts.public>
