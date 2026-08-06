@props(['activeRoute'])

<header class="site-header">
    <div class="site-header__inner container">
        <a class="brand" href="{{ route('home') }}" aria-label="Parfum, inicio">
            {{ config('parfum.brand.name') }}
        </a>

        <button
            class="menu-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="primary-navigation"
            data-menu-toggle
        >
            <span class="sr-only">Abrir menú de navegación</span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </button>

        <nav id="primary-navigation" class="primary-navigation" aria-label="Navegación principal" data-mobile-menu>
            <ul>
                @foreach (config('parfum.navigation') as $item)
                    <li>
                        <a
                            href="{{ route($item['route']) }}"
                            @class(['is-active' => $activeRoute === $item['route']])
                            @if ($activeRoute === $item['route']) aria-current="page" @endif
                        >{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
