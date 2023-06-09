<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use Psr\Http\Message\RequestInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\MiddlewareInterface;

final class MiddlewareFixture implements MiddlewareInterface
{
    private string $name;

    private int $priority;

    public function __construct(string $name, int $priority)
    {
        $this->name = $name;
        $this->priority = $priority;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function __invoke(callable $next): callable
    {
        return function (RequestInterface $request, array $options) use ($next) {
            return $next($request, $options);
        };
    }
}
