<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler;

final class ScenarioSchedulersMetadataPaths
{
    public const PATHS = [
        __DIR__ . '/RequestBody' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\ScenarioScheduler\\RequestBody',
        __DIR__ . '/ResponseBody' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\ScenarioScheduler\\ResponseBody',
        __DIR__ . '/ValueObject' => 'SixtyEightPublishers\\CrawlerClient\\Controller\\ScenarioScheduler\\ValueObject',
    ];

    private function __construct() {}
}
