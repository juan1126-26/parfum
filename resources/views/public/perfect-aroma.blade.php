<x-layouts.public :active-route="$activeRoute" :title="$title" :description="$description" :canonical="$canonical">
    @if($recommendations === null)
        <section class="aroma-hero" aria-labelledby="aroma-title">
            <div class="aroma-hero__glow" aria-hidden="true"></div>
            <div class="container aroma-hero__layout">
                <div class="aroma-journey__intro" data-reveal>
                    <p class="eyebrow">Una seleccion personal</p>
                    <h1 id="aroma-title">Encuentra el aroma que acompana tu momento.</h1>
                    <p>Seis decisiones sencillas nos permiten revelar una seleccion de fragancias afines a ti.</p>
                    <p class="aroma-journey__note">Tu eleccion no se guarda. Solo guia esta recomendacion.</p>
                    <a class="button button--gold" href="#aroma-assistant">Comenzar la experiencia</a>
                </div>
            </div>
        </section>

        <section id="aroma-assistant" class="aroma-journey aroma-journey--assistant" data-aroma-journey aria-labelledby="aroma-wizard-title">
            <div class="container aroma-journey__layout">
                <h2 id="aroma-wizard-title" class="sr-only">Cuestionario Mi Aroma Perfecto</h2>
                <form class="aroma-wizard" method="POST" action="{{ route('perfect-aroma.results') }}" data-aroma-wizard novalidate>
                    @csrf
                    <div class="aroma-progress" aria-label="Progreso del cuestionario">
                        <span class="aroma-progress__label" data-aroma-step-label>Pregunta 1 de {{ $questions->count() }}</span>
                        <div class="aroma-progress__track" aria-hidden="true"><span data-aroma-progress style="--aroma-progress: {{ 100 / $questions->count() }}%"></span></div>
                    </div>
                    <p class="aroma-wizard__status" aria-live="polite" data-aroma-status></p>

                    @foreach($questions as $index => $question)
                        <section class="aroma-step" data-aroma-step @if($index > 0) hidden @endif aria-labelledby="aroma-question-{{ $question->id }}">
                            <fieldset>
                                <legend id="aroma-question-{{ $question->id }}" tabindex="-1">{{ $question->text }}</legend>
                                @if($question->description)<p>{{ $question->description }}</p>@endif
                                <div class="aroma-options">
                                    @foreach($question->options as $option)
                                        <label class="aroma-option">
                                            <input class="aroma-option__input" type="{{ $question->criterion->value === 'accord' ? 'checkbox' : 'radio' }}" name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                                            <span class="aroma-option__card"><strong>{{ $option->label }}</strong>@if($option->description)<small>{{ $option->description }}</small>@endif<span class="aroma-option__mark" aria-hidden="true"></span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </section>
                    @endforeach

                    <p class="aroma-wizard__error" role="alert" hidden data-aroma-error></p>
                    <div class="aroma-wizard__actions">
                        <button class="button button--quiet" type="button" data-aroma-back disabled>Anterior</button>
                        <button class="button button--gold" type="button" data-aroma-next>Siguiente</button>
                        <button class="button button--gold" type="submit" data-aroma-submit hidden>Finalizar y ver mi seleccion</button>
                    </div>
                </form>
            </div>
        </section>
    @else
        <section class="aroma-results" aria-labelledby="aroma-results-title">
            <div class="container">
                <div class="aroma-results__intro" data-reveal><p class="eyebrow">Tu seleccion personal</p><h1 id="aroma-results-title">Estos aromas hablan tu mismo idioma.</h1><p>Las afinidades se construyen a partir de los acordes, el momento y la presencia que elegiste.</p><a class="button button--quiet" href="{{ route('perfect-aroma') }}">Repetir la experiencia</a></div>

                @if($recommendations->isNotEmpty())
                    <div class="aroma-results__grid">
                        @foreach($recommendations as $recommendation)
                            @php($perfume = $recommendation['perfume'])
                            <article class="aroma-result" data-reveal>
                                <div class="aroma-result__media">
                                    @if($perfume->images->first())<img src="{{ asset($perfume->images->first()->path) }}" alt="{{ $perfume->images->first()->alt_text }}" loading="lazy" decoding="async">@else<div class="aroma-result__placeholder" aria-hidden="true"><span></span><i></i></div>@endif
                                    <div class="aroma-result__affinity"><strong>{{ $recommendation['affinity_percentage'] }}%</strong><span>{{ $recommendation['affinity_level'] }}</span></div>
                                </div>
                                <div class="aroma-result__content"><p class="eyebrow">{{ $perfume->brand->name }}</p><h2>{{ $perfume->name }}</h2><p class="aroma-result__reasons">{{ collect($recommendation['reasons'])->join(' - ') }}</p>
                                    @if($perfume->accords->isNotEmpty())<div class="aroma-result__accords" aria-label="Acordes principales">@foreach($perfume->accords->take(3) as $accord)<span>{{ $accord->name }}</span>@endforeach</div>@endif
                                    <a class="aroma-result__link" href="{{ route('catalog.show', $perfume) }}">Descubrir la fragancia <span aria-hidden="true">&rarr;</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="aroma-results__empty" data-reveal><p class="eyebrow">Una afinidad por descubrir</p><h2>Aun no encontramos una coincidencia precisa.</h2><p>Prueba de nuevo con otra combinacion de respuestas y encontraremos un aroma que se acerque mas a tu momento.</p><a class="button button--gold" href="{{ route('perfect-aroma') }}">Intentarlo de nuevo</a></div>
                @endif
            </div>
        </section>
    @endif
</x-layouts.public>
