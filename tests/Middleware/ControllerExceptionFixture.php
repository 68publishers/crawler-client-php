<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Middleware;

use Exception;
use SixtyEightPublishers\CrawlerClient\Exception\ControllerExceptionInterface;

final class ControllerExceptionFixture extends Exception implements ControllerExceptionInterface
{
}
