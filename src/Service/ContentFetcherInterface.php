<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ContentItem;

interface ContentFetcherInterface
{
    /**
     * @return ContentItem[]
     */
    public function fetchContent(): array;
}