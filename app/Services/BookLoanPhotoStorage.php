<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Stores book loan photos privately (local disk, not the public disk) and
 * compresses them server-side so users don't need to worry about file size.
 */
class BookLoanPhotoStorage
{
    private const MAX_DIMENSION = 1600;
    private const JPEG_QUALITY = 78;

    public function store(UploadedFile $file): string
    {
        $image = Image::make($file->getRealPath());

        $image->orientate();

        if ($image->width() > self::MAX_DIMENSION || $image->height() > self::MAX_DIMENSION) {
            $image->resize(self::MAX_DIMENSION, self::MAX_DIMENSION, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $path = 'book-loans/'.Str::uuid()->toString().'.jpg';

        Storage::disk('local')->put($path, (string) $image->encode('jpg', self::JPEG_QUALITY));

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('local')->delete($path);
        }
    }
}
