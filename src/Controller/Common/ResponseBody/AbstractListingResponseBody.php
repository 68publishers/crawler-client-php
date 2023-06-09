<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;

abstract class AbstractListingResponseBody
{
    public int $totalCount;

    public ?ListingNavigation $next = null;

    public ?ListingNavigation $previous = null;

    public function __construct(int $totalCount, ?ListingNavigation $next, ?ListingNavigation $previous)
    {
        $this->totalCount = $totalCount;
        $this->next = $next;
        $this->previous = $previous;
    }
}
