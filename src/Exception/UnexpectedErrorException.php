<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Exception;

use Exception;
use Throwable;

final class UnexpectedErrorException extends Exception implements ControllerExceptionInterface
{
    public function __construct(Throwable $previous)
    {
        parent::__construct('Controller thrown an unexpected exception: ' . $previous->getMessage(), $previous->getCode(), $previous);
    }
}
