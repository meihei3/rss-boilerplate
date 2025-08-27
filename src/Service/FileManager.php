<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileManager
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $publicDirectory
    ) {
    }

    public function saveContent(string $filename, string $content): void
    {
        $this->filesystem->mkdir($this->publicDirectory);
        $filePath = $this->publicDirectory . '/' . $filename;
        $this->filesystem->dumpFile($filePath, $content);
    }

    public function loadContent(string $filename): ?string
    {
        $filePath = $this->publicDirectory . '/' . $filename;
        
        if (!$this->filesystem->exists($filePath)) {
            return null;
        }

        return file_get_contents($filePath);
    }
}