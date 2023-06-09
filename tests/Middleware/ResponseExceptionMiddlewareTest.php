<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;
use SixtyEightPublishers\CrawlerClient\Exception\BadRequestException;
use SixtyEightPublishers\CrawlerClient\Exception\ControllerResponseExceptionInterface;
use SixtyEightPublishers\CrawlerClient\Exception\NotFoundException;
use SixtyEightPublishers\CrawlerClient\Exception\PreconditionFailedException;
use SixtyEightPublishers\CrawlerClient\Exception\PreconditionRequiredException;
use SixtyEightPublishers\CrawlerClient\Exception\ServerErrorException;
use SixtyEightPublishers\CrawlerClient\Exception\UnauthorizedException;
use SixtyEightPublishers\CrawlerClient\Exception\UnexpectedErrorException;
use SixtyEightPublishers\CrawlerClient\Middleware\ResponseExceptionMiddleware;
use SixtyEightPublishers\CrawlerClient\Serializer\JmsSerializer;
use SixtyEightPublishers\CrawlerClient\Tests\FileFixtureHelper;
use Tester\Assert;
use Tester\TestCase;
use function assert;

require __DIR__ . '/../bootstrap.php';

final class ResponseExceptionMiddlewareTest extends TestCase
{
    public function testNameShouldBeReturned(): void
    {
        $middleware = new ResponseExceptionMiddleware();

        Assert::same('response_exception', $middleware->getName());
    }

    public function testPriorityShouldBeReturned(): void
    {
        $middleware = new ResponseExceptionMiddleware();

        Assert::same(200, $middleware->getPriority());
    }

    public function testResponseShouldBeReturnedOnNonErrorStatusCode(): void
    {
        $request = new Request('GET', 'https://example.com', [], '');
        $response = new Response(200, [], 'OK');
        $options = [];
        $next = static fn (): FulfilledPromise => new FulfilledPromise($response);

        $middleware = new ResponseExceptionMiddleware();
        $middlewareFunction = $middleware($next);

        $returnedResponse = $middlewareFunction($request, $options)->wait();

        Assert::same($response, $returnedResponse);
    }

    public function testUnexpectedErrorExceptionShouldBeThrownIfSerializerGetterOptionIsMissing(): void
    {
        $request = new Request('GET', 'https://example.com', [], '');
        $options = [];
        $next = static fn (): FulfilledPromise => new FulfilledPromise(new Response(401, [], 'Unauthorized'));

        $middleware = new ResponseExceptionMiddleware();
        $middlewareFunction = $middleware($next);

        Assert::exception(
            static fn () => $middlewareFunction($request, $options)->wait(),
            UnexpectedErrorException::class,
            'Controller thrown an unexpected exception: Missing option "serializer_getter" in the Guzzle options.',
        );
    }

    /**
     * @dataProvider dataProviderControllerResponseExceptionShouldBeThrown
     */
    public function testControllerResponseExceptionShouldBeThrown(
        int $statusCode,
        string $body,
        ErrorResponseBody $responseBody,
        string $exceptionClassname,
        bool $isJson
    ): void {
        $serializer = JmsSerializer::default(null, true);
        $serializerGetter = static fn () => $serializer;

        $request = new Request('GET', 'https://example.com', [], '');
        $response = new Response($statusCode, $isJson ? ['Content-Type' => 'application/json'] : [], $body);
        $options = [
            'serializer_getter' => $serializerGetter,
        ];
        $next = static fn (): FulfilledPromise => new FulfilledPromise($response);

        $middleware = new ResponseExceptionMiddleware();
        $middlewareFunction = $middleware($next);

        $thrownException = Assert::exception(
            static fn () => $middlewareFunction($request, $options)->wait(),
            $exceptionClassname,
        );
        assert($thrownException instanceof ControllerResponseExceptionInterface);

        Assert::same($request, $thrownException->getRequest());
        Assert::same($response, $thrownException->getResponse());
        Assert::equal($responseBody, $thrownException->getResponseBody());
    }

    public function dataProviderControllerResponseExceptionShouldBeThrown(): array
    {
        $helper = new FileFixtureHelper(__DIR__ . '/responses');

        return [
            [400, $helper->getRaw('400-validation'), $helper->getPhp('400-validation'), BadRequestException::class, true],
            [401, $helper->getRaw('401'), $helper->getPhp('401'), UnauthorizedException::class, false],
            [404, $helper->getRaw('404'), $helper->getPhp('404'), NotFoundException::class, true],
            [404, $helper->getRaw('404-missing-route'), $helper->getPhp('404-missing-route'), NotFoundException::class, true],
            [412, $helper->getRaw('412'), $helper->getPhp('412'), PreconditionFailedException::class, true],
            [428, $helper->getRaw('428'), $helper->getPhp('428'), PreconditionRequiredException::class, true],
            [500, $helper->getRaw('500'), $helper->getPhp('500'), ServerErrorException::class, true],
        ];
    }
}

(new ResponseExceptionMiddlewareTest())->run();
