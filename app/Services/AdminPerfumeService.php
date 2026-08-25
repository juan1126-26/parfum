<?php

namespace App\Services;

use App\Models\Perfume;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminPerfumeService
{
    public function create(array $data): Perfume
    {
        return DB::transaction(function () use ($data): Perfume {
            $perfume = Perfume::query()->create($this->attributes($data));

            $this->syncRelations($perfume, $data);

            return $perfume;
        });
    }

    public function update(Perfume $perfume, array $data): Perfume
    {
        DB::transaction(function () use ($perfume, $data): void {
            $perfume->update($this->attributes($data));
            $this->syncRelations($perfume, $data);
        });

        return $perfume;
    }

    private function syncRelations(Perfume $perfume, array $data): void
    {
        $perfume->accords()->sync($this->accords($data));
        $perfume->notes()->sync($this->notes($data));
        $perfume->climates()->sync($this->ids($data['climate_ids'] ?? []));
        $perfume->seasons()->sync($this->ids($data['season_ids'] ?? []));
        $perfume->occasions()->sync($this->ids($data['occasion_ids'] ?? []));
    }

    private function attributes(array $data): array
    {
        return Arr::only($data, [
            'brand_id',
            'category_id',
            'name',
            'slug',
            'short_description',
            'description',
            'editorial_story',
            'longevity_level',
            'projection_level',
            'intensity_level',
            'is_featured',
            'is_best_seller',
            'sort_order',
        ]);
    }

    private function accords(array $data): array
    {
        $primaryAccordId = (int) ($data['primary_accord_id'] ?? 0);

        return collect($data['accords'] ?? [])
            ->filter(fn (array $attributes): bool => filter_var($attributes['selected'] ?? false, FILTER_VALIDATE_BOOLEAN))
            ->mapWithKeys(fn (array $attributes, int|string $id): array => [
                $id => [
                    'intensity' => (int) $attributes['intensity'],
                    'sort_order' => (int) $attributes['sort_order'],
                    'is_primary' => (int) $id === $primaryAccordId,
                ],
            ])->all();
    }

    private function notes(array $data): array
    {
        return collect($data['notes'] ?? [])
            ->filter(fn (array $attributes): bool => filter_var($attributes['selected'] ?? false, FILTER_VALIDATE_BOOLEAN))
            ->mapWithKeys(fn (array $attributes, int|string $id): array => [
                $id => [
                    'stage' => $attributes['stage'],
                    'sort_order' => (int) $attributes['sort_order'],
                ],
            ])->all();
    }

    /** @return array<int, int> */
    private function ids(array $ids): array
    {
        return collect($ids)->map(fn (mixed $id): int => (int) $id)->all();
    }
}
