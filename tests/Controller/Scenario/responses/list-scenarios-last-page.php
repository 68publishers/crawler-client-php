<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ListingNavigation;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioListingItem;

return new ScenarioListingResponseBody(
    9,
    null,
    new ListingNavigation('https://crawler.com/api/scenarios?limit=3&page=2', 2, 3),
    [
        new ScenarioListingItem(
            '9b19ad66-b21f-4d02-ab89-39b121ddf3c3',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 2',
            new DateTimeImmutable('2023-06-05T02:13:56.021Z'),
            new DateTimeImmutable('2023-06-05T02:27:06.227Z'),
            'completed',
            null,
            [
                'optional' => 'false',
            ],
        ),
        new ScenarioListingItem(
            'f0bc8561-0613-46dd-a0c2-f36ecaaaf105',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 3',
            new DateTimeImmutable('2023-06-05T02:11:54.021Z'),
            new DateTimeImmutable('2023-06-05T02:25:25.221Z'),
            'failed',
            'Error: test',
            [],
        ),
        new ScenarioListingItem(
            '8cb7eb7c-33ce-48a3-b7e1-05081805c56a',
            '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
            'test_user',
            'Test 1',
            new DateTimeImmutable('2023-06-05T02:07:33.421Z'),
            new DateTimeImmutable('2023-06-05T02:17:46.123Z'),
            'completed',
            null,
            [
                'optional' => 'true',
            ],
        ),
    ],
);
