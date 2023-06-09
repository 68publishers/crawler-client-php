<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerResponseBody;

return new ScenarioSchedulerResponseBody(
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
    (new ScenarioConfig(new Entrypoint('https://www.example.com', 'startup')))
        ->withCallbackUri('https://www.example-api.com/results')
        ->withOptions([
            'viewport' => [
                'width' => 1080,
                'height' => 720,
            ],
            'maxRequests' => 10,
        ])
        ->withScene('startup', [
            new Action('screenshot', [
                'name' => 'startup',
            ]),
            new Action('click', [
                'selector' => '#element',
            ]),
            new Action('delay', [
                'delay' => 2000,
            ]),
            new Action('setIdentity', [
                'strategy' => 'static',
                'identity' => 'allTitles',
            ]),
            new Action('collectData', [
                'titles' => [
                    'strategy' => 'selector.innerText',
                    'selector' => 'title',
                    'multiple' => true,
                ],
            ]),
            new Action('collectCookies', []),
            new Action('enqueueLinks', [
                'scene' => 'nextPages',
                'strategy' => 'same-hostname',
            ]),
        ])
        ->withScene('nextPages', [
            new Action('screenshot', [
                'name' => 'page - {{location.href}}',
            ]),
            new Action('delay', [
                'delay' => 1000,
            ]),
            new Action('collectCookies', []),
            new Action('collectData', [
                'titles' => [
                    'strategy' => 'selector.innerText',
                    'selector' => 'title',
                    'multiple' => true,
                ],
            ]),
        ]),
);
