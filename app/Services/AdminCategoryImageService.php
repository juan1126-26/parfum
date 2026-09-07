<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class AdminCategoryImageService
{
    private const WIDTH = 1200;

    private const HEIGHT = 800;

    public function store(UploadedFile $file): string
    {
        $source = @imagecreatefromstring($file->get());

        if ($source === false) {
            throw new RuntimeException('No fue posible procesar la imagen seleccionada.');
        }

        $target = imagecreatetruecolor(self::WIDTH, self::HEIGHT);

        try {
            imagealphablending($target, false);
            imagesavealpha($target, true);
            imagefill($target, 0, 0, imagecolorallocatealpha($target, 0, 0, 0, 127));

            $this->copyResampled($source, $target);

            ob_start();
            $wasEncoded = imagewebp($target, null, 85);
            $contents = ob_get_clean();

            if (! $wasEncoded || $contents === false) {
                throw new RuntimeException('No fue posible convertir la imagen a WebP.');
            }

            $path = 'categories/'.Str::uuid().'.webp';
            Storage::disk('public')->put($path, $contents);

            return $path;
        } finally {
            imagedestroy($source);
            imagedestroy($target);
        }
    }

    public function delete(?string $path): void
    {
        if ($path !== null) {
            Storage::disk('public')->delete($path);
        }
    }

    private function copyResampled(\GdImage $source, \GdImage $target): void
    {
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = self::WIDTH / self::HEIGHT;

        if ($sourceRatio > $targetRatio) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) round($sourceHeight * $targetRatio);
            $sourceX = (int) floor(($sourceWidth - $cropWidth) / 2);
            $sourceY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($sourceWidth / $targetRatio);
            $sourceX = 0;
            $sourceY = (int) floor(($sourceHeight - $cropHeight) / 2);
        }

        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            self::WIDTH,
            self::HEIGHT,
            $cropWidth,
            $cropHeight,
        );
    }
}
