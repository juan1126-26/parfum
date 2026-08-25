@props([
    'title' => 'Dashboard',
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="es-CO">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="theme-color" content="#10100f">
        <title>{{ $title }} - Administracion Parfum</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="admin-body">
        <a class="skip-link" href="#admin-main">Saltar al contenido principal</a>

        <div class="admin-shell" data-admin-shell>
            <x-admin.sidebar />

            <div class="admin-workspace">
                <x-admin.navbar :title="$title" />

                <main id="admin-main" class="admin-main" tabindex="-1">
                    <x-admin.breadcrumb :items="$breadcrumbs" />
                    {{ $slot }}
                </main>

                <footer class="admin-footer">
                    <p>Parfum Administracion</p>
                    <p>Gestiona el universo olfativo con calma y precision.</p>
                </footer>
            </div>
        </div>
    </body>
</html>
