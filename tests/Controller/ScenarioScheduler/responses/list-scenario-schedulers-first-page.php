<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValueObject\ScenarioSchedulerListingItem;

return new ScenarioSchedulerListingResponseBody(
    4,
    new ListingNavigation('https://crawler.com/api/scenario-schedulers?limit=3&page=2', 2, 3),
    null,
    [
        new ScenarioSchedulerListingItem(
            'b5f052d8-f285-49ac-9030-bd50ec73393c',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 1',
            new DateTimeImmutable('2023-06-07T02:20:02.020Z'),
            new DateTimeImmutable('2023-06-07T02:20:02.020Z'),
            '0 1 * * *',
            [
                'optional' => 'true',
            ],
        ),
        new ScenarioSchedulerListingItem(
            '407e6c70-6c09-4bb3-8832-32e8954cfdca',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 2',
            new DateTimeImmutable('2023-06-06T04:57:12.922Z'),
            new DateTimeImmutable('2023-06-06T04:57:12.922Z'),
            '0 2 * * *',
            [
                'optional' => 'true',
            ],
        ),
        new ScenarioSchedulerListingItem(
            'abd666d8-163f-4c5f-a4c4-b7b02fa78b47',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 3',
            new DateTimeImmutable('2023-06-06T04:52:12.922Z'),
            new DateTimeImmutable('2023-06-06T04:52:12.922Z'),
            '0 3 * * *',
            [],
        ),
    ],
);
