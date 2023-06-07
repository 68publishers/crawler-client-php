<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ValidationError;

final class ErrorResponseBody
{
    public string $message;

    /** @var array<int, ValidationError> */
    public array $errors = [];

    public ?string $stack = null;

    /**
     * @param array<int, ValidationError> $errors
     */
    public function __construct(string $message, array $errors, ?string $stack)
    {
        $this->message = $message;
        $this->errors = $errors;
        $this->stack = $stack;
    }
}
