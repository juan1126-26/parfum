@props(['category'])

<article class="category-card category-card--{{ $category->tone }}" data-reveal>
    <div class="category-card__media" aria-hidden="true">
        @if ($category->cover_image)
            <img src="{{ asset('storage/'.$category->cover_image) }}" alt="" loading="lazy" decoding="async">
        @else
            <span class="category-card__placeholder"></span>
        @endif
    </div>
    <div class="category-card__content">
        <h3>{{ $category->name }}</h3>
        <p>{{ $category->description }}</p>
    </div>
</article>
