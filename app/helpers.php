<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('get_image_url')) {
    /**
     * Get the proper URL for an image stored in the application
     * Handles both storage paths and base64/external URLs
     *
     * @param string|null $imagePath
     * @return string|null
     */
    function get_image_url(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }

        // Check if it's already a full URL (base64 or external)
        if (str_starts_with($imagePath, 'data:') || str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }

        // Otherwise, use Storage::url
        return Storage::url($imagePath);
    }
}

if (!function_exists('get_gallery_urls')) {
    /**
     * Get URLs for all gallery images
     *
     * @param array|null $galleryImages
     * @return array
     */
    function get_gallery_urls(?array $galleryImages): array
    {
        if (!$galleryImages || !is_array($galleryImages)) {
            return [];
        }

        return array_map(function ($image) {
            return get_image_url($image);
        }, $galleryImages);
    }
}
