<!DOCTYPE html>
<html lang="es-CO">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="theme-color" content="#10100f">
        <title>Acceso administrativo - Parfum</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="admin-login-body">
        <main class="admin-login" aria-labelledby="admin-login-title">
            <a class="admin-login__brand" href="{{ route('home') }}" aria-label="Volver a Parfum">
                <span aria-hidden="true">P</span>
                Parfum
            </a>

            <section class="admin-login__card">
                <p class="eyebrow">Administracion</p>
                <h1 id="admin-login-title">Un espacio para cuidar cada detalle.</h1>
                <p>Ingresa con tu cuenta administrativa para continuar.</p>

                <form method="POST" action="{{ route('admin.login.store') }}">
                    @csrf

                    <label for="email">Correo electronico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    @error('email')<p class="admin-form-error" role="alert">{{ $message }}</p>@enderror

                    <label for="password">Contrasena</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>

                    <label class="admin-login__remember" for="remember">
                        <input id="remember" name="remember" type="checkbox" value="1">
                        <span>Recordar este acceso</span>
                    </label>

                    <button class="admin-button admin-button--primary" type="submit">Entrar al panel</button>
                </form>
            </section>
        </main>
    </body>
</html>
