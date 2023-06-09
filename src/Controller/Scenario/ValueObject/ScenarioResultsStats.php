<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class ScenarioResultsStats
{
    public int $visitedUrls;

    public int $data;

    public int $cookies;

    public int $screenshots;

    public function __construct(int $visitedUrls, int $data, int $cookies, int $screenshots)
    {
        $this->visitedUrls = $visitedUrls;
        $this->data = $data;
        $this->cookies = $cookies;
        $this->screenshots = $screenshots;
    }
}
