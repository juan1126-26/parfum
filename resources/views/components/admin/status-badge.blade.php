@props(['active'])

<span @class(['admin-status', 'admin-status--inactive' => ! $active])>
    {{ $active ? 'Activo' : 'Inactivo' }}
</span>
