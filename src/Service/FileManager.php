<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

readonly class FileManager
{
    public function __construct(
        private Filesystem $filesystem,
        private string $publicDirectory
    ) {
    }

    public function saveContent(string $filename, string $content): void
    {
        $this->filesystem->mkdir($this->publicDirectory);
        $filePath = $this->getFilePath($filename);
        $this->filesystem->dumpFile($filePath, $content);
    }

    public function loadContent(string $filename): ?string
    {
        $filePath = $this->getFilePath($filename);

        return match ($this->filesystem->exists($filePath)) {
            true => file_get_contents($filePath) ?: null,
            false => null
        };
    }

    private function getFilePath(string $filename): string
    {
        return sprintf('%s/%s', $this->publicDirectory, $filename);
    }
}
