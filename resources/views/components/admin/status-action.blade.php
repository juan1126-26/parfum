@props(['action', 'active', 'subject'])

<details class="admin-status-action">
    <summary>{{ $active ? 'Desactivar' : 'Activar' }}</summary>
    <div>
        <p>
            {{ $active ? 'Dejara de estar disponible en la experiencia publica.' : 'Volvera a estar disponible en la experiencia publica.' }}
        </p>
        <form method="POST" action="{{ $action }}">
            @csrf
            @method('PATCH')
            <button class="admin-button {{ $active ? 'admin-button--danger' : 'admin-button--primary' }}" type="submit">
                {{ $active ? 'Confirmar desactivacion' : 'Confirmar activacion' }}
            </button>
        </form>
    </div>
</details>
