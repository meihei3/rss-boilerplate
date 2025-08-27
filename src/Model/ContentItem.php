<?php

declare(strict_types=1);

namespace App\Model;

use DateTimeInterface;

readonly class ContentItem
{
    public function __construct(
        public string $title,
        public string $description,
        public string $link,
        public DateTimeInterface $pubDate,
        public ?string $guid = null,
        public ?string $category = null,
        public ?string $author = null
    ) {
    }

    public function getGuid(): string
    {
        return $this->guid ?? $this->link;
    }
}
