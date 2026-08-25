@if (session('success'))
    <div class="admin-flash admin-flash--success" role="status">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="admin-flash admin-flash--error" role="alert">
        Revisa los campos marcados antes de continuar.
    </div>
@endif
