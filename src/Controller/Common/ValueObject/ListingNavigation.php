<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject;

final class ListingNavigation
{
    public string $url;

    public int $page;

    public int $limit;
}
