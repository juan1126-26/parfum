@props(['posts'])

<div class="instagram-grid" aria-label="Seleccion editorial para Instagram">
    @foreach($posts as $post)
        <div class="instagram-grid__post instagram-grid__post--{{ $post['tone'] }}" aria-label="{{ $post['label'] }}">
            <span aria-hidden="true"></span>
            <p>{{ $post['label'] }}</p>
        </div>
    @endforeach
</div>
