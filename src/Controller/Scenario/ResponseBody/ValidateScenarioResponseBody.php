<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ValidationError;

final class ValidateScenarioResponseBody
{
    public bool $valid;

    public string $message;

    /** @var array<int, ValidationError> */
    public array $errors = [];

    /**
     * @param array<int, ValidationError> $errors
     */
    public function __construct(bool $valid, string $message, array $errors)
    {
        $this->valid = $valid;
        $this->message = $message;
        $this->errors = $errors;
    }
}
