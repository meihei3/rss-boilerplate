# Examples

This directory contains various examples of how to extend and customize the RSS Feed Generator boilerplate.

## Content Fetchers

### CustomApiContentFetcher
Shows how to create a content fetcher for a different API format, such as GitHub releases API.

**Features:**
- Custom authentication headers
- Data transformation from different API schema
- Error handling for API requests

**Usage:** Copy the class to your `src/Service/` directory and register it in `config/services.php`.

### CsvContentFetcher
Demonstrates reading content from a CSV file instead of an API.

**Features:**
- Local file reading
- CSV parsing with header row support
- Flexible column mapping

**Usage:** Copy the class to your `src/Service/` directory and create your CSV file in the specified format.

## Custom Templates

You can customize the RSS output by modifying `templates/rss.xml.twig` or creating additional templates for different feed formats.

### Example customizations:
- Add custom XML namespaces
- Include additional metadata fields
- Create multiple feed formats (Atom, JSON Feed, etc.)

## Environment Configuration

### Basic Configuration
```bash
# Content source
CONTENT_SOURCE_URL=https://your-api.com/endpoint

# RSS metadata
RSS_TITLE="Your Custom Feed Title"
RSS_DESCRIPTION="Description of your RSS feed"
RSS_LINK="https://your-website.com"
```

### Advanced Configuration
```bash
# Custom API authentication
API_KEY=your_secret_key
API_BASE_URL=https://api.github.com/repos/owner/repo

# Output customization
OUTPUT_DIRECTORY=custom-output-dir
RSS_LANGUAGE=en-US
RSS_IMAGE_URL=https://your-website.com/logo.png
```

## GitHub Actions Customization

### Scheduling
The default deployment workflow runs every hour. You can customize the schedule in `.github/workflows/deploy.yml`:

```yaml
on:
  schedule:
    - cron: '0 */6 * * *'  # Every 6 hours
    - cron: '0 0 * * *'    # Daily at midnight
```

### Environment Variables
Configure these in your repository settings:

**Secrets:**
- `CONTENT_SOURCE_URL`: Your API endpoint URL
- `API_KEY`: Authentication token if required

**Variables:**
- `RSS_TITLE`: Your feed title
- `RSS_DESCRIPTION`: Your feed description  
- `RSS_LINK`: Your website URL

## Testing Custom Implementations

When creating custom content fetchers, add corresponding unit tests:

```php
<?php
// tests/Unit/Service/CustomApiContentFetcherTest.php

namespace App\Tests\Unit\Service;

use App\Examples\CustomApiContentFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CustomApiContentFetcherTest extends TestCase
{
    public function testFetchContent(): void
    {
        $mockResponse = new MockResponse(json_encode([
            'releases' => [
                [
                    'version' => 'v1.0.0',
                    'name' => 'Initial Release',
                    'html_url' => 'https://github.com/example/repo/releases/tag/v1.0.0',
                    'published_at' => '2023-12-01T10:00:00Z'
                ]
            ]
        ]));

        $httpClient = new MockHttpClient($mockResponse);
        $fetcher = new CustomApiContentFetcher($httpClient, 'test-key', 'https://api.example.com');
        
        $items = $fetcher->fetchContent();
        
        $this->assertCount(1, $items);
        $this->assertSame('v1.0.0: Initial Release', $items[0]->title);
    }
}
```