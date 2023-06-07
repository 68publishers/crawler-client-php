<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Middleware;

use Closure;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;
use SixtyEightPublishers\CrawlerClient\Exception\BadRequestException;
use SixtyEightPublishers\CrawlerClient\Exception\NotFoundException;
use SixtyEightPublishers\CrawlerClient\Exception\PreconditionFailedException;
use SixtyEightPublishers\CrawlerClient\Exception\PreconditionRequiredException;
use SixtyEightPublishers\CrawlerClient\Exception\ServerErrorException;
use SixtyEightPublishers\CrawlerClient\Exception\UnauthorizedException;
use SixtyEightPublishers\CrawlerClient\Exception\UnexpectedErrorException;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use function strpos;

final class ResponseExceptionMiddleware implements MiddlewareInterface
{
    public function getName(): string
    {
        return 'response_exception';
    }

    public function __invoke(callable $next): callable
    {
        return static function (RequestInterface $request, array $options) use ($next): PromiseInterface {
            return $next($request, $options)->then(
                static function (ResponseInterface $response) use ($request, $options) {
                    $statusCode = $response->getStatusCode();

                    if (400 > $statusCode) {
                        return $response;
                    }

                    if (!isset($options['serializer_getter'])) {
                        throw new UnexpectedErrorException(new Exception(
                            'Missing option "serializer_getter" in the Guzzle options.',
                        ));
                    }

                    $serializerGetter = $options['serializer_getter'];
                    assert($serializerGetter instanceof Closure);
                    $serializer = $serializerGetter();
                    assert($serializer instanceof SerializerInterface);

                    $responseBody = false !== strpos($response->getHeaderLine('Content-Type'), 'application/json')
                        ? $serializer->deserialize((string) $response->getBody(), ErrorResponseBody::class)
                        : new ErrorResponseBody((string) $response->getBody(), [], null);

                    switch ($statusCode) {
                        case 401:
                            throw new UnauthorizedException($request, $response, $responseBody);
                        case 404:
                            throw new NotFoundException($request, $response, $responseBody);
                        case 412:
                            throw new PreconditionFailedException($request, $response, $responseBody);
                        case 428:
                            throw new PreconditionRequiredException($request, $response, $responseBody);
                    }

                    if (500 > $statusCode) {
                        throw new BadRequestException($request, $response, $responseBody);
                    }

                    throw new ServerErrorException($request, $response, $responseBody);
                },
            );
        };
    }
}
