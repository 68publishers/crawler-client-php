<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\ClosureMiddleware;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class ClosureMiddlewareTest extends TestCase
{
    public function testClosureMiddleware(): void
    {
        $request = new Request('GET', 'https://example.com', [], '');
        $options = [];
        $next = static fn (RequestInterface $_request, array $_options): FulfilledPromise => new FulfilledPromise([$_request, $_options]);

        $middleware = new ClosureMiddleware('test', 100, static function (callable $next): callable {
            return static function (RequestInterface $_request, array $_options) use ($next): FulfilledPromise {
                $_options['invoked'] = true;

                return $next($_request, $_options);
            };
        });
        $middlewareFunction = $middleware($next);

        $returnedPromise = $middlewareFunction($request, $options);
        [$returnedRequest, $returnedOptions] = $returnedPromise->wait();

        Assert::same('test', $middleware->getName());
        Assert::same(100, $middleware->getPriority());
        Assert::same($request, $returnedRequest);
        Assert::same([
            'invoked' => true,
        ], $returnedOptions);
    }
}

(new ClosureMiddlewareTest())->run();
