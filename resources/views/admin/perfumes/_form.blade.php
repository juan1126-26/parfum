@php
    $accordSelections = old('accords', $perfume->accords->mapWithKeys(fn ($accord) => [
        $accord->id => [
            'selected' => true,
            'intensity' => $accord->pivot->intensity,
            'sort_order' => $accord->pivot->sort_order,
        ],
    ])->all());
    $noteSelections = old('notes', $perfume->notes->mapWithKeys(fn ($note) => [
        $note->id => [
            'selected' => true,
            'stage' => $note->pivot->stage->value,
            'sort_order' => $note->pivot->sort_order,
        ],
    ])->all());
    $primaryAccordId = old('primary_accord_id', optional($perfume->accords->first(fn ($accord) => $accord->pivot->is_primary))->id);
    $climateIds = old('climate_ids', $perfume->climates->modelKeys());
    $seasonIds = old('season_ids', $perfume->seasons->modelKeys());
    $occasionIds = old('occasion_ids', $perfume->occasions->modelKeys());
@endphp

<form class="admin-form" method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <section class="admin-form-section" aria-labelledby="perfume-basic-title">
        <div>
            <p class="eyebrow">Esencia</p>
            <h2 id="perfume-basic-title">Informacion principal</h2>
        </div>
        <div class="admin-form-fields">
            <label>
                Nombre
                <input name="name" value="{{ old('name', $perfume->name) }}" required>
                @error('name')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label>
                Slug
                <input name="slug" value="{{ old('slug', $perfume->slug) }}" required>
                @error('slug')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label>
                Marca
                <select name="brand_id" required>
                    <option value="">Selecciona una marca</option>
                    @foreach ($brands as $brand)<option value="{{ $brand->id }}" @selected((int) old('brand_id', $perfume->brand_id) === $brand->id)>{{ $brand->name }}</option>@endforeach
                </select>
                @error('brand_id')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label>
                Categoria
                <select name="category_id" required>
                    <option value="">Selecciona una categoria</option>
                    @foreach ($categories as $category)<option value="{{ $category->id }}" @selected((int) old('category_id', $perfume->category_id) === $category->id)>{{ $category->name }}</option>@endforeach
                </select>
                @error('category_id')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label class="admin-form-fields__full">
                Descripcion breve
                <textarea name="short_description" rows="3">{{ old('short_description', $perfume->short_description) }}</textarea>
                @error('short_description')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label class="admin-form-fields__full">
                Descripcion
                <textarea name="description" rows="5">{{ old('description', $perfume->description) }}</textarea>
                @error('description')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <label class="admin-form-fields__full">
                Historia editorial
                <textarea name="editorial_story" rows="6">{{ old('editorial_story', $perfume->editorial_story) }}</textarea>
                @error('editorial_story')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
        </div>
    </section>

    <section class="admin-form-section" aria-labelledby="perfume-performance-title">
        <div>
            <p class="eyebrow">Presencia</p>
            <h2 id="perfume-performance-title">Desempeno</h2>
        </div>
        <div class="admin-form-fields">
            @foreach (['longevity_level' => 'Duracion', 'projection_level' => 'Proyeccion', 'intensity_level' => 'Intensidad'] as $field => $label)
                <label>
                    {{ $label }}
                    <select name="{{ $field }}">
                        <option value="">Sin definir</option>
                        @foreach ($performanceLevels as $level)<option value="{{ $level->value }}" @selected(old($field, $perfume->{$field}?->value) === $level->value)>{{ $level->label() }}</option>@endforeach
                    </select>
                    @error($field)<small class="admin-field-error">{{ $message }}</small>@enderror
                </label>
            @endforeach
            <label>
                Orden del catalogo
                <input name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $perfume->sort_order) }}" required>
                @error('sort_order')<small class="admin-field-error">{{ $message }}</small>@enderror
            </label>
            <div class="admin-toggle-fields">
                <input name="is_featured" type="hidden" value="0">
                <label><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $perfume->is_featured))> Destacado</label>
                <input name="is_best_seller" type="hidden" value="0">
                <label><input name="is_best_seller" type="checkbox" value="1" @checked(old('is_best_seller', $perfume->is_best_seller))> Mas vendido</label>
            </div>
        </div>
    </section>

    <section class="admin-form-section" aria-labelledby="perfume-accords-title">
        <div>
            <p class="eyebrow">Acordes</p>
            <h2 id="perfume-accords-title">Perfil olfativo</h2>
        </div>
        <div class="admin-relation-grid">
            @foreach ($accords as $accord)
                @php($selection = $accordSelections[$accord->id] ?? [])
                <article class="admin-relation-card">
                    <label><input name="accords[{{ $accord->id }}][selected]" type="checkbox" value="1" @checked(data_get($selection, 'selected'))> {{ $accord->name }}</label>
                    <label>Intensidad<input name="accords[{{ $accord->id }}][intensity]" type="number" min="0" max="100" value="{{ data_get($selection, 'intensity', 50) }}"></label>
                    <label>Orden<input name="accords[{{ $accord->id }}][sort_order]" type="number" min="0" max="65535" value="{{ data_get($selection, 'sort_order', 0) }}"></label>
                    <label class="admin-relation-card__primary"><input name="primary_accord_id" type="radio" value="{{ $accord->id }}" @checked((int) $primaryAccordId === $accord->id)> Principal</label>
                </article>
            @endforeach
        </div>
        @error('accords')<small class="admin-field-error">{{ $message }}</small>@enderror
        @error('primary_accord_id')<small class="admin-field-error">{{ $message }}</small>@enderror
    </section>

    <section class="admin-form-section" aria-labelledby="perfume-notes-title">
        <div>
            <p class="eyebrow">Notas</p>
            <h2 id="perfume-notes-title">Piramide olfativa</h2>
        </div>
        <div class="admin-relation-grid">
            @foreach ($notes as $note)
                @php($selection = $noteSelections[$note->id] ?? [])
                <article class="admin-relation-card">
                    <label><input name="notes[{{ $note->id }}][selected]" type="checkbox" value="1" @checked(data_get($selection, 'selected'))> {{ $note->name }}</label>
                    <label>Etapa<select name="notes[{{ $note->id }}][stage]">@foreach (\App\Enums\OlfactoryStage::cases() as $stage)<option value="{{ $stage->value }}" @selected(data_get($selection, 'stage', 'top') === $stage->value)>{{ $stage->label() }}</option>@endforeach</select></label>
                    <label>Orden<input name="notes[{{ $note->id }}][sort_order]" type="number" min="0" max="65535" value="{{ data_get($selection, 'sort_order', 0) }}"></label>
                </article>
            @endforeach
        </div>
        @error('notes')<small class="admin-field-error">{{ $message }}</small>@enderror
    </section>

    <section class="admin-form-section" aria-labelledby="perfume-context-title">
        <div>
            <p class="eyebrow">Contexto</p>
            <h2 id="perfume-context-title">Recomendaciones</h2>
        </div>
        <div class="admin-taxonomy-grid">
            @foreach (['climate_ids' => ['Climas', $climates, $climateIds], 'season_ids' => ['Temporadas', $seasons, $seasonIds], 'occasion_ids' => ['Ocasiones', $occasions, $occasionIds]] as $field => [$label, $items, $selectedIds])
                <fieldset>
                    <legend>{{ $label }}</legend>
                    @foreach ($items as $item)<label><input name="{{ $field }}[]" type="checkbox" value="{{ $item->id }}" @checked(in_array($item->id, array_map('intval', $selectedIds), true))> {{ $item->name }}</label>@endforeach
                </fieldset>
            @endforeach
        </div>
        @error('climate_ids')<small class="admin-field-error">{{ $message }}</small>@enderror
        @error('season_ids')<small class="admin-field-error">{{ $message }}</small>@enderror
        @error('occasion_ids')<small class="admin-field-error">{{ $message }}</small>@enderror
    </section>

    <div class="admin-form__actions">
        <a class="admin-button admin-button--secondary" href="{{ route('admin.perfumes.index') }}">Cancelar</a>
        <button class="admin-button admin-button--primary" type="submit">{{ $perfume->exists ? 'Guardar cambios' : 'Crear perfume' }}</button>
    </div>
</form>
