@props(['perfume'])

<article class="featured-perfume featured-perfume--{{ $perfume->tone }}" data-reveal>
    <div class="featured-perfume__media" @if (! $perfume->coverImage) aria-hidden="true" @endif>
        @if ($perfume->coverImage)
            <img src="{{ asset($perfume->coverImage->path) }}" alt="{{ $perfume->coverImage->alt_text }}" loading="lazy" decoding="async">
        @else
            <span class="featured-perfume__cap"></span>
            <span class="featured-perfume__bottle"></span>
            <span class="featured-perfume__shadow"></span>
        @endif
    </div>
    <div class="featured-perfume__content">
        <p class="featured-perfume__brand">{{ $perfume->brand->name }}</p>
        <h3>{{ $perfume->name }}</h3>
        <p class="featured-perfume__category">{{ $perfume->category->name }}</p>
        <a href="{{ route('catalog.show', $perfume) }}" aria-label="Conocer mas sobre {{ $perfume->name }}">
            Conocer mas <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</article>
