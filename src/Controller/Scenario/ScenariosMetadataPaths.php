<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario;

final class ScenariosMetadataPaths
{
    public const PATHS = [
        __DIR__ . '/RequestBody' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\Scenario\\RequestBody',
        __DIR__ . '/ResponseBody' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\Scenario\\ResponseBody',
        __DIR__ . '/ValueObject' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\Scenario\\ValueObject',
    ];

    private function __construct() {}
}
