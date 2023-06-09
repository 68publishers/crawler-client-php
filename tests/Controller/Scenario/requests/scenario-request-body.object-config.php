<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;

return new ScenarioRequestBody(
    'Test 1',
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
