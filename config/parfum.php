<?php

return [
    'seo' => [
        'locale' => 'es_CO',
        'theme_color' => '#0b0b0b',
        'twitter_card' => 'summary',
        'robots' => 'index, follow',
        'sitemap_routes' => [
            ['route' => 'home'],
            ['route' => 'about'],
            ['route' => 'catalog'],
            ['route' => 'perfect-aroma'],
            ['route' => 'comparator'],
            ['route' => 'contact'],
        ],
    ],

    'brand' => [
        'name' => 'Parfum',
        'tagline' => 'El lujo comienza con un aroma.',
        'description' => 'Una experiencia digital para descubrir aromas que expresan quién eres.',
    ],

    'navigation' => [
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Nosotros', 'route' => 'about'],
        ['label' => 'Catálogo', 'route' => 'catalog'],
        ['label' => 'Mi Aroma Perfecto', 'route' => 'perfect-aroma'],
        ['label' => 'Comparador', 'route' => 'comparator'],
        ['label' => 'Contacto', 'route' => 'contact'],
    ],

    'recommendations' => [
        'result_limit' => 3,
    ],

    'contact' => [
        'email' => 'hola@parfum.co',
        'phone' => '+57 300 000 0000',
        'phone_href' => 'tel:+573000000000',
        'address' => 'Bogota, Colombia',
        'hours' => [
            ['label' => 'Lunes a viernes', 'value' => '9:00 a.m. - 6:00 p.m.'],
            ['label' => 'Sabados', 'value' => '10:00 a.m. - 2:00 p.m.'],
        ],
    ],

    'socials' => [
        ['name' => 'Instagram', 'handle' => '@parfum.co', 'url' => 'https://www.instagram.com/', 'label' => 'Visitar Instagram de Parfum'],
        ['name' => 'Pinterest', 'handle' => 'Parfum', 'url' => 'https://www.pinterest.com/', 'label' => 'Visitar Pinterest de Parfum'],
        ['name' => 'TikTok', 'handle' => '@parfum.co', 'url' => 'https://www.tiktok.com/', 'label' => 'Visitar TikTok de Parfum'],
    ],

    'instagram_posts' => [
        ['label' => 'Materia y luz', 'tone' => 'amber'],
        ['label' => 'El gesto diario', 'tone' => 'linen'],
        ['label' => 'Notas que permanecen', 'tone' => 'cedar'],
        ['label' => 'Una pausa precisa', 'tone' => 'mineral'],
        ['label' => 'Ritual nocturno', 'tone' => 'nocturne'],
        ['label' => 'El detalle esencial', 'tone' => 'floral'],
    ],

    'institutional' => [
        'about' => [
            'hero' => ['eyebrow' => 'La esencia de Parfum', 'title' => 'Un aroma puede decir algo antes que las palabras.', 'description' => 'Parfum nace para convertir la busqueda de una fragancia en un descubrimiento sereno, personal y memorable.'],
            'story' => ['eyebrow' => 'Nuestra historia', 'title' => 'No queremos vender perfumes. Queremos revelar afinidades.', 'body' => 'Creemos que una fragancia es presencia antes de una reunion, confianza antes de una cita y memoria cuando un momento ya paso. Cada perfume cuenta una historia; cada persona tambien. Nuestro trabajo consiste en acercar ambas con criterio y calma.'],
            'philosophy' => ['eyebrow' => 'Nuestra filosofia', 'title' => 'Elegir un perfume debe sentirse como una experiencia.', 'body' => 'La perfumeria no necesita ser compleja para ser profunda. Hacemos espacio para aprender, comparar y percibir cada matiz sin prisa, sin ruido y sin promesas exageradas.'],
            'purpose' => [
                ['label' => 'Mision', 'title' => 'Crear la mejor experiencia digital para descubrir perfumes.', 'body' => 'Una guia clara y elegante para aprender, comparar y encontrar una fragancia afin a cada momento.'],
                ['label' => 'Vision', 'title' => 'Ser la boutique digital premium de referencia en Latinoamerica.', 'body' => 'Una casa reconocida por la calidad de su seleccion y la confianza de su experiencia.'],
            ],
            'values' => [
                ['number' => '01', 'title' => 'Elegancia', 'body' => 'Cada detalle debe transmitir calidad.'],
                ['number' => '02', 'title' => 'Pasion', 'body' => 'Recomendamos aquello que creemos valioso.'],
                ['number' => '03', 'title' => 'Honestidad', 'body' => 'La claridad es nuestra forma de cuidar la confianza.'],
                ['number' => '04', 'title' => 'Innovacion', 'body' => 'La tecnologia solo importa cuando mejora la experiencia.'],
                ['number' => '05', 'title' => 'Atencion al detalle', 'body' => 'Las pequenas decisiones construyen lo memorable.'],
            ],
            'differences' => [
                ['title' => 'Aprender a percibir', 'body' => 'Acordes, notas y desempeno explicados con claridad.'],
                ['title' => 'Elegir con criterio', 'body' => 'Comparar es descubrir lo que realmente acompana tu estilo.'],
                ['title' => 'Encontrar afinidad', 'body' => 'Una recomendacion personal construida desde tus preferencias.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Imagina el momento', 'body' => 'Piensa donde quieres que el aroma te acompane.'],
                ['step' => '02', 'title' => 'Percibe los matices', 'body' => 'Explora acordes, notas y presencia sin tecnicismos innecesarios.'],
                ['step' => '03', 'title' => 'Descubre tu afinidad', 'body' => 'Deja que tus respuestas revelen una seleccion precisa.'],
            ],
        ],
        'contact' => [
            'hero' => ['eyebrow' => 'Parfum', 'title' => 'Una conversacion sobre lo que permanece.', 'description' => 'Estamos aqui para orientarte con calma, responder tus preguntas y seguir descubriendo aromas contigo.'],
            'form' => ['eyebrow' => 'Escribenos', 'title' => 'Tu mensaje tambien tiene una historia.', 'description' => 'Este espacio esta preparado para recibir tus consultas. Muy pronto podras enviarnos un mensaje directamente desde Parfum.'],
            'faq' => [
                ['question' => 'Como elijo mi primer perfume?', 'answer' => 'Comienza por el momento en que quieres usarlo y los acordes que mas te atraen. Mi Aroma Perfecto puede orientarte.'],
                ['question' => 'Puedo comparar dos fragancias?', 'answer' => 'Si. El comparador permite observar acordes, desempeno, climas y ocasiones lado a lado.'],
                ['question' => 'Parfum ofrece asesoria personalizada?', 'answer' => 'Nuestra guia digital ya crea recomendaciones por afinidad. La asesoria humana sera una proxima evolucion de la experiencia.'],
            ],
        ],
    ],

    'pages' => [
        'about' => [
            'eyebrow' => 'La esencia de Parfum',
            'title' => 'Una historia que comienza con lo que permanece.',
            'description' => 'Estamos preparando el espacio para compartir nuestra mirada sobre la perfumería: una forma de expresión, memoria y presencia.',
        ],
        'catalog' => [
            'eyebrow' => 'Próximamente',
            'title' => 'Una colección para descubrir sin prisa.',
            'description' => 'Muy pronto podrás explorar perfumes, sus acordes y las historias que los hacen únicos.',
        ],
        'perfect-aroma' => [
            'eyebrow' => 'Una experiencia personal',
            'title' => 'Encuentra el aroma que habla de ti.',
            'description' => 'Estamos diseñando una guía serena e intuitiva para ayudarte a descubrir fragancias afines a tu personalidad.',
        ],
        'comparator' => [
            'eyebrow' => 'Perspectiva y detalle',
            'title' => 'Comparar también es descubrir.',
            'description' => 'Próximamente podrás observar dos perfumes lado a lado y entender sus matices con claridad.',
        ],
        'contact' => [
            'eyebrow' => 'Parfum',
            'title' => 'Una conversación por comenzar.',
            'description' => 'Este espacio reunirá las formas de acercarte a Parfum cuando la experiencia esté lista para continuar.',
        ],
    ],
];
