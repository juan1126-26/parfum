@props(['perfume'])

<article class="catalog-card catalog-card--{{ $perfume->tone }}" data-reveal>
    <div class="catalog-card__media" @if (! $perfume->coverImage) aria-hidden="true" @endif>
        @if ($perfume->coverImage)
            <img src="{{ asset($perfume->coverImage->path) }}" alt="{{ $perfume->coverImage->alt_text }}" loading="lazy" decoding="async">
        @else
            <span class="catalog-card__halo"></span>
            <span class="catalog-card__bottle"></span>
            <span class="catalog-card__cap"></span>
            <span class="catalog-card__shadow"></span>
        @endif
    </div>

    <div class="catalog-card__content">
        <p class="catalog-card__brand">{{ $perfume->brand->name }}</p>
        <h2>{{ $perfume->name }}</h2>
        <p class="catalog-card__category">{{ $perfume->category->name }}</p>

        @if ($perfume->accords->isNotEmpty())
            <div class="catalog-card__accords" aria-label="Acordes principales">
                @foreach ($perfume->accords as $accord)
                    <x-public.accord-meter :accord="$accord" compact />
                @endforeach
            </div>
        @endif

        <a class="catalog-card__discover" href="{{ route('catalog.show', $perfume) }}" aria-label="Descubrir {{ $perfume->name }}">Descubrir <span>Ver fragancia</span></a>
        <a class="catalog-card__compare" href="{{ route('comparator', ['first' => $perfume->slug]) }}">Comparar</a>
    </div>
</article>
