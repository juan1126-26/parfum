<section class="admin-image-management" aria-labelledby="perfume-images-title">
    <div class="admin-image-management__heading">
        <div><p class="eyebrow">Presentacion</p><h2 id="perfume-images-title">Imagenes del perfume</h2></div>
        <p>La primera imagen cargada se convierte en portada. Puedes seleccionar otra en cualquier momento.</p>
    </div>

    <form class="admin-image-upload" method="POST" action="{{ route('admin.perfumes.images.store', $perfume) }}" enctype="multipart/form-data">
        @csrf
        <label>
            Archivo de imagen
            <input name="image" type="file" accept="image/jpeg,image/png,image/webp" required>
            @error('image')<small class="admin-field-error">{{ $message }}</small>@enderror
        </label>
        <label>
            Texto alternativo
            <input name="alt_text" value="{{ old('alt_text') }}" maxlength="255" placeholder="Describe la imagen para lectores de pantalla">
            @error('alt_text')<small class="admin-field-error">{{ $message }}</small>@enderror
        </label>
        <button class="admin-button admin-button--primary" type="submit">Subir imagen</button>
    </form>

    <div class="admin-image-grid" aria-live="polite">
        @forelse ($perfume->images as $image)
            <article class="admin-image-card">
                <div class="admin-image-card__preview">
                    <img src="{{ asset($image->path) }}" alt="{{ $image->alt_text ?: 'Vista previa de '.$perfume->name }}" loading="lazy" decoding="async">
                    @if ($image->is_cover)<span>Portada</span>@endif
                </div>
                <form class="admin-image-card__form" method="POST" action="{{ route('admin.perfumes.images.update', [$perfume, $image]) }}">
                    @csrf
                    @method('PUT')
                    <label>
                        Texto alternativo
                        <input name="alt_text" value="{{ old('alt_text', $image->alt_text) }}" maxlength="255" placeholder="Describe la imagen">
                        @error('alt_text')<small class="admin-field-error">{{ $message }}</small>@enderror
                    </label>
                    <label>
                        Orden
                        <input name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $image->sort_order) }}" required>
                        @error('sort_order')<small class="admin-field-error">{{ $message }}</small>@enderror
                    </label>
                    <button class="admin-text-link" type="submit">Guardar detalles</button>
                </form>
                <div class="admin-image-card__actions">
                    @unless ($image->is_cover)
                        <form method="POST" action="{{ route('admin.perfumes.images.cover', [$perfume, $image]) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-text-link" type="submit">Usar como portada</button>
                        </form>
                    @endunless
                    <details class="admin-image-card__delete">
                        <summary>Eliminar</summary>
                        <div>
                            <p>Esta accion eliminara el archivo y no se puede deshacer.</p>
                            <form method="POST" action="{{ route('admin.perfumes.images.destroy', [$perfume, $image]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="admin-button admin-button--danger" type="submit">Confirmar eliminacion</button>
                            </form>
                        </div>
                    </details>
                </div>
            </article>
        @empty
            <div class="admin-image-empty"><p>Aun no hay imagenes para este perfume.</p><span>Incorpora una imagen para presentar la fragancia.</span></div>
        @endforelse
    </div>
</section>
