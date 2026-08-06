@props(['category'])

<article class="category-card category-card--{{ $category->tone }}" data-reveal>
    <div class="category-card__media" aria-hidden="true">
        <span class="category-card__orb"></span>
        <span class="category-card__vessel"></span>
    </div>
    <div class="category-card__content">
        <h3>{{ $category->name }}</h3>
        <p>{{ $category->description }}</p>
    </div>
</article>
