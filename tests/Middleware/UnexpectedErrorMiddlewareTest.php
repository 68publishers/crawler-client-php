<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use GuzzleHttp\Psr7\Request;
use RuntimeException;
use SixtyEightPublishers\CrawlerClient\Exception\UnexpectedErrorException;
use SixtyEightPublishers\CrawlerClient\Middleware\UnexpectedErrorMiddleware;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class UnexpectedErrorMiddlewareTest extends TestCase
{
    public function testNameShouldBeReturned(): void
    {
        $middleware = new UnexpectedErrorMiddleware();

        Assert::same('unexpected_error', $middleware->getName());
    }

    public function testPriorityShouldBeReturned(): void
    {
        $middleware = new UnexpectedErrorMiddleware();

        Assert::same(300, $middleware->getPriority());
    }

    public function testControllerExceptionShouldBeThrown(): void
    {
        $request = new Request('GET', 'https://example.com', [], '');
        $options = [];
        $next = static function (): void {
            throw new ControllerExceptionFixture('Test controller exception.');
        };

        $middleware = new UnexpectedErrorMiddleware();
        $middlewareFunction = $middleware($next);

        $thrownException = Assert::exception(
            static fn () => $middlewareFunction($request, $options),
            ControllerExceptionFixture::class,
            'Test controller exception.',
        );

        Assert::null($thrownException->getPrevious());
    }

    public function testUnexpectedErrorExceptionShouldBeThrown(): void
    {
        $originalException = new RuntimeException('Test runtime exception.');
        $request = new Request('GET', 'https://example.com', [], '');
        $options = [];
        $next = static function () use ($originalException): void {
            throw $originalException;
        };

        $middleware = new UnexpectedErrorMiddleware();
        $middlewareFunction = $middleware($next);

        $thrownException = Assert::exception(
            static fn () => $middlewareFunction($request, $options),
            UnexpectedErrorException::class,
            'Controller thrown an unexpected exception: Test runtime exception.',
        );

        Assert::same($originalException, $thrownException->getPrevious());
    }
}

(new UnexpectedErrorMiddlewareTest())->run();
