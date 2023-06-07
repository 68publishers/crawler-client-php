<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\AbstractListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioListingItem;

final class ScenarioListingResponseBody extends AbstractListingResponseBody
{
    /** @var array<int, ScenarioListingItem> */
    public array $data = [];
}
