<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioListingItem;

return new ScenarioListingResponseBody(
    9,
    new ListingNavigation('https://crawler.com/api/scenarios?limit=3&page=2', 2, 3),
    null,
    [
        new ScenarioListingItem(
            '98b735b6-a202-4497-aec7-6205ddba5c31',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 1',
            new DateTimeImmutable('2023-06-07T02:20:02.020Z'),
            'running',
            null,
            [
                'optional' => 'true',
            ],
        ),
        new ScenarioListingItem(
            'e7ced046-6398-410d-a3ff-702889556005',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 1',
            new DateTimeImmutable('2023-06-06T04:57:12.922Z'),
            'completed',
            null,
            [
                'optional' => 'true',
            ],
        ),
        new ScenarioListingItem(
            '65614958-d08f-42a5-b040-17bb7aba85fa',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 2',
            new DateTimeImmutable('2023-06-06T04:52:12.922Z'),
            'completed',
            null,
            [],
        ),
    ],
);
