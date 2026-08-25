<form class="admin-form" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <section class="admin-form-section" aria-labelledby="note-details-title">
        <div><p class="eyebrow">Materia</p><h2 id="note-details-title">Informacion principal</h2></div>
        <div class="admin-form-fields">
            <label>Nombre<input name="name" value="{{ old('name', $note->name) }}" required>@error('name')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label>Slug<input name="slug" value="{{ old('slug', $note->slug) }}" required>@error('slug')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label>Orden del catalogo<input name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $note->sort_order) }}" required>@error('sort_order')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label class="admin-form-fields__full">Descripcion<textarea name="description" rows="6">{{ old('description', $note->description) }}</textarea>@error('description')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <p class="admin-form-note admin-form-fields__full">Salida, corazon o fondo se selecciona para cada perfume en su piramide olfativa.</p>
        </div>
    </section>
    <div class="admin-form__actions">
        <a class="admin-button admin-button--secondary" href="{{ route('admin.notes.index') }}">Cancelar</a>
        <button class="admin-button admin-button--primary" type="submit">{{ $note->exists ? 'Guardar cambios' : 'Crear nota' }}</button>
    </div>
</form>
