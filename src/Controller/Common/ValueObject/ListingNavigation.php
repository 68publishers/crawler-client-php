<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject;

final class ListingNavigation
{
    public string $url;

    public int $page;

    public int $limit;

    public function __construct(string $url, int $page, int $limit)
    {
        $this->url = $url;
        $this->page = $page;
        $this->limit = $limit;
    }
}
