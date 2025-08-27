<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ContentItem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonContentFetcher implements ContentFetcherInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $contentSourceUrl
    ) {
    }

    public function fetchContent(): array
    {
        $response = $this->httpClient->request('GET', $this->contentSourceUrl);
        $data = $response->toArray();

        return array_map([$this, 'createContentItem'], $data);
    }

    private function createContentItem(array $data): ContentItem
    {
        return new ContentItem(
            title: $data['title'] ?? 'Untitled',
            description: $data['description'] ?? $data['content'] ?? '',
            link: $data['link'] ?? $data['url'] ?? '',
            pubDate: isset($data['date']) ? new \DateTimeImmutable($data['date']) : new \DateTimeImmutable(),
            guid: $data['guid'] ?? $data['id'] ?? null,
            category: $data['category'] ?? null,
            author: $data['author'] ?? null
        );
    }
}
