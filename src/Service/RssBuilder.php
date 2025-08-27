<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\RssFeed;
use Twig\Environment;

class RssBuilder
{
    public function __construct(
        private readonly Environment $twig
    ) {
    }

    public function buildRss(RssFeed $feed): string
    {
        return $this->twig->render('rss.xml.twig', [
            'feed' => $feed,
        ]);
    }
}