<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileStorageService
{
    public function storeFile($file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('profile_images', $fileName, 'public');
        return Storage::url($filePath);
    }
}
