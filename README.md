# RSS Feed Generator Boilerplate

A generic and reusable boilerplate for creating RSS feeds from any content source or changelog.

## Features

- **Generic Content Source Support**: Easily configurable to work with any API or content source
- **Automatic RSS Generation**: Converts content to RSS format automatically
- **Symfony Framework**: Built on Symfony console components for reliability
- **Comprehensive Testing**: Includes PHPUnit test suite with code coverage
- **Easy Customization**: Template-based RSS generation using Twig
- **GitHub Pages Ready**: Can publish RSS feeds to GitHub Pages

## Requirements

- PHP 8.4 or higher
- Composer for dependency management

## Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd rss-boilerplate
```

2. Install dependencies:
```bash
composer install
```

3. Configure your content source:
```bash
cp .env .env.local
# Edit .env.local with your specific configuration
```

4. Generate RSS feeds:
```bash
php bin/console generate-rss
```

## Configuration

Edit the `.env` file or create `.env.local` to override settings:

- `CONTENT_SOURCE_URL`: The URL of your content source API
- `RSS_TITLE`: Title for your RSS feed
- `RSS_DESCRIPTION`: Description for your RSS feed
- `RSS_LINK`: Link to your main website

## Customization

### Adding New Content Sources

1. Create a new service in `src/Service/`
2. Implement content fetching logic
3. Register the service in `config/services.php`
4. Update the command to use your new service

### Customizing RSS Templates

Edit templates in the `templates/` directory to customize RSS output format.

## Testing

Run the test suite:
```bash
composer test
```

Run tests with coverage:
```bash
composer test-coverage
```

Check code style:
```bash
composer phpcs
```

Fix code style:
```bash
composer phpcbf
```

## Deployment

This boilerplate is designed to work with GitHub Actions for automatic deployment to GitHub Pages. The generated RSS feeds will be published in the `docs/` directory.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

## License

This project is proprietary software.