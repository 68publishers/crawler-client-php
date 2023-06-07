<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common;

final class CommonMetadataPaths
{
    public const PATHS = [
        __DIR__ . '/ResponseBody' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\Common\\ResponseBody',
        __DIR__ . '/ValueObject' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\Common\\ValueObject',
    ];

    private function __construct() {}
}
