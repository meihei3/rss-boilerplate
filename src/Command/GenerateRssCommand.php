<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\ContentItem;
use App\Model\RssFeed;
use App\Service\ContentFetcherInterface;
use App\Service\FileManager;
use App\Service\RssBuilder;
use Exception;
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
final class GenerateRssCommand extends Command
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
        $this->addOptions([
            ['title', 't', InputOption::VALUE_REQUIRED, 'RSS feed title', $_ENV['RSS_TITLE'] ?? 'Generic RSS Feed'],
            [
                'description', 'd', InputOption::VALUE_REQUIRED, 'RSS feed description',
                $_ENV['RSS_DESCRIPTION'] ?? 'Generated RSS feed from content source'
            ],
            ['link', 'l', InputOption::VALUE_REQUIRED, 'RSS feed link', $_ENV['RSS_LINK'] ?? 'https://example.com'],
            ['output', 'o', InputOption::VALUE_REQUIRED, 'Output filename', 'feed.xml'],
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        return $this->tryExecute($io, $input);
    }

    private function tryExecute(SymfonyStyle $io, InputInterface $input): int
    {
        try {
            $io->title('RSS Feed Generator');

            $contentItems = $this->fetchContent($io);
            $feed = $this->createFeed($input, $contentItems);
            $this->saveFeed($io, $input, $feed);

            return Command::SUCCESS;
        } catch (Exception $exception) {
            $io->error('Failed to generate RSS feed: ' . $exception->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @return ContentItem[]
     */
    private function fetchContent(SymfonyStyle $io): array
    {
        $io->section('Fetching content...');
        $contentItems = $this->contentFetcher->fetchContent();
        $io->success(sprintf('Fetched %d content items', count($contentItems)));

        return $contentItems;
    }

    /**
     * @param ContentItem[] $contentItems
     */
    private function createFeed(InputInterface $input, array $contentItems): RssFeed
    {
        return new RssFeed(
            title: $input->getOption('title'),
            description: $input->getOption('description'),
            link: $input->getOption('link'),
            items: $contentItems
        );
    }

    private function saveFeed(SymfonyStyle $io, InputInterface $input, RssFeed $feed): void
    {
        $io->section('Generating RSS feed...');
        $rssContent = $this->rssBuilder->buildRss($feed);
        $filename = $input->getOption('output');
        $this->fileManager->saveContent($filename, $rssContent);
        $io->success(sprintf('RSS feed saved to %s', $filename));
    }

    /**
     * @param array<array{string, string, int, string, string}> $options
     */
    private function addOptions(array $options): void
    {
        foreach ($options as [$name, $shortcut, $mode, $description, $default]) {
            $this->addOption($name, $shortcut, $mode, $description, $default);
        }
    }
}
