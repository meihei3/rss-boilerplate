<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ContentItem;
use DateTimeImmutable;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class JsonContentFetcher implements ContentFetcherInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $contentSourceUrl
    ) {
    }

    public function fetchContent(): array
    {
        $response = $this->httpClient->request('GET', $this->contentSourceUrl);
        $data = $response->toArray();

        return array_map(self::createContentItem(...), $data);
    }

    private static function createContentItem(array $data): ContentItem
    {
        return new ContentItem(
            title: $data['title'] ?? 'Untitled',
            description: $data['description'] ?? $data['content'] ?? '',
            link: $data['link'] ?? $data['url'] ?? '',
            pubDate: match (isset($data['date'])) {
                true => new DateTimeImmutable($data['date']),
                false => new DateTimeImmutable()
            },
            guid: $data['guid'] ?? $data['id'] ?? null,
            category: $data['category'] ?? null,
            author: $data['author'] ?? null
        );
    }
}
