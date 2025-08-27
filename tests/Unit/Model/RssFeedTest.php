<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\ContentItem;
use App\Model\RssFeed;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class RssFeedTest extends TestCase
{
    #[Test]
    public function createRssFeed(): void
    {
        $feed = new RssFeed(
            title: 'Test Feed',
            description: 'Test Description',
            link: 'https://example.com',
            language: 'en',
            items: []
        );

        self::assertSame('Test Feed', $feed->title);
        self::assertSame('Test Description', $feed->description);
        self::assertSame('https://example.com', $feed->link);
        self::assertSame('en', $feed->language);
        self::assertEmpty($feed->items);
    }

    #[Test]
    public function getLastBuildDateWithItems(): void
    {
        $date1 = new DateTimeImmutable('2023-12-01 10:00:00');
        $date2 = new DateTimeImmutable('2023-12-02 10:00:00');
        $date3 = new DateTimeImmutable('2023-11-30 10:00:00');

        $items = [
            new ContentItem('Title 1', 'Desc 1', 'https://example.com/1', $date1),
            new ContentItem('Title 2', 'Desc 2', 'https://example.com/2', $date2),
            new ContentItem('Title 3', 'Desc 3', 'https://example.com/3', $date3),
        ];

        $feed = new RssFeed(
            title: 'Test Feed',
            description: 'Test Description',
            link: 'https://example.com',
            items: $items
        );

        self::assertEquals($date2, $feed->getLastBuildDate());
    }

    #[Test]
    public function getLastBuildDateWithoutItems(): void
    {
        $feed = new RssFeed(
            title: 'Test Feed',
            description: 'Test Description',
            link: 'https://example.com',
            items: []
        );

        $lastBuildDate = $feed->getLastBuildDate();
        self::assertInstanceOf(DateTimeInterface::class, $lastBuildDate);
    }
}
