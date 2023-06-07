<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject;

final class ValidationError
{
    /** @var mixed */
    public $value;

    public string $msg;

    public string $param;

    public string $location;
}
