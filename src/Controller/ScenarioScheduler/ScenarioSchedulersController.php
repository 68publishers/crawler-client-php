<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler;

use GuzzleHttp\RequestOptions;
use SixtyEightPublishers\CrawlerClient\Controller\Common\NoContentResponse;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerResponseHandlerTrait;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerListingResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ValidateScenarioSchedulerResponseBody;

final class ScenarioSchedulersController implements ControllerInterface
{
    use ControllerResponseHandlerTrait;

    /**
     * @param array<string, string|array<string>> $filter
     *
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function listScenarioSchedulers(int $page, int $limit, array $filter = []): ScenarioSchedulerListingResponse
    {
        $query = [
            'limit' => $limit,
            'page' => $page,
        ];

        if (!empty($filter)) {
            $query['filter'] = $filter;
        }

        return new ScenarioSchedulerListingResponse(
            ...$this->handle(
                fn () => $this->client->request('GET', 'scenario-schedulers', [
                RequestOptions::QUERY => $query,
            ]),
                ScenarioSchedulerListingResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function getScenarioScheduler(string $scenarioSchedulerId): ScenarioSchedulerResponse
    {
        return new ScenarioSchedulerResponse(
            ...$this->handle(
                fn () => $this->client->request('GET', 'scenario-schedulers/' . $scenarioSchedulerId),
                ScenarioSchedulerResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function createScenarioScheduler(ScenarioSchedulerRequestBody $requestBody): ScenarioSchedulerResponse
    {
        return new ScenarioSchedulerResponse(
            ...$this->handle(
                fn () => $this->client->request('POST', 'scenario-schedulers', [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                    ],
                    RequestOptions::BODY => $this->serializer->serialize($requestBody),
                ]),
                ScenarioSchedulerResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function updateScenarioScheduler(string $scenarioSchedulerId, string $etag, ScenarioSchedulerRequestBody $requestBody): ScenarioSchedulerResponse
    {
        return new ScenarioSchedulerResponse(
            ...$this->handle(
                fn () => $this->client->request('PUT', 'scenario-schedulers/' . $scenarioSchedulerId, [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                        'If-Match' => $etag,
                    ],
                    RequestOptions::BODY => $this->serializer->serialize($requestBody),
                ]),
                ScenarioSchedulerResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function validateScenarioScheduler(ScenarioSchedulerRequestBody $requestBody): ValidateScenarioSchedulerResponse
    {
        return new ValidateScenarioSchedulerResponse(
            ...$this->handle(
                fn () => $this->client->request('POST', 'scenario-schedulers/validate', [
                    RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                    ],
                    RequestOptions::BODY => $this->serializer->serialize($requestBody),
                ]),
                ValidateScenarioSchedulerResponseBody::class,
            ),
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function deleteScenarioScheduler(string $scenarioSchedulerId): NoContentResponse
    {
        $response = $this->handle(
            fn () => $this->client->request('DELETE', 'scenario-schedulers/' . $scenarioSchedulerId),
            null,
        )[0];

        return new NoContentResponse($response);
    }
}
