<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Cookie;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Data;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioResults;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioResultsStats;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Screenshot;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\VisitedUrl;

return new ScenarioResponseBody(
    'c3e8af54-aa92-41c7-b4d3-7d5291f718c6',
    '97459b6d-147d-44f4-bbb7-8cdff6df5fa7',
    'test_user',
    'Test 1',
    new DateTimeImmutable('2023-06-01T02:26:19.965Z'),
    'completed',
    null,
    [
        'custom_flag' => 'flag_value',
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
    new ScenarioResultsStats(4, 1, 2, 3),
    new ScenarioResults(
        [
            new VisitedUrl(
                '68663be76d627b0b5dd745f13440ec87e76ae89250c590a9a768a4c5afd3049f',
                'https://www.example.com',
                null,
                null,
                200,
            ),
            new VisitedUrl(
                'af7607372943efc9669b5e9ffdaee693173ff7ac3e36962d6e59aad36282e4eb',
                'https://www.example.com/page2',
                null,
                'https://www.example.com',
                200,
            ),
            new VisitedUrl(
                '7f5e068c22bc5e9c1d07d9b0a7815c0d1aa4cf43bc355aed441915aa856515c8',
                'https://www.example.com/page3',
                null,
                'https://www.example.com',
                200,
            ),
            new VisitedUrl(
                '137fe034dea9ea346d94bcd16877a1dafaa72f983ad7165cb897bf3ae2ec9cdc',
                'https://www.example.com/page4',
                'Not Found',
                'https://www.example.com',
                404,
            ),
        ],
        [
            new Data(
                'allTitles',
                [
                    'titles' => [
                        'Homepage | Example',
                        'Page2 | Example',
                        'Page3 | Example',
                    ],
                ],
                [
                    'titles' => 'https://www.example.com/page3',
                ],
            ),
        ],
        [
            new Cookie(
                '157f0b711cdefddba648a386624051abde8a5a181d76266b35a7103de338c2e7',
                'SESSIONID',
                'example.com',
                false,
                true,
                true,
                'Strict',
                'https://www.example.com',
            ),
            new Cookie(
                '266157f0b711cdefddba648b35a7103dea386624051abde8a5a181d76338c2e7',
                'test_cookie',
                '.example.com',
                false,
                false,
                false,
                null,
                'https://www.example.com/page2',
            ),
        ],
        [
            new Screenshot(
                '2f8f513e-c1cf-457f-8917-ce047acbd052',
                'startup',
                'https://www.example.com',
                'https://www.crawler.com/static/screenshots/7601e9aa-4473-4384-8c51-6a6fe6250e27/2f8f513e-c1cf-457f-8917-ce047acbd052.jpg',
            ),
            new Screenshot(
                '4eb8301a-f963-4c33-9e21-1ce6f01d2ce5',
                'page - https://www.example.com/page2',
                'https://www.example.com/page2',
                'https://www.crawler.com/static/screenshots/7601e9aa-4473-4384-8c51-6a6fe6250e27/4eb8301a-f963-4c33-9e21-1ce6f01d2ce5.jpg',
            ),
            new Screenshot(
                '6d7bd2cc-209a-4c3c-b9f4-8690df13c41d',
                'page - https://www.example.com/page3',
                'https://www.example.com/page3',
                'https://www.crawler.com/static/screenshots/7601e9aa-4473-4384-8c51-6a6fe6250e27/6d7bd2cc-209a-4c3c-b9f4-8690df13c41d.jpg',
            ),
        ],
    ),
);
