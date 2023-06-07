<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class ScenarioResults
{
    /** @var array<int, VisitedUrl> */
    public array $visitedUrls;

    /** @var array<int, Data> */
    public array $data;

    /** @var array<int, Cookie> */
    public array $cookies;

    /** @var array<int, Screenshot> */
    public array $screenshots;
}
