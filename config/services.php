<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('content_source_url', '%env(string:default:content_source_default:CONTENT_SOURCE_URL)%');
    $parameters->set('content_source_default', 'https://dummyjson.com/products');
    $parameters->set('public_directory', '%kernel.project_dir%/docs/');

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->bind('$contentSourceUrl', '%content_source_url%')
        ->bind('$publicDirectory', '%public_directory%');

    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}');

    // Service aliases
    $services->alias(App\Service\ContentFetcherInterface::class, App\Service\JsonContentFetcher::class);
};