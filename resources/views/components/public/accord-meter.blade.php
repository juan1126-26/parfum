@props(['accord', 'compact' => false])

<article @class(['accord-meter', 'accord-meter--compact' => $compact]) data-accord-meter aria-label="{{ $accord->name }}: {{ $accord->pivot->intensity }} de 100, {{ $accord->pivot->intensity_label }}">
    <div class="accord-meter__heading">
        <span class="accord-meter__name">{{ $accord->name }}</span>
        @if ($accord->pivot->is_primary)
            <span class="accord-meter__primary">Acorde principal</span>
        @endif
        <span class="accord-meter__value">{{ $accord->pivot->intensity }}<small>/100</small></span>
    </div>
    <span class="accord-meter__track" aria-hidden="true">
        @for ($segment = 1; $segment <= 5; $segment++)
            <span @class(['is-filled' => $segment <= $accord->pivot->meter_segments])></span>
        @endfor
    </span>
    @unless ($compact)
        <span class="accord-meter__label">{{ $accord->pivot->intensity_label }}</span>
    @endunless
</article>
