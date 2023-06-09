<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use Closure;
use SixtyEightPublishers\CrawlerClient\Authentication\Credentials;
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\CrawlerClientInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\AuthenticationMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\ResponseExceptionMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\UnexpectedErrorMiddleware;
use SixtyEightPublishers\CrawlerClient\Serializer\JmsSerializer;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use SixtyEightPublishers\CrawlerClient\Tests\Bridge\Nette\DI\ContainerFactory;
use SixtyEightPublishers\CrawlerClient\Tests\Middleware\MiddlewareFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Serializer\SerializerFixture;
use Tester\Assert;
use Tester\TestCase;
use function call_user_func;

require __DIR__ . '/../../../bootstrap.php';

final class CrawlerClientExtensionTest extends TestCase
{
    public function testContainerWithMinimalConfiguration(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.minimal.neon');

        $this->assertGuzzleConfig($client, [
            'base_uri' => 'https://www.crawler.com/api/',
        ]);
        $this->assertMiddlewares($client, [
            new UnexpectedErrorMiddleware(),
            new ResponseExceptionMiddleware(),
        ]);
        $this->assertSerializerType($client, JmsSerializer::class);
    }

    public function testContainerWithCustomGuzzleConfig(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.withCustomGuzzleConfig.neon');

        $this->assertGuzzleConfig($client, [
            'base_uri' => 'https://www.crawler.com/api/',
            'test_option' => 'test_value',
        ]);
    }

    public function testContainerWithCredentials(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.withCredentials.neon');

        $this->assertMiddlewares($client, [
            new UnexpectedErrorMiddleware(),
            new ResponseExceptionMiddleware(),
            new AuthenticationMiddleware(new Credentials('test_user', 'test_password')),
        ]);
    }

    public function testContainerWithCredentialsService(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.withCredentialsService.neon');

        $this->assertMiddlewares($client, [
            new UnexpectedErrorMiddleware(),
            new ResponseExceptionMiddleware(),
            new AuthenticationMiddleware(new CredentialsFixture('test_header')),
        ]);
    }

    public function testContainerWithMiddlewares(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.withMiddlewares.neon');

        $this->assertMiddlewares($client, [
            new UnexpectedErrorMiddleware(),
            new ResponseExceptionMiddleware(),
            new MiddlewareFixture('A', 10),
            new MiddlewareFixture('B', 20),
            new MiddlewareFixture('C', 30),
        ]);
    }

    public function testContainerWithCustomSerializer(): void
    {
        $client = $this->getClientFromContainer(__DIR__ . '/config.withCustomSerializer.neon');

        $this->assertSerializerType($client, SerializerFixture::class);
    }

    private function getClientFromContainer(string $configFile): CrawlerClient
    {
        $container = ContainerFactory::create($configFile);
        $client = $container->getByType(CrawlerClientInterface::class);

        Assert::type(CrawlerClient::class, $client);

        return $client;
    }

    private function assertGuzzleConfig(CrawlerClient $client, array $guzzleConfig): void
    {
        $clientGuzzleConfig = call_user_func(Closure::bind(static fn (): array => $client->guzzleConfig, null, CrawlerClient::class));

        foreach ($guzzleConfig as $key => $value) {
            Assert::hasKey($key, $clientGuzzleConfig);
            Assert::same($value, $clientGuzzleConfig[$key]);
        }
    }

    private function assertMiddlewares(CrawlerClient $client, array $middlewares): void
    {
        $clientMiddlewares = call_user_func(Closure::bind(static fn (): array => $client->middlewares, null, CrawlerClient::class));

        Assert::equal($middlewares, $clientMiddlewares);
    }

    private function assertSerializerType(CrawlerClient $client, string $type): void
    {
        $serializer = call_user_func(Closure::bind(static fn (): SerializerInterface => $client->serializer, null, CrawlerClient::class));

        Assert::type($type, $serializer);
    }
}

(new CrawlerClientExtensionTest())->run();
