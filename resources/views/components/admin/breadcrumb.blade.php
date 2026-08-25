@props(['items' => []])

<nav class="admin-breadcrumb" aria-label="Miga de pan">
    <ol>
        @foreach ($items as $item)
            <li>
                @if (isset($item['route']))
                    <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                @else
                    <span aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
