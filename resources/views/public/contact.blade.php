<x-layouts.public :active-route="$activeRoute" :title="$title" :description="$description" :canonical="$canonical">
    <section class="institutional-hero institutional-hero--contact" aria-labelledby="contact-title">
        <div class="institutional-hero__orb" aria-hidden="true"></div>
        <div class="container institutional-hero__inner" data-reveal><p class="eyebrow">{{ $content['hero']['eyebrow'] }}</p><h1 id="contact-title">{{ $content['hero']['title'] }}</h1><p>{{ $content['hero']['description'] }}</p><a class="button button--gold" href="#escribenos">Escribir a Parfum</a></div>
    </section>

    <section class="contact-details" aria-labelledby="contact-details-title">
        <div class="container"><p class="eyebrow" data-reveal>Una presencia cercana</p><h2 id="contact-details-title" class="sr-only">Informacion de contacto</h2>
            <div class="contact-details__grid"><article data-reveal><p>Correo</p><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></article><article data-reveal><p>Telefono</p><a href="{{ $contact['phone_href'] }}">{{ $contact['phone'] }}</a></article><article data-reveal><p>Desde</p><strong>{{ $contact['address'] }}</strong></article></div>
        </div>
    </section>

    <section id="escribenos" class="contact-form-section" aria-labelledby="contact-form-title">
        <div class="container contact-form-section__layout"><div data-reveal><p class="eyebrow">{{ $content['form']['eyebrow'] }}</p><h2 id="contact-form-title">{{ $content['form']['title'] }}</h2><p>{{ $content['form']['description'] }}</p></div>
            <form class="contact-form" aria-describedby="contact-form-note" data-reveal data-reveal-delay="1"><div class="contact-form__grid"><label>Nombre<input type="text" name="name" autocomplete="name" placeholder="Tu nombre"></label><label>Correo<input type="email" name="email" autocomplete="email" placeholder="tu@correo.com"></label></div><label>Asunto<input type="text" name="subject" placeholder="En que podemos orientarte"></label><label>Mensaje<textarea name="message" rows="5" placeholder="Cuentanos un poco mas"></textarea></label><p id="contact-form-note">El envio de mensajes estara disponible muy pronto. Mientras tanto, puedes escribirnos a <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>.</p><button class="button button--gold" type="button" disabled aria-describedby="contact-form-note">Enviar mensaje</button></form>
        </div>
    </section>

    <section class="contact-presence" aria-label="Horarios, redes y ubicacion">
        <div class="container contact-presence__grid"><article data-reveal><p class="eyebrow">Horarios</p><h2>Cuando estamos cerca.</h2><dl>@foreach($contact['hours'] as $hours)<div><dt>{{ $hours['label'] }}</dt><dd>{{ $hours['value'] }}</dd></div>@endforeach</dl></article><article data-reveal><p class="eyebrow">Redes</p><h2>El universo Parfum.</h2><ul>@foreach($socials as $social)<li><a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"><span>{{ $social['name'] }}</span><small>{{ $social['handle'] }}</small></a></li>@endforeach</ul></article><div class="contact-map" data-reveal aria-label="Ubicacion de Parfum en Bogota, Colombia"><span aria-hidden="true"></span><p>Bogota<br><small>Colombia</small></p></div></div>
    </section>

    <section class="instagram-section" aria-labelledby="instagram-title"><div class="container"><div class="instagram-section__heading" data-reveal><div><p class="eyebrow">Notas visuales</p><h2 id="instagram-title">El universo Parfum, en imagenes.</h2></div><a href="{{ $socials[0]['url'] }}" target="_blank" rel="noopener noreferrer">Seguir en Instagram <span aria-hidden="true">&rarr;</span></a></div><x-public.instagram-grid :posts="$instagramPosts" /></div></section>

    <section id="preguntas" class="contact-faq" aria-labelledby="faq-title"><div class="container"><div class="about-section-heading" data-reveal><p class="eyebrow">Preguntas frecuentes</p><h2 id="faq-title">Todo comienza con una buena conversacion.</h2></div><div class="contact-faq__list">@foreach($content['faq'] as $faq)<details data-reveal><summary>{{ $faq['question'] }}<span aria-hidden="true">+</span></summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div></div></section>

    <section class="institutional-cta" aria-labelledby="contact-cta-title"><div class="container" data-reveal><p class="eyebrow">Una guia para comenzar</p><h2 id="contact-cta-title">No necesitas saberlo todo para encontrar un aroma propio.</h2><p>Responde unas preguntas sencillas y descubre fragancias que se acercan a tu momento.</p><a class="button button--gold" href="{{ route('perfect-aroma') }}">Ir a Mi Aroma Perfecto</a></div></section>
</x-layouts.public>
