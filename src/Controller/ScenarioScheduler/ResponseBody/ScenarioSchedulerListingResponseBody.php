<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\AbstractListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValueObject\ScenarioSchedulerListingItem;

final class ScenarioSchedulerListingResponseBody extends AbstractListingResponseBody
{
    /** @var array<int, ScenarioSchedulerListingItem> */
    public array $data = [];

    /**
     * @param array<int, ScenarioSchedulerListingItem> $data
     */
    public function __construct(int $totalCount, ?ListingNavigation $next, ?ListingNavigation $previous, array $data)
    {
        parent::__construct($totalCount, $next, $previous);

        $this->data = $data;
    }
}
