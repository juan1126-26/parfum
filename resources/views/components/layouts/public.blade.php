@props([
    'activeRoute' => null,
    'title' => null,
    'description' => null,
    'canonical' => null,
    'robots' => null,
])

<!DOCTYPE html>
<html lang="es-CO">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @php($seoTitle = $title ? $title.' - '.config('parfum.brand.name') : config('parfum.brand.name'))
        @php($seoDescription = $description ?? config('parfum.brand.description'))
        @php($seoCanonical = $canonical ?? url()->current())

        <title>{{ $seoTitle }}</title>
        <meta name="description" content="{{ $seoDescription }}">
        <meta name="robots" content="{{ $robots ?? config('parfum.seo.robots') }}">
        <meta name="theme-color" content="{{ config('parfum.seo.theme_color') }}">
        <link rel="canonical" href="{{ $seoCanonical }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <meta property="og:type" content="website">
        <meta property="og:locale" content="{{ config('parfum.seo.locale') }}">
        <meta property="og:site_name" content="{{ config('parfum.brand.name') }}">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:url" content="{{ $seoCanonical }}">
        <meta name="twitter:card" content="{{ config('parfum.seo.twitter_card') }}">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a class="skip-link" href="#main-content">Saltar al contenido principal</a>
        <x-public.navbar :active-route="$activeRoute" />

        <main id="main-content" tabindex="-1">
            {{ $slot }}
        </main>

        <x-public.footer />
    </body>
</html>
