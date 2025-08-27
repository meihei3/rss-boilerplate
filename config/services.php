<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('content_source_url', '%env(string:CONTENT_SOURCE_URL)%');
    $parameters->set('public_directory', '%kernel.project_dir%/docs/');

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', '../src/');

    $services->bind('$contentSourceUrl', '%content_source_url%');
    $services->bind('$publicDirectory', '%public_directory%');

    // HTTP Client
    $services->set(\Symfony\Component\HttpClient\CurlHttpClient::class);
    
    // Filesystem
    $services->set(\Symfony\Component\Filesystem\Filesystem::class);

    // Twig Configuration
    $services->set(\Twig\Loader\FilesystemLoader::class)
        ->args([['%kernel.project_dir%/templates']]);
    
    $services->set(\Twig\Environment::class)
        ->args([service(\Twig\Loader\FilesystemLoader::class)]);

    // Service Aliases
    $services->alias(\App\Service\ContentFetcherInterface::class, \App\Service\JsonContentFetcher::class);
    $services->alias(\Symfony\Contracts\HttpClient\HttpClientInterface::class, \Symfony\Component\HttpClient\CurlHttpClient::class);
};