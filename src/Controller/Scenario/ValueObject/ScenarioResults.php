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

    /**
     * @param array<int, VisitedUrl> $visitedUrls
     * @param array<int, Data>       $data
     * @param array<int, Cookie>     $cookies
     * @param array<int, Screenshot> $screenshots
     */
    public function __construct(array $visitedUrls, array $data, array $cookies, array $screenshots)
    {
        $this->visitedUrls = $visitedUrls;
        $this->data = $data;
        $this->cookies = $cookies;
        $this->screenshots = $screenshots;
    }
}
