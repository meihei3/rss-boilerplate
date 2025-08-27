<?php

/**
 * Example: CSV File Content Fetcher
 * 
 * This example shows how to read content from a CSV file
 * instead of an API endpoint.
 */

declare(strict_types=1);

namespace App\Examples;

use App\Model\ContentItem;
use App\Service\ContentFetcherInterface;
use DateTimeImmutable;
use RuntimeException;

readonly class CsvContentFetcher implements ContentFetcherInterface
{
    public function __construct(
        private string $csvFilePath
    ) {
    }

    public function fetchContent(): array
    {
        $handle = $this->openCsvFile();
        
        try {
            // Skip header row
            fgetcsv($handle);
            
            $items = [];
            while (($row = fgetcsv($handle)) !== false) {
                $items[] = self::createContentItemFromRow($row);
            }
            
            return $items;
        } finally {
            fclose($handle);
        }
    }

    private function openCsvFile()
    {
        if (!file_exists($this->csvFilePath)) {
            throw new RuntimeException("CSV file not found: {$this->csvFilePath}");
        }

        $handle = fopen($this->csvFilePath, 'r');
        
        return match ($handle) {
            false => throw new RuntimeException("Cannot open CSV file: {$this->csvFilePath}"),
            default => $handle
        };
    }

    private static function createContentItemFromRow(array $row): ContentItem
    {
        // Expected CSV format: title, description, link, date, category, author
        return new ContentItem(
            title: $row[0] ?? 'Untitled',
            description: $row[1] ?? '',
            link: $row[2] ?? '',
            pubDate: new DateTimeImmutable($row[3] ?? 'now'),
            guid: null, // Will use link as GUID
            category: $row[4] ?? null,
            author: $row[5] ?? null
        );
    }
}

/**
 * Example CSV format:
 * 
 * title,description,link,date,category,author
 * "New Feature Release","Added user authentication","https://example.com/releases/1","2023-12-01 10:00:00","Feature","John Doe"
 * "Bug Fix","Fixed login issue","https://example.com/releases/2","2023-12-02 15:30:00","Bug Fix","Jane Smith"
 * 
 * To use this fetcher:
 * 
 * $services->set(CsvContentFetcher::class)
 *     ->args(['%kernel.project_dir%/data/content.csv']);
 * 
 * $services->alias(ContentFetcherInterface::class, CsvContentFetcher::class);
 */