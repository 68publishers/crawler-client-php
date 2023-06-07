<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Middleware;

interface MiddlewareInterface
{
    public function getName(): string;

    public function __invoke(callable $next): callable;
}
