<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function MAX_SIZE(): int
    {
        return 5120;
    }

    public static function VALIDATION_RULES(bool $required = false): string
    {
        $prefix = $required ? 'required' : 'nullable';

        return $prefix.'|image|mimes:jpeg,png,jpg,gif,webp|max:'.static::MAX_SIZE();
    }

    public static function uploadAndConvertToWebp(UploadedFile $file, string $path = 'thumbnails'): string
    {
        $filename = Str::random(40).'.webp';
        $fullPath = $path.'/'.$filename;

        $image = \imagecreatefromstring(\file_get_contents($file->getRealPath()));

        \ob_start();
        \imagewebp($image, null, 80);
        $webpData = \ob_get_clean();
        \imagedestroy($image);

        Storage::disk('public')->put($fullPath, $webpData);

        return $fullPath;
    }
}
