<?php

namespace Gnarhard\Zipper;

use ZipArchive;
use Illuminate\Support\Facades\Storage;

class Zipper
{
    public function create(string $source, string $destination, string $disk = 'local'): bool
    {
        if (!extension_loaded('zip')) {
            return false;
        }

        if ($source == '' || $destination == '') {
            return false;
        }

        // Get all files and directories recursively
        $files = Storage::disk($disk)->allFiles($source);
        $directories = Storage::disk($disk)->allDirectories($source);

        if (empty($files)) {
            return false;
        }

        $zip = new ZipArchive();

        if ($zip->open(Storage::disk($disk)->path($destination), ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        // Add directories to the ZIP file
        foreach ($directories as $dir) {
            $zip->addEmptyDir($dir);
        }

        // Add files to the ZIP file
        foreach ($files as $file) {
            if (strpos($file, '.DS_Store') !== false) {
                continue;
            }

            $fileContent = Storage::disk($disk)->get($file);
            $relativePath = str_replace($source, '', $file);
            $zip->addFromString($relativePath, $fileContent);
        }

        // Close the ZIP file
        return $zip->close();
    }
}
