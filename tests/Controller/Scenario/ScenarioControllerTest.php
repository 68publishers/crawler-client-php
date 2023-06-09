<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use ArrayObject;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenariosController;
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\Middleware\ClosureMiddleware;
use SixtyEightPublishers\CrawlerClient\Tests\FileFixtureHelper;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

final class ScenarioControllerTest extends TestCase
{
    /**
     * @dataProvider dataProviderListScenarios
     */
    public function testListScenarios(array $methodArguments, string $httpMethod, string $requestedUrl, Response $response, object $mappedResponseBody): void
    {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->listScenarios(...$methodArguments);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());
        Assert::same($response, $history[0]['response']);
    }

    /**
     * @dataProvider dataProviderGetScenario
     */
    public function testGetScenario(array $methodArguments, string $httpMethod, string $requestedUrl, Response $response, object $mappedResponseBody): void
    {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->getScenario(...$methodArguments);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());
        Assert::same($response, $history[0]['response']);
    }

    /**
     * @dataProvider dataProviderRunScenario
     */
    public function testRunScenario(
        ScenarioRequestBody $methodArgument,
        string $httpMethod,
        string $requestedUrl,
        array $requestHeaders,
        string $requestBody,
        Response $response,
        object $mappedResponseBody
    ): void {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->runScenario($methodArgument);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());

        foreach ($requestHeaders as $headerName => $headerValue) {
            Assert::contains($headerValue, $history[0]['request']->getHeader($headerName));
        }

        Assert::same(json_decode($requestBody, true), json_decode((string) $history[0]['request']->getBody(), true));
        Assert::equal($response, $history[0]['response']);
    }

    /**
     * @dataProvider dataProviderValidateScenario
     */
    public function testValidateScenario(
        ScenarioRequestBody $methodArgument,
        string $httpMethod,
        string $requestedUrl,
        array $requestHeaders,
        string $requestBody,
        Response $response,
        object $mappedResponseBody
    ): void {
        [$controller, $history] = $this->createControllerAndHistory([$response]);
        $returnedMappedResponse = $controller->validateScenario($methodArgument);

        Assert::equal($mappedResponseBody, $returnedMappedResponse->getBody());
        Assert::same($httpMethod, $history[0]['request']->getMethod());
        Assert::same($requestedUrl, (string) $history[0]['request']->getUri());

        foreach ($requestHeaders as $headerName => $headerValue) {
            Assert::contains($headerValue, $history[0]['request']->getHeader($headerName));
        }

        Assert::same(json_decode($requestBody, true), json_decode((string) $history[0]['request']->getBody(), true));
        Assert::equal($response, $history[0]['response']);
    }

    public function dataProviderListScenarios(): array
    {
        $helper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                [1, 3],
                'GET',
                'https://www.crawler.com/api/scenarios?limit=3&page=1',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenarios-first-page')),
                $helper->getPhp('list-scenarios-first-page'),
            ],
            [
                [1, 3, ['name' => 'Test', 'flags' => ['optional' => 'true']]],
                'GET',
                'https://www.crawler.com/api/scenarios?limit=3&page=1&filter%5Bname%5D=Test&filter%5Bflags%5D%5Boptional%5D=true',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenarios-first-page')),
                $helper->getPhp('list-scenarios-first-page'),
            ],
            [
                [3, 3],
                'GET',
                'https://www.crawler.com/api/scenarios?limit=3&page=3',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('list-scenarios-last-page')),
                $helper->getPhp('list-scenarios-last-page'),
            ],
        ];
    }

    public function dataProviderGetScenario(): array
    {
        $helper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                ['c3e8af54-aa92-41c7-b4d3-7d5291f718c6'],
                'GET',
                'https://www.crawler.com/api/scenarios/c3e8af54-aa92-41c7-b4d3-7d5291f718c6',
                new Response(200, ['Content-Type' => 'application/json'], $helper->getRaw('get-scenario')),
                $helper->getPhp('get-scenario'),
            ],
        ];
    }

    public function dataProviderRunScenario(): array
    {
        $requestHelper = new FileFixtureHelper(__DIR__ . '/requests');
        $responseHelper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                $requestHelper->getPhp('scenario-request-body.array-config'),
                'POST',
                'https://www.crawler.com/api/scenarios',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('get-scenario')),
                $responseHelper->getPhp('get-scenario'),
            ],
            [
                $requestHelper->getPhp('scenario-request-body.object-config'),
                'POST',
                'https://www.crawler.com/api/scenarios',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('get-scenario')),
                $responseHelper->getPhp('get-scenario'),
            ],
        ];
    }

    public function dataProviderValidateScenario(): array
    {
        $requestHelper = new FileFixtureHelper(__DIR__ . '/requests');
        $responseHelper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [
                $requestHelper->getPhp('scenario-request-body.array-config'),
                'POST',
                'https://www.crawler.com/api/scenarios/validate',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('validate-scenario.valid')),
                $responseHelper->getPhp('validate-scenario.valid'),
            ],
            [
                $requestHelper->getPhp('scenario-request-body.object-config'),
                'POST',
                'https://www.crawler.com/api/scenarios/validate',
                [
                    'Content-Type' => 'application/json',
                ],
                $requestHelper->getRaw('scenario-request-body'),
                new Response(200, ['Content-Type' => 'application/json'], $responseHelper->getRaw('validate-scenario.invalid')),
                $responseHelper->getPhp('validate-scenario.invalid'),
            ],
        ];
    }

    /**
     * @return array{0: ScenariosController, 1: ArrayObject}
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
            ->getController(ScenariosController::class);

        return [$controller, $history];
    }
}

(new ScenarioControllerTest())->run();
