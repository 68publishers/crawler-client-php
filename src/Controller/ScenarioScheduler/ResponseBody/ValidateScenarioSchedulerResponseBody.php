<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody;

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ValidationError;

final class ValidateScenarioSchedulerResponseBody
{
    public bool $valid;

    public string $message;

    /** @var array<int, ValidationError> */
    public array $errors = [];
}
