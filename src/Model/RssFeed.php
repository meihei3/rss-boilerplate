<?php

declare(strict_types=1);

namespace App\Model;

use DateTimeInterface;
use DateTimeImmutable;

readonly class RssFeed
{
    /**
     * @param ContentItem[] $items
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $link,
        public string $language = 'en',
        public ?string $imageUrl = null,
        public array $items = []
    ) {
    }

    public function getLastBuildDate(): DateTimeInterface
    {
        return match (empty($this->items)) {
            true => new DateTimeImmutable(),
            false => max(array_map(
                static fn(ContentItem $item): DateTimeInterface => $item->pubDate,
                $this->items
            ))
        };
    }
}
