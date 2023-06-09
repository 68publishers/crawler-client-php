<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use ArrayObject;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulersController;
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\Middleware\ClosureMiddleware;
use SixtyEightPublishers\CrawlerClient\Tests\FileFixtureHelper;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

final class ScenarioSchedulerControllerTest extends TestCase
{
    /**
     * @dataProvider dataProviderListScenarioSchedulers
     */
    public function testListScenarioSchedulers(array $methodArguments, string $httpMethod, string $requestedUrl, Response $response, object $mappedResponseBody): void
    {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->listScenarioSchedulers(...$methodArguments);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());
        Assert::same($response, $history[0]['response']);
    }

    /**
     * @dataProvider dataProviderGetScenarioScheduler
     */
    public function testGetScenarioScheduler(array $methodArguments, string $httpMethod, string $requestedUrl, Response $response, object $mappedResponseBody): void
    {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->getScenarioScheduler(...$methodArguments);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());
        Assert::same($response, $history[0]['response']);
    }

    /**
     * @dataProvider dataProviderCreateScenarioScheduler
     */
    public function testCreateScenarioScheduler(
        ScenarioSchedulerRequestBody $methodArgument,
        string $httpMethod,
        string $requestedUrl,
        array $requestHeaders,
        string $requestBody,
        Response $response,
        object $mappedResponseBody,
        string $expectedEtag
    ): void {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->createScenarioScheduler($methodArgument);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());

        foreach ($requestHeaders as $headerName => $headerValue) {
            Assert::contains($headerValue, $history[0]['request']->getHeader($headerName));
        }

        Assert::same(json_decode($requestBody, true), json_decode((string) $history[0]['request']->getBody(), true));
        Assert::equal($response, $history[0]['response']);
        Assert::same($expectedEtag, $returnedMappedResponse->getEtag());
    }

    /**
     * @dataProvider dataProviderUpdateScenarioScheduler
     */
    public function testUpdateScenarioScheduler(
        array $methodArguments,
        string $httpMethod,
        string $requestedUrl,
        array $requestHeaders,
        string $requestBody,
        Response $response,
        object $mappedResponseBody,
        string $expectedEtag
    ): void {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->updateScenarioScheduler(...$methodArguments);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());

        foreach ($requestHeaders as $headerName => $headerValue) {
            Assert::contains($headerValue, $history[0]['request']->getHeader($headerName));
        }

        Assert::same(json_decode($requestBody, true), json_decode((string) $history[0]['request']->getBody(), true));
        Assert::equal($response, $history[0]['response']);
        Assert::same($expectedEtag, $returnedMappedResponse->getEtag());
    }

    /**
     * @dataProvider dataProviderValidateScenarioScheduler
     */
    public function testValidateScenarioScheduler(
        ScenarioSchedulerRequestBody $methodArgument,
        string $httpMethod,
        string $requestedUrl,
        array $requestHeaders,
        string $requestBody,
        Response $response,
        object $mappedResponseBody
    ): void {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->validateScenarioScheduler($methodArgument);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());

        foreach ($requestHeaders as $headerName => $headerValue) {
            Assert::contains($headerValue, $history[0]['request']->getHeader($headerName));
        }

        Assert::same(json_decode($requestBody, true), json_decode((string) $history[0]['request']->getBody(), true));
        Assert::equal($response, $history[0]['response']);
    }

    public function testDeleteScenarioScheduler(): void
    {
        [$controller, $history] = $this->createControllerAndHistory([
            new Response(204, [], null),
        ]);

        $controller->deleteScenarioScheduler('b5f052d8-f285-49ac-9030-bd50ec73393c');

        Assert::same('DELETE', $history[0]['request']->getMethod());
        Assert::same('https://www.crawler.com/api/scenario-schedulers/b5f052d8-f285-49ac-9030-bd50ec73393c', (string) $history[0]['request']->getUri());
    }

    public function dataProviderListScenarioSchedulers(): array
    {
        $helper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                [1, 3],
                'GET',
                'https://www.crawler.com/api/scenario-schedulers?limit=3&page=1',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenario-schedulers-first-page')),
                $helper->getPhp('list-scenario-schedulers-first-page'),
            ],
            [
                [1, 3, ['name' => 'Test', 'flags' => ['optional' => 'true']]],
                'GET',
                'https://www.crawler.com/api/scenario-schedulers?limit=3&page=1&filter%5Bname%5D=Test&filter%5Bflags%5D%5Boptional%5D=true',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenario-schedulers-first-page')),
                $helper->getPhp('list-scenario-schedulers-first-page'),
            ],
            [
                [2, 3],
                'GET',
                'https://www.crawler.com/api/scenario-schedulers?limit=3&page=2',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenario-schedulers-last-page')),
                $helper->getPhp('list-scenario-schedulers-last-page'),
            ],
        ];
    }

    public function dataProviderGetScenarioScheduler(): array
    {
        $helper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                ['b5f052d8-f285-49ac-9030-bd50ec73393c'],
                'GET',
                'https://www.crawler.com/api/scenario-schedulers/b5f052d8-f285-49ac-9030-bd50ec73393c',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('get-scenario-scheduler')),
                $helper->getPhp('get-scenario-scheduler'),
            ],
        ];
    }

    public function dataProviderCreateScenarioScheduler(): array
    {
        $requestHelper = new FileFixtureHelper(__DIR__ . '/requests');
        $responseHelper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                $requestHelper->getPhp('scenario-scheduler-request-body.array-config'),
                'POST',
                'https://www.crawler.com/api/scenario-schedulers',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json', 'Etag' => 'test_etag'], $responseHelper->getRaw('get-scenario-scheduler')),
                $responseHelper->getPhp('get-scenario-scheduler'),
                'test_etag',
            ],
            [
                $requestHelper->getPhp('scenario-scheduler-request-body.object-config'),
                'POST',
                'https://www.crawler.com/api/scenario-schedulers',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json', 'Etag' => 'test_etag'], $responseHelper->getRaw('get-scenario-scheduler')),
                $responseHelper->getPhp('get-scenario-scheduler'),
                'test_etag',
            ],
        ];
    }

    public function dataProviderUpdateScenarioScheduler(): array
    {
        $requestHelper = new FileFixtureHelper(__DIR__ . '/requests');
        $responseHelper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                ['b5f052d8-f285-49ac-9030-bd50ec73393c', 'current_etag', $requestHelper->getPhp('scenario-scheduler-request-body.array-config')],
                'PUT',
                'https://www.crawler.com/api/scenario-schedulers/b5f052d8-f285-49ac-9030-bd50ec73393c',
                [
                    'Content-Type' => 'application/json',
                    'If-Match' => 'current_etag',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json', 'Etag' => 'new_etag'], $responseHelper->getRaw('get-scenario-scheduler')),
                $responseHelper->getPhp('get-scenario-scheduler'),
                'new_etag',
            ],
            [
                ['b5f052d8-f285-49ac-9030-bd50ec73393c', 'current_etag', $requestHelper->getPhp('scenario-scheduler-request-body.object-config')],
                'PUT',
                'https://www.crawler.com/api/scenario-schedulers/b5f052d8-f285-49ac-9030-bd50ec73393c',
                [
                    'Content-Type' => 'application/json',
                    'If-Match' => 'current_etag',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json', 'Etag' => 'new_etag'], $responseHelper->getRaw('get-scenario-scheduler')),
                $responseHelper->getPhp('get-scenario-scheduler'),
                'new_etag',
            ],
        ];
    }

    public function dataProviderValidateScenarioScheduler(): array
    {
        $requestHelper = new FileFixtureHelper(__DIR__ . '/requests');
        $responseHelper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                $requestHelper->getPhp('scenario-scheduler-request-body.array-config'),
                'POST',
                'https://www.crawler.com/api/scenario-schedulers/validate',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('validate-scenario-scheduler.valid')),
                $responseHelper->getPhp('validate-scenario-scheduler.valid'),
            ],
            [
                $requestHelper->getPhp('scenario-scheduler-request-body.object-config'),
                'POST',
                'https://www.crawler.com/api/scenario-schedulers/validate',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-scheduler-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('validate-scenario-scheduler.invalid')),
                $responseHelper->getPhp('validate-scenario-scheduler.invalid'),
            ],
        ];
    }

    /**
     * @return array{0: ScenarioSchedulersController, 1: ArrayObject}
     */
    private function createControllerAndHistory(array $mockedResponses): array
    {
        $history = new ArrayObject();
        $client = CrawlerClient::create('https://www.crawler.com', [
            'handler' => HandlerStack::create(
                new MockHandler($mockedResponses),
            ),
        ]);

        $controller = $client
            ->withMiddlewares(new ClosureMiddleware('history', 100, Middleware::history($history)))
            ->getController(ScenarioSchedulersController::class);

        return [$controller, $history];
    }
}

(new ScenarioSchedulerControllerTest())->run();
