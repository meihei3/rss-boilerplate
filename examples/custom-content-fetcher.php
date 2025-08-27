<?php

/**
 * Example: Custom Content Fetcher Implementation
 * 
 * This example shows how to create a custom content fetcher
 * for a different data source or API format.
 */

declare(strict_types=1);

namespace App\Examples;

use App\Model\ContentItem;
use App\Service\ContentFetcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomApiContentFetcher implements ContentFetcherInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $apiKey,
        private readonly string $baseUrl
    ) {
    }

    public function fetchContent(): array
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . '/api/releases', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ],
        ]);

        $data = $response->toArray();
        
        return array_map([$this, 'transformToContentItem'], $data['releases'] ?? []);
    }

    private function transformToContentItem(array $release): ContentItem
    {
        return new ContentItem(
            title: $release['version'] . ': ' . $release['name'],
            description: $release['changelog'] ?? $release['notes'] ?? '',
            link: $release['html_url'] ?? $release['url'] ?? '',
            pubDate: new \DateTimeImmutable($release['published_at'] ?? $release['created_at'] ?? 'now'),
            guid: $release['tag_name'] ?? $release['id'] ?? null,
            category: $release['prerelease'] ? 'Pre-release' : 'Release',
            author: $release['author']['login'] ?? null
        );
    }
}

/**
 * To use this custom fetcher:
 * 
 * 1. Register it in config/services.php:
 * 
 * $services->set(CustomApiContentFetcher::class)
 *     ->args([
 *         service(HttpClientInterface::class),
 *         '%env(API_KEY)%',
 *         '%env(API_BASE_URL)%'
 *     ]);
 * 
 * $services->alias(ContentFetcherInterface::class, CustomApiContentFetcher::class);
 * 
 * 2. Add environment variables to .env:
 * 
 * API_KEY=your_api_key_here
 * API_BASE_URL=https://api.github.com/repos/owner/repo
 */