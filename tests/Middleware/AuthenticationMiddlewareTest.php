<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\AuthenticationMiddleware;
use SixtyEightPublishers\CrawlerClient\Tests\Authentication\CredentialsFixture;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class AuthenticationMiddlewareTest extends TestCase
{
    public function testNameShouldBeReturned(): void
    {
        $middleware = new AuthenticationMiddleware(new CredentialsFixture('TEST_TOKEN'));

        Assert::same('authentication', $middleware->getName());
    }

    public function testPriorityShouldBeReturned(): void
    {
        $middleware = new AuthenticationMiddleware(new CredentialsFixture('TEST_TOKEN'));

        Assert::same(100, $middleware->getPriority());
    }

    public function testAuthorizationHeaderShouldBeAdded(): void
    {
        $request = new Request('GET', 'https://example.com', [], '');
        $options = [];
        $next = static fn (RequestInterface $_request, array $_options): FulfilledPromise => new FulfilledPromise([$_request, $_options]);

        $middleware = new AuthenticationMiddleware(new CredentialsFixture('TEST_TOKEN'));
        $middlewareFunction = $middleware($next);

        $returnedPromise = $middlewareFunction($request, $options);
        [$returnedRequest, $returnedOptions] = $returnedPromise->wait();

        Assert::same(['TEST_TOKEN'], $returnedRequest->getHeader('Authorization'));
        Assert::same($options, $returnedOptions);
    }
}

(new AuthenticationMiddlewareTest())->run();
