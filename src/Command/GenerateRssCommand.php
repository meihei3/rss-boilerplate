<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\RssFeed;
use App\Service\ContentFetcherInterface;
use App\Service\FileManager;
use App\Service\RssBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'generate-rss',
    description: 'Generate RSS feed from content source'
)]
class GenerateRssCommand extends Command
{
    public function __construct(
        private readonly ContentFetcherInterface $contentFetcher,
        private readonly RssBuilder $rssBuilder,
        private readonly FileManager $fileManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'title',
                't',
                InputOption::VALUE_REQUIRED,
                'RSS feed title',
                $_ENV['RSS_TITLE'] ?? 'Generic RSS Feed'
            )
            ->addOption(
                'description',
                'd',
                InputOption::VALUE_REQUIRED,
                'RSS feed description',
                $_ENV['RSS_DESCRIPTION'] ?? 'Generated RSS feed from content source'
            )
            ->addOption(
                'link',
                'l',
                InputOption::VALUE_REQUIRED,
                'RSS feed link',
                $_ENV['RSS_LINK'] ?? 'https://example.com'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output filename',
                'feed.xml'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $io->title('RSS Feed Generator');

            // Fetch content
            $io->section('Fetching content...');
            $contentItems = $this->contentFetcher->fetchContent();
            $io->success(sprintf('Fetched %d content items', count($contentItems)));

            // Create RSS feed
            $io->section('Generating RSS feed...');
            $feed = new RssFeed(
                title: $input->getOption('title'),
                description: $input->getOption('description'),
                link: $input->getOption('link'),
                items: $contentItems
            );

            // Build RSS XML
            $rssContent = $this->rssBuilder->buildRss($feed);

            // Save to file
            $filename = $input->getOption('output');
            $this->fileManager->saveContent($filename, $rssContent);
            $io->success(sprintf('RSS feed saved to %s', $filename));

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $io->error('Failed to generate RSS feed: ' . $exception->getMessage());
            return Command::FAILURE;
        }
    }
}
