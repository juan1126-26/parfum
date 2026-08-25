@props(['title'])

<header class="admin-navbar">
    <button
        class="admin-sidebar-toggle"
        type="button"
        aria-expanded="true"
        aria-controls="admin-sidebar"
        data-admin-sidebar-toggle
    >
        <span class="sr-only">Alternar navegacion administrativa</span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
    </button>

    <p class="admin-navbar__title">{{ $title }}</p>

    <div class="admin-navbar__account">
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Cerrar sesion</button>
        </form>
    </div>
</header>
