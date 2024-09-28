<?php

namespace App\Services\UploadImage;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageService
{
    /**
     * Armazena um arquivo e retorna sua URL.
     *
     * @param string $filename
     * @param string $content
     * @return string
     */
    public function storeImage(string $disk, UploadedFile $image): string
    {
        $path = Storage::disk($disk)->putFile('', $image);

        return Storage::disk($disk)->url($path);
    }

    public function deleteImage(string $disk, string $imagePath): bool
    {
        if (Storage::disk($disk)->exists($imagePath)) {
            return Storage::disk($disk)->delete($imagePath);
        }

        return false;
    }

        /**
     * Verifica se uma imagem existe pela URL.
     *
     * @param string $disk
     * @param string $imageUrl
     * @return bool
     */
    public function imageExists(string $disk, string $imageUrl): bool
    {
        $path = str_replace(Storage::disk($disk)->url(''), '', $imageUrl);

        return Storage::disk($disk)->exists($path);
    }
}
