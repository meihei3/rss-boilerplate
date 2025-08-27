# Contributing to RSS Feed Generator Boilerplate

## Development Setup

1. **Clone and setup:**
```bash
git clone <your-repo-url>
cd rss-boilerplate
composer install
```

2. **Configure environment:**
```bash
cp .env .env.local
# Edit .env.local with your specific settings
```

3. **Run tests:**
```bash
composer test
composer phpcs  # Code style check
composer phpcbf # Code style fix
```

## Architecture Overview

### Core Components

- **Models** (`src/Model/`): Data structures for ContentItem and RssFeed
- **Services** (`src/Service/`): Business logic for content fetching, RSS building, and file management
- **Commands** (`src/Command/`): Console commands for CLI execution
- **Templates** (`templates/`): Twig templates for RSS XML generation

### Key Interfaces

- `ContentFetcherInterface`: Contract for content retrieval implementations
- Dependency injection managed through Symfony DI container

## Creating Custom Content Fetchers

1. **Implement the interface:**
```php
<?php
namespace App\Service;

use App\Model\ContentItem;
use App\Service\ContentFetcherInterface;

class YourCustomFetcher implements ContentFetcherInterface
{
    public function fetchContent(): array
    {
        // Your implementation
        return $contentItems;
    }
}
```

2. **Register in services:**
```php
// config/services.php
$services->alias(\App\Service\ContentFetcherInterface::class, \App\Service\YourCustomFetcher::class);
```

3. **Add tests:**
```php
// tests/Unit/Service/YourCustomFetcherTest.php
class YourCustomFetcherTest extends TestCase
{
    public function testFetchContent(): void
    {
        // Test implementation
    }
}
```

## Code Standards

- **PHP Version**: 8.4+
- **Code Style**: PSR-12
- **Testing**: PHPUnit with high coverage
- **Documentation**: PHPDoc for all public methods

### Pre-commit Checklist

- [ ] All tests pass (`composer test`)
- [ ] Code style follows PSR-12 (`composer phpcs`)
- [ ] New functionality is tested
- [ ] Documentation updated if needed

## Deployment

### Local Testing
```bash
# Test RSS generation
php bin/console generate-rss --title="Test Feed" --description="Test Description" --link="https://example.com"

# Check generated file
cat docs/feed.xml
```

### GitHub Actions

The project includes two workflows:

1. **Test workflow** (`.github/workflows/test.yml`):
   - Runs on push/PR
   - Tests code quality and functionality

2. **Deploy workflow** (`.github/workflows/deploy.yml`):
   - Scheduled RSS generation
   - Deploys to GitHub Pages
   - Configurable via repository secrets/variables

### Required Repository Configuration

**Secrets:**
- `CONTENT_SOURCE_URL`: Your content API endpoint

**Variables:**
- `RSS_TITLE`: Your feed title
- `RSS_DESCRIPTION`: Your feed description
- `RSS_LINK`: Your website URL

**Pages:**
- Enable GitHub Pages in repository settings
- Set source to "GitHub Actions"

## Common Customizations

### 1. Multiple Feed Sources
Create different fetchers and commands for different content sources.

### 2. Custom RSS Fields
Extend the ContentItem model and update the Twig template.

### 3. Different Output Formats
Create additional templates for Atom, JSON Feed, etc.

### 4. Content Filtering
Add filtering logic in your content fetcher implementation.

### 5. Caching
Implement caching in the FileManager service for better performance.

## Troubleshooting

### Common Issues

1. **Command not found**: Ensure the command is registered in `config/services.php`
2. **Template not found**: Check template path in Twig configuration
3. **HTTP client errors**: Verify content source URL and authentication
4. **File permission errors**: Check write permissions for output directory

### Debug Mode

Enable debug mode in `.env`:
```
APP_ENV=dev
```

Add error logging to your custom implementations for easier debugging.

## Pull Request Guidelines

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Make your changes with tests
3. Run the test suite: `composer test && composer phpcs`
4. Submit PR with clear description of changes
5. Ensure all CI checks pass

## Support

For questions or issues:
1. Check existing issues in the repository
2. Review the examples in the `examples/` directory
3. Create a new issue with detailed description and steps to reproduce