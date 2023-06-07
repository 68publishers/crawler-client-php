<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Middleware;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use SixtyEightPublishers\CrawlerClient\Authentication\CredentialsInterface;

final class AuthenticationMiddleware implements MiddlewareInterface
{
    private CredentialsInterface $credentials;

    public function __construct(CredentialsInterface $credentials)
    {
        $this->credentials = $credentials;
    }

    public function getName(): string
    {
        return 'authentication';
    }

    public function __invoke(callable $next): callable
    {
        return function (RequestInterface $request, array $options) use ($next): PromiseInterface {
            $request = $request->withHeader('Authorization', $this->credentials->createHeader());

            return $next($request, $options);
        };
    }
}
