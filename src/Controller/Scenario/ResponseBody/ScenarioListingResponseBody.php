<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\AbstractListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioListingItem;

final class ScenarioListingResponseBody extends AbstractListingResponseBody
{
    /** @var array<int, ScenarioListingItem> */
    public array $data = [];

    /**
     * @param array<int, ScenarioListingItem> $data
     */
    public function __construct(int $totalCount, ?ListingNavigation $next, ?ListingNavigation $previous, array $data)
    {
        parent::__construct($totalCount, $next, $previous);

        $this->data = $data;
    }
}
