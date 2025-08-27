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

        return array_map(fn(array $item): ContentItem => self::createContentItem($item), $data);
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function createContentItem(array $data): ContentItem
    {
        return new ContentItem(
            title: (string) ($data['title'] ?? 'Untitled'),
            description: (string) ($data['description'] ?? $data['content'] ?? ''),
            link: (string) ($data['link'] ?? $data['url'] ?? ''),
            pubDate: match (isset($data['date'])) {
                true => new DateTimeImmutable((string) $data['date']),
                false => new DateTimeImmutable()
            },
            guid: isset($data['guid']) ? (string) $data['guid'] : (isset($data['id']) ? (string) $data['id'] : null),
            category: isset($data['category']) ? (string) $data['category'] : null,
            author: isset($data['author']) ? (string) $data['author'] : null
        );
    }
}
