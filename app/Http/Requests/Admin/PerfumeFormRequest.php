<?php

namespace App\Http\Requests\Admin;

use App\Enums\OlfactoryStage;
use App\Enums\PerformanceLevel;
use App\Models\Accord;
use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

abstract class PerfumeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'integer', Rule::exists('brands', 'id')->where('is_active', true)],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', $this->slugRule()],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'editorial_story' => ['nullable', 'string'],
            'longevity_level' => ['nullable', Rule::enum(PerformanceLevel::class)],
            'projection_level' => ['nullable', Rule::enum(PerformanceLevel::class)],
            'intensity_level' => ['nullable', Rule::enum(PerformanceLevel::class)],
            'is_featured' => ['required', 'boolean'],
            'is_best_seller' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'accords' => ['nullable', 'array'],
            'accords.*.selected' => ['nullable', 'boolean'],
            'accords.*.intensity' => ['nullable', 'integer', 'between:0,100'],
            'accords.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'primary_accord_id' => ['nullable', 'integer'],
            'notes' => ['nullable', 'array'],
            'notes.*.selected' => ['nullable', 'boolean'],
            'notes.*.stage' => ['nullable', Rule::enum(OlfactoryStage::class)],
            'notes.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'climate_ids' => ['nullable', 'array'],
            'climate_ids.*' => ['integer', 'distinct', Rule::exists('climates', 'id')->where('is_active', true)],
            'season_ids' => ['nullable', 'array'],
            'season_ids.*' => ['integer', 'distinct', Rule::exists('seasons', 'id')->where('is_active', true)],
            'occasion_ids' => ['nullable', 'array'],
            'occasion_ids.*' => ['integer', 'distinct', Rule::exists('occasions', 'id')->where('is_active', true)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $accordIds = $this->selectedIds('accords');
                $noteIds = $this->selectedIds('notes');

                $this->validateActiveIds($validator, $accordIds, Accord::class, 'accords');
                $this->validateActiveIds($validator, $noteIds, Note::class, 'notes');
                $this->validateSelectedAttributes($validator, 'accords', ['intensity', 'sort_order']);
                $this->validateSelectedAttributes($validator, 'notes', ['stage', 'sort_order']);

                $primaryAccordId = $this->integer('primary_accord_id');

                if ($primaryAccordId !== 0 && ! in_array($primaryAccordId, $accordIds, true)) {
                    $validator->errors()->add('primary_accord_id', 'El acorde principal debe estar seleccionado.');
                }
            },
        ];
    }

    /** @return array<int, int> */
    private function selectedIds(string $relation): array
    {
        return collect($this->input($relation, []))
            ->filter(fn (mixed $attributes): bool => filter_var(data_get($attributes, 'selected'), FILTER_VALIDATE_BOOLEAN))
            ->keys()
            ->filter(fn (mixed $id): bool => filter_var($id, FILTER_VALIDATE_INT) !== false)
            ->map(fn (mixed $id): int => (int) $id)
            ->values()
            ->all();
    }

    /** @param class-string<Accord|Note> $model */
    private function validateActiveIds(Validator $validator, array $ids, string $model, string $attribute): void
    {
        if ($ids === []) {
            return;
        }

        if ($model::query()->active()->whereKey($ids)->count() !== count($ids)) {
            $validator->errors()->add($attribute, 'Una de las selecciones no esta disponible.');
        }
    }

    /** @param array<int, string> $attributes */
    private function validateSelectedAttributes(Validator $validator, string $relation, array $attributes): void
    {
        foreach ($this->input($relation, []) as $id => $selection) {
            if (! filter_var(data_get($selection, 'selected'), FILTER_VALIDATE_BOOLEAN)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                if (! array_key_exists($attribute, $selection)) {
                    $validator->errors()->add("{$relation}.{$id}.{$attribute}", 'Completa este dato para la seleccion elegida.');
                }
            }
        }
    }

    abstract protected function slugRule(): mixed;
}
