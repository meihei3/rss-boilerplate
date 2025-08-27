<?php

declare(strict_types=1);

namespace App\Model;

class ContentItem
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $link,
        public readonly \DateTimeInterface $pubDate,
        public readonly ?string $guid = null,
        public readonly ?string $category = null,
        public readonly ?string $author = null
    ) {
    }

    public function getGuid(): string
    {
        return $this->guid ?? $this->link;
    }
}
