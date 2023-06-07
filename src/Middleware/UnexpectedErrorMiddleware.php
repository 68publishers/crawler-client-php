<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Middleware;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use SixtyEightPublishers\CrawlerClient\Exception\ControllerExceptionInterface;
use SixtyEightPublishers\CrawlerClient\Exception\UnexpectedErrorException;
use Throwable;

final class UnexpectedErrorMiddleware implements MiddlewareInterface
{
    public function getName(): string
    {
        return 'unexpected_error';
    }

    public function __invoke(callable $next): callable
    {
        return static function (RequestInterface $request, array $options) use ($next): PromiseInterface {
            try {
                return $next($request, $options);
            } catch (Throwable $e) {
                throw ($e instanceof ControllerExceptionInterface ? $e : new UnexpectedErrorException($e));
            }
        };
    }
}
