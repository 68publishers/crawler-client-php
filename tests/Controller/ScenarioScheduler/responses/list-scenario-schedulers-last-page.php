<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValueObject\ScenarioSchedulerListingItem;

return new ScenarioSchedulerListingResponseBody(
    4,
    null,
    new ListingNavigation('https://crawler.com/api/scenario-schedulers?limit=3&page=1', 1, 3),
    [
        new ScenarioSchedulerListingItem(
            '82e1b9b6-b70c-40c1-96bf-38a8ab8428b8',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 4',
            new DateTimeImmutable('2023-06-05T02:11:54.021Z'),
            new DateTimeImmutable('2023-06-05T02:11:54.021Z'),
            true,
            '0 4 * * *',
            [],
        ),
    ],
);
