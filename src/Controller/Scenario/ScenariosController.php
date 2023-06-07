<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario;

use GuzzleHttp\RequestOptions;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerResponseHandlerTrait;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ValidateScenarioResponseBody;

final class ScenariosController implements ControllerInterface
{
    use ControllerResponseHandlerTrait;

    /**
     * @param array<string, string|array<string>> $filter
     *
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function listScenarios(int $page, int $limit, array $filter = []): ScenarioListingResponse
    {
        $query = [
            'page' => $page,
            'limit' => $limit,
        ];

        if (!empty($filter)) {
            $query['filter'] = $filter;
        }

        return new ScenarioListingResponse(
            ...$this->handle(
                fn () => $this->client->request('GET', 'scenarios', [
                    RequestOptions::QUERY => $query,
                ]),
                ScenarioListingResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function getScenario(string $scenarioId): ScenarioResponse
    {
        return new ScenarioResponse(
            ...$this->handle(
                fn () => $this->client->request('GET', 'scenarios/' . $scenarioId),
                ScenarioResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function runScenario(ScenarioRequestBody $requestBody): ScenarioResponse
    {
        return new ScenarioResponse(
            ...$this->handle(
                fn () => $this->client->request('POST', 'scenarios', [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                    ],
                    RequestOptions::BODY => $this->serializer->serialize($requestBody),
                ]),
                ScenarioResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function validateScenario(ScenarioRequestBody $requestBody): ValidateScenarioResponse
    {
        return new ValidateScenarioResponse(
            ...$this->handle(
                fn () => $this->client->request('POST', 'scenarios/validate', [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                    ],
                    RequestOptions::BODY => $this->serializer->serialize($requestBody),
                ]),
                ValidateScenarioResponseBody::class,
            ),
        );
    }
}
