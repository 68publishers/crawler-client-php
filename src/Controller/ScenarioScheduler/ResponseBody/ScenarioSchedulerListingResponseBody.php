<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\AbstractListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValueObject\ScenarioSchedulerListingItem;

final class ScenarioSchedulerListingResponseBody extends AbstractListingResponseBody
{
    /** @var array<int, ScenarioSchedulerListingItem> */
    public array $data = [];
}
