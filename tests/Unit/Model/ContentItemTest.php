<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\ContentItem;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ContentItemTest extends TestCase
{
    #[Test]
    public function createContentItem(): void
    {
        $pubDate = new DateTimeImmutable('2023-12-01 10:00:00');

        $item = new ContentItem(
            title: 'Test Title',
            description: 'Test Description',
            link: 'https://example.com/test',
            pubDate: $pubDate,
            guid: 'test-guid',
            category: 'Test Category',
            author: 'Test Author'
        );

        self::assertSame('Test Title', $item->title);
        self::assertSame('Test Description', $item->description);
        self::assertSame('https://example.com/test', $item->link);
        self::assertSame($pubDate, $item->pubDate);
        self::assertSame('test-guid', $item->guid);
        self::assertSame('Test Category', $item->category);
        self::assertSame('Test Author', $item->author);
    }

    #[Test]
    public function getGuidWithCustomGuid(): void
    {
        $item = new ContentItem(
            title: 'Test',
            description: 'Test',
            link: 'https://example.com/test',
            pubDate: new DateTimeImmutable(),
            guid: 'custom-guid'
        );

        self::assertSame('custom-guid', $item->getGuid());
    }

    #[Test]
    public function getGuidWithoutCustomGuid(): void
    {
        $item = new ContentItem(
            title: 'Test',
            description: 'Test',
            link: 'https://example.com/test',
            pubDate: new DateTimeImmutable()
        );

        self::assertSame('https://example.com/test', $item->getGuid());
    }
}
