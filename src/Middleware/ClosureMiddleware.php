<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Middleware;

use Closure;

final class ClosureMiddleware implements MiddlewareInterface
{
    private string $name;

    private int $priority;

    private Closure $middleware;

    public function __construct(string $name, int $priority, Closure $middleware)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->middleware = $middleware;
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
        return ($this->middleware)($next);
    }
}
