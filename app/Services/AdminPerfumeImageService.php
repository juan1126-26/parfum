<?php

namespace App\Services;

use App\Models\Perfume;
use App\Models\PerfumeImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPerfumeImageService
{
    public function store(Perfume $perfume, UploadedFile $file, ?string $altText): PerfumeImage
    {
        $storedPath = $file->store("perfumes/{$perfume->id}", 'public');

        try {
            return DB::transaction(function () use ($perfume, $storedPath, $altText): PerfumeImage {
                $isFirstImage = ! $perfume->images()->exists();
                $image = $perfume->images()->create([
                    'path' => "storage/{$storedPath}",
                    'alt_text' => $altText,
                    'is_cover' => false,
                    'sort_order' => ((int) $perfume->images()->max('sort_order')) + 1,
                ]);

                if ($isFirstImage) {
                    $this->setCover($perfume, $image);
                }

                return $image;
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($storedPath);

            throw $exception;
        }
    }

    public function update(PerfumeImage $image, array $data): void
    {
        $image->update($data);
    }

    public function setCover(Perfume $perfume, PerfumeImage $image): void
    {
        DB::transaction(function () use ($perfume, $image): void {
            $perfume->images()->whereKeyNot($image->getKey())->update(['is_cover' => false]);
            $image->update(['is_cover' => true]);
        });
    }

    public function delete(PerfumeImage $image): void
    {
        $path = $this->storagePath($image->path);

        DB::transaction(function () use ($image): void {
            $perfume = $image->perfume;
            $wasCover = $image->is_cover;

            $image->delete();

            if ($wasCover && ($nextImage = $perfume->images()->first())) {
                $nextImage->update(['is_cover' => true]);
            }
        });

        if ($path !== null) {
            Storage::disk('public')->delete($path);
        }
    }

    private function storagePath(string $path): ?string
    {
        return Str::startsWith($path, 'storage/') ? Str::after($path, 'storage/') : null;
    }
}
