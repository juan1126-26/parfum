@php($activeRoute = request()->route()?->getName())

<aside id="admin-sidebar" class="admin-sidebar" aria-label="Navegacion administrativa">
    <div class="admin-sidebar__brand">
        <a href="{{ route('admin.dashboard') }}" aria-label="Parfum Administracion, dashboard">
            <span aria-hidden="true">P</span>
            <strong>Parfum</strong>
        </a>
        <p>Administracion</p>
    </div>

    <nav class="admin-navigation" aria-label="Modulos administrativos">
        <ul>
            @foreach (config('parfum.admin.navigation') as $item)
                @php($route = $item['route'] ?? 'admin.upcoming')
                @php($parameters = isset($item['route']) ? [] : ['module' => $item['key']])
                @php($isCurrent = $activeRoute === $route && (isset($item['route']) || request()->route('module') === $item['key']))
                <li>
                    <a
                        href="{{ route($route, $parameters) }}"
                        aria-label="{{ $item['label'] }}"
                        @class(['is-active' => $isCurrent])
                        @if ($isCurrent) aria-current="page" @endif
                    >
                        <span class="admin-navigation__mark" aria-hidden="true"></span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
