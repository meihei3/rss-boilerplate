<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\ContentItem;
use PHPUnit\Framework\TestCase;

class ContentItemTest extends TestCase
{
    public function testCreateContentItem(): void
    {
        $pubDate = new \DateTimeImmutable('2023-12-01 10:00:00');
        
        $item = new ContentItem(
            title: 'Test Title',
            description: 'Test Description',
            link: 'https://example.com/test',
            pubDate: $pubDate,
            guid: 'test-guid',
            category: 'Test Category',
            author: 'Test Author'
        );

        $this->assertSame('Test Title', $item->title);
        $this->assertSame('Test Description', $item->description);
        $this->assertSame('https://example.com/test', $item->link);
        $this->assertSame($pubDate, $item->pubDate);
        $this->assertSame('test-guid', $item->guid);
        $this->assertSame('Test Category', $item->category);
        $this->assertSame('Test Author', $item->author);
    }

    public function testGetGuidWithCustomGuid(): void
    {
        $item = new ContentItem(
            title: 'Test',
            description: 'Test',
            link: 'https://example.com/test',
            pubDate: new \DateTimeImmutable(),
            guid: 'custom-guid'
        );

        $this->assertSame('custom-guid', $item->getGuid());
    }

    public function testGetGuidWithoutCustomGuid(): void
    {
        $item = new ContentItem(
            title: 'Test',
            description: 'Test',
            link: 'https://example.com/test',
            pubDate: new \DateTimeImmutable()
        );

        $this->assertSame('https://example.com/test', $item->getGuid());
    }
}