<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload une image d'avatar
     */
    public function uploadAvatar(UploadedFile $file, $oldAvatar = null): string
    {
        // Supprimer l'ancienne image si elle existe
        if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
            Storage::disk('public')->delete($oldAvatar);
        }

        // Générer un nom unique pour l'image
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Stocker l'image
        $file->storeAs('avatars', $fileName, 'public');

        return 'avatars/' . $fileName;
    }

    /**
     * Supprimer une image d'avatar
     */
    public function deleteAvatar($avatarPath): bool
    {
        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            return Storage::disk('public')->delete($avatarPath);
        }

        return false;
    }

        /**
     * Obtenir l'URL d'une image
     */
    public function getImageUrl($path, $defaultImage = null): string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return $defaultImage ? asset($defaultImage) : asset('images/default-avatar.png');
    }

    /**
     * Upload un thumbnail de cours
     */
    public function uploadThumbnail(UploadedFile $file, $oldThumbnail = null): string
    {
        // Supprimer l'ancien thumbnail si il existe
        if ($oldThumbnail && Storage::disk('public')->exists($oldThumbnail)) {
            Storage::disk('public')->delete($oldThumbnail);
        }

        // Générer un nom unique pour l'image
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Stocker l'image
        $file->storeAs('thumbnails', $fileName, 'public');

        return 'thumbnails/' . $fileName;
    }

    /**
     * Supprimer un thumbnail de cours
     */
    public function deleteThumbnail($thumbnailPath): bool
    {
        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::disk('public')->delete($thumbnailPath);
        }

        return false;
    }
}
