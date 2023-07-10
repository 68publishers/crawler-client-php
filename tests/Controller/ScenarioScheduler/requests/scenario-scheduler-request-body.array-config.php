<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;

return new ScenarioSchedulerRequestBody(
    'Test 1',
    [
        'optional' => 'true',
    ],
    true,
    '0 1 * * *',
    [
        'options' => [
            'viewport' => [
                'width' => 1080,
                'height' => 720,
            ],
            'maxRequests' => 10,
        ],
        'callbackUri' => 'https://www.example-api.com/results',
        'scenes' => [
            'startup' => [
                [
                    'action' => 'screenshot',
                    'options' => [
                        'name' => 'startup',
                    ],
                ],
                [
                    'action' => 'click',
                    'options' => [
                        'selector' => '#element',
                    ],
                ],
                [
                    'action' => 'delay',
                    'options' => [
                        'delay' => 2000,
                    ],
                ],
                [
                    'action' => 'setIdentity',
                    'options' => [
                        'strategy' => 'static',
                        'identity' => 'allTitles',
                    ],
                ],
                [
                    'action' => 'collectData',
                    'options' => [
                        'titles' => [
                            'strategy' => 'selector.innerText',
                            'selector' => 'title',
                            'multiple' => true,
                        ],
                    ],
                ],
                [
                    'action' => 'collectCookies',
                    'options' => [],
                ],
                [
                    'action' => 'enqueueLinks',
                    'options' => [
                        'scene' => 'nextPages',
                        'strategy' => 'same-hostname',
                    ],
                ],
            ],
            'nextPages' => [
                [
                    'action' => 'screenshot',
                    'options' => [
                        'name' => 'page - {{location.href}}',
                    ],
                ],
                [
                    'action' => 'delay',
                    'options' => [
                        'delay' => 1000,
                    ],
                ],
                [
                    'action' => 'collectCookies',
                    'options' => [],
                ],
                [
                    'action' => 'collectData',
                    'options' => [
                        'titles' => [
                            'strategy' => 'selector.innerText',
                            'selector' => 'title',
                            'multiple' => true,
                        ],
                    ],
                ],
            ],
        ],
        'entrypoint' => [
            'url' => 'https://www.example.com',
            'scene' => 'startup',
        ],
    ],
);
