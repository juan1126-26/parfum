<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            <a class="brand" href="{{ route('home') }}" aria-label="Parfum, inicio">{{ config('parfum.brand.name') }}</a>
            <p class="site-footer__tagline">{{ config('parfum.brand.tagline') }}</p>
            <p class="site-footer__note">Una guia digital para descubrir aromas con calma, criterio y presencia.</p>
        </div>

        <nav class="site-footer__navigation" aria-label="Navegacion del pie de pagina">
            <p class="site-footer__label">Explorar</p>
            <ul>
                @foreach(config('parfum.navigation') as $item)
                    <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </nav>

        <div class="site-footer__contact">
            <p class="site-footer__label">Mantente cerca</p>
            <a href="mailto:{{ config('parfum.contact.email') }}">{{ config('parfum.contact.email') }}</a>
            <a href="{{ config('parfum.contact.phone_href') }}">{{ config('parfum.contact.phone') }}</a>
            <p>{{ config('parfum.contact.address') }}</p>
            <div class="site-footer__socials" aria-label="Redes sociales">
                @foreach(config('parfum.socials') as $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">{{ $social['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container site-footer__bottom">
        <p>&copy; {{ now()->year }} {{ config('parfum.brand.name') }}. Todos los derechos reservados.</p>
        <nav aria-label="Enlaces importantes"><a href="{{ route('about') }}#filosofia">Filosofia</a><a href="{{ route('contact') }}#preguntas">Preguntas frecuentes</a><a href="{{ route('perfect-aroma') }}">Mi Aroma Perfecto</a></nav>
    </div>
</footer>
