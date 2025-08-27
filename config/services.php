<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();

// Parameters
$containerBuilder->setParameter('content_source_url', $_ENV['CONTENT_SOURCE_URL'] ?? 'https://api.example.com/changelog');
$containerBuilder->setParameter('public_directory', __DIR__ . '/../docs/');

// HTTP Client
$containerBuilder->register(\Symfony\Component\HttpClient\CurlHttpClient::class);
$containerBuilder->setAlias(\Symfony\Contracts\HttpClient\HttpClientInterface::class, \Symfony\Component\HttpClient\CurlHttpClient::class);

// Filesystem
$containerBuilder->register(\Symfony\Component\Filesystem\Filesystem::class);

// Twig
$containerBuilder->register(\Twig\Loader\FilesystemLoader::class)
    ->setArguments([__DIR__ . '/../templates']);

$containerBuilder->register(\Twig\Environment::class)
    ->setArguments([new Reference(\Twig\Loader\FilesystemLoader::class)]);

// Content Fetcher
$containerBuilder->register(\App\Service\JsonContentFetcher::class)
    ->setArguments([
        new Reference(\Symfony\Contracts\HttpClient\HttpClientInterface::class),
        '%content_source_url%'
    ]);

$containerBuilder->setAlias(\App\Service\ContentFetcherInterface::class, \App\Service\JsonContentFetcher::class);

// RSS Builder
$containerBuilder->register(\App\Service\RssBuilder::class)
    ->setArguments([new Reference(\Twig\Environment::class)]);

// File Manager
$containerBuilder->register(\App\Service\FileManager::class)
    ->setArguments([
        new Reference(\Symfony\Component\Filesystem\Filesystem::class),
        '%public_directory%'
    ]);

// Commands
$containerBuilder->register(\App\Command\GenerateRssCommand::class)
    ->setArguments([
        new Reference(\App\Service\ContentFetcherInterface::class),
        new Reference(\App\Service\RssBuilder::class),
        new Reference(\App\Service\FileManager::class)
    ])
    ->setPublic(true)
    ->addTag('console.command');

return $containerBuilder;