@props(['label', 'value', 'detail'])

<article class="admin-stat-card">
    <p>{{ $label }}</p>
    <strong>{{ number_format($value) }}</strong>
    <span>{{ $detail }}</span>
</article>
