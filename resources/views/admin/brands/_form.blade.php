<form class="admin-form" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <section class="admin-form-section" aria-labelledby="brand-details-title">
        <div><p class="eyebrow">Casa</p><h2 id="brand-details-title">Informacion principal</h2></div>
        <div class="admin-form-fields">
            <label>Nombre<input name="name" value="{{ old('name', $brand->name) }}" required>@error('name')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label>Slug<input name="slug" value="{{ old('slug', $brand->slug) }}" required>@error('slug')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label>Pais<input name="country" value="{{ old('country', $brand->country) }}">@error('country')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label>Orden del catalogo<input name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $brand->sort_order) }}" required>@error('sort_order')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
            <label class="admin-form-fields__full">Descripcion<textarea name="description" rows="6">{{ old('description', $brand->description) }}</textarea>@error('description')<small class="admin-field-error">{{ $message }}</small>@enderror</label>
        </div>
    </section>

    <div class="admin-form__actions">
        <a class="admin-button admin-button--secondary" href="{{ route('admin.brands.index') }}">Cancelar</a>
        <button class="admin-button admin-button--primary" type="submit">{{ $brand->exists ? 'Guardar cambios' : 'Crear marca' }}</button>
    </div>
</form>
