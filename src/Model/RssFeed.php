<?php

declare(strict_types=1);

namespace App\Model;

class RssFeed
{
    /**
     * @param ContentItem[] $items
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $link,
        public readonly string $language = 'en',
        public readonly ?string $imageUrl = null,
        public readonly array $items = []
    ) {
    }

    public function getLastBuildDate(): \DateTimeInterface
    {
        if (empty($this->items)) {
            return new \DateTimeImmutable();
        }

        return max(array_map(fn (ContentItem $item) => $item->pubDate, $this->items));
    }
}