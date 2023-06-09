<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests;

use Closure;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;
use InvalidArgumentException;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenariosController;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulersController;
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\Middleware\AuthenticationMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\ResponseExceptionMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\UnexpectedErrorMiddleware;
use SixtyEightPublishers\CrawlerClient\Tests\Authentication\CredentialsFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Controller\ControllerFactoryFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Controller\ControllerFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Middleware\MiddlewareFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Serializer\SerializerFixture;
use Tester\Assert;
use Tester\TestCase;
use function assert;
use function call_user_func;

require __DIR__ . '/bootstrap.php';

final class CrawlerClientTest extends TestCase
{
    public function testExceptionShouldBeThrownIfControllerFactoryIsMissing(): void
    {
        $client = CrawlerClient::create('https://crawler.com');

        Assert::exception(
            static fn () => $client->getController(ControllerFixture::class),
            InvalidArgumentException::class,
            'Factory for controller of type SixtyEightPublishers\CrawlerClient\Tests\Controller\ControllerFixture is not defined.',
        );
    }

    public function testControllersShouldBeReturned(): void
    {
        $client = CrawlerClient::create('https://crawler.com');

        Assert::type(ScenariosController::class, $client->getController(ScenariosController::class));
        Assert::type(ScenarioSchedulersController::class, $client->getController(ScenarioSchedulersController::class));

        $factoryFixture = new ControllerFactoryFixture();
        $client = $client->withControllerFactories($factoryFixture);

        $controller1 = $client->getController(ControllerFixture::class);
        $controller2 = $client->getController(ControllerFixture::class);

        Assert::type(ControllerFixture::class, $controller1);
        Assert::type(ControllerFixture::class, $controller2);
        Assert::same($controller1, $controller2);
        Assert::same(1, $factoryFixture->numberOfCreatedControllers);
    }

    public function testCustomSerializer(): void
    {
        $client = CrawlerClient::create('https://crawler.com');
        $serializer = new SerializerFixture();

        # we need controller fixture to access the serializer
        $client = $client
            ->withSerializer($serializer)
            ->withControllerFactories(new ControllerFactoryFixture());

        $controller = $client->getController(ControllerFixture::class);

        Assert::same($serializer, $controller->serializer);
    }

    public function testDefaultOptionsAndMiddlewares(): void
    {
        $client = CrawlerClient::create('https://crawler.com', [
            'handler' => new HandlerStack(Utils::chooseHandler()),
            'custom_option' => 'custom_value',
        ]);

        # we need controller fixture to access guzzle client
        $client = $client->withControllerFactories(new ControllerFactoryFixture());

        $controller = $client->getController(ControllerFixture::class);
        [$config, $stack] = $this->getGuzzleConfigAndStack($controller->client);

        Assert::equal('https://crawler.com/api/', (string) $config['base_uri']);
        Assert::false($config['http_errors']);
        Assert::type(Closure::class, $config['serializer_getter']);
        Assert::equal('custom_value', $config['custom_option']);

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [new ResponseExceptionMiddleware(), 'response_exception'],
        ], $stack);
    }

    public function testAuthenticationMiddlewareAppended(): void
    {
        $client = CrawlerClient::create('https://crawler.com', [
            'handler' => new HandlerStack(Utils::chooseHandler()),
        ]);

        # we need controller fixture to access guzzle client
        $client = $client
            ->withAuthentication(new CredentialsFixture('TEST_TOKEN'))
            ->withControllerFactories(new ControllerFactoryFixture());

        $controller = $client->getController(ControllerFixture::class);
        $stack = $this->getGuzzleConfigAndStack($controller->client)[1];

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [new ResponseExceptionMiddleware(), 'response_exception'],
            [new AuthenticationMiddleware(new CredentialsFixture('TEST_TOKEN')), 'authentication'],
        ], $stack);
    }

    public function testCustomMiddlewares(): void
    {
        $middleware1 = new MiddlewareFixture('TEST_1', 50);
        $middleware2 = new MiddlewareFixture('TEST_2', 40);
        $middleware2Duplicated = new MiddlewareFixture('TEST_2', 60);
        $middleware3 = new MiddlewareFixture('TEST_3', 250);

        $client1 = CrawlerClient::create('https://crawler.com', [
            'handler' => new HandlerStack(Utils::chooseHandler()),
        ]);

        # we need controller fixture to access guzzle client
        $client1 = $client1->withControllerFactories(new ControllerFactoryFixture());
        $client2 = $client1->withMiddlewares($middleware2, $middleware1);
        $client3 = $client2->withMiddlewares($middleware3);
        $client4 = $client3->withMiddlewares($middleware2Duplicated);
        $client5 = $client4->withoutMiddlewares('unexpected_error', 'TEST_1', 'TEST_2');

        $stack1 = $this->getGuzzleConfigAndStack($client1->getController(ControllerFixture::class)->client)[1];
        $stack2 = $this->getGuzzleConfigAndStack($client2->getController(ControllerFixture::class)->client)[1];
        $stack3 = $this->getGuzzleConfigAndStack($client3->getController(ControllerFixture::class)->client)[1];
        $stack4 = $this->getGuzzleConfigAndStack($client4->getController(ControllerFixture::class)->client)[1];
        $stack5 = $this->getGuzzleConfigAndStack($client5->getController(ControllerFixture::class)->client)[1];

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [new ResponseExceptionMiddleware(), 'response_exception'],
        ], $stack1);

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [new ResponseExceptionMiddleware(), 'response_exception'],
            [$middleware1, $middleware1->getName()],
            [$middleware2, $middleware2->getName()],
        ], $stack2);

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [$middleware3, $middleware3->getName()],
            [new ResponseExceptionMiddleware(), 'response_exception'],
            [$middleware1, $middleware1->getName()],
            [$middleware2, $middleware2->getName()],
        ], $stack3);

        Assert::equal([
            [new UnexpectedErrorMiddleware(), 'unexpected_error'],
            [$middleware3, $middleware3->getName()],
            [new ResponseExceptionMiddleware(), 'response_exception'],
            [$middleware2Duplicated, $middleware2Duplicated->getName()],
            [$middleware1, $middleware1->getName()],
        ], $stack4);

        Assert::equal([
            [$middleware3, $middleware3->getName()],
            [new ResponseExceptionMiddleware(), 'response_exception'],
        ], $stack5);
    }

    /**
     * @return array{0: array, 1: array}
     */
    private function getGuzzleConfigAndStack(GuzzleClientInterface $guzzleClient): array
    {
        return call_user_func(Closure::bind(static function () use ($guzzleClient) {
            $config = $guzzleClient->config;
            $handler = $config['handler'];
            assert($handler instanceof HandlerStack);

            return [
                $config,
                call_user_func(Closure::bind(static fn (): array => $handler->stack, null, HandlerStack::class)),
            ];
        }, null, GuzzleClient::class));
    }
}

(new CrawlerClientTest())->run();
