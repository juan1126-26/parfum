@props([
    'code',
    'title',
    'description',
    'actionLabel' => 'Volver al inicio',
    'actionRoute' => 'home',
])

<x-layouts.public :title="$code" :description="$description" robots="noindex, nofollow">
    <section class="error-page" aria-labelledby="error-title">
        <div class="container error-page__inner">
            <p class="eyebrow">Error {{ $code }}</p>
            <span class="error-page__code" aria-hidden="true">{{ $code }}</span>
            <h1 id="error-title">{{ $title }}</h1>
            <p>{{ $description }}</p>
            <div class="error-page__actions">
                <a class="button button--gold" href="{{ route($actionRoute) }}">{{ $actionLabel }}</a>
                <a class="button button--quiet" href="{{ route('catalog') }}">Explorar la coleccion</a>
            </div>
        </div>
    </section>
</x-layouts.public>
