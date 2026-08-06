@props(['perfume'])

<article class="featured-perfume featured-perfume--{{ $perfume->tone }}" data-reveal>
    <div class="featured-perfume__media" aria-hidden="true">
        <span class="featured-perfume__cap"></span>
        <span class="featured-perfume__bottle"></span>
        <span class="featured-perfume__shadow"></span>
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
