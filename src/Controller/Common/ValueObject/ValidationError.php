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

    /**
     * @param mixed $value
     */
    public function __construct($value, string $msg, string $param, string $location)
    {
        $this->value = $value;
        $this->msg = $msg;
        $this->param = $param;
        $this->location = $location;
    }
}
