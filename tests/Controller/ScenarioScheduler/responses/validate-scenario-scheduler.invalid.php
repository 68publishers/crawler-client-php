<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ValidationError;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ValidateScenarioSchedulerResponseBody;

return new ValidateScenarioSchedulerResponseBody(true, 'OK', [
    new ValidationError('some value', 'Invalid value for field "callbackUri"', 'callbackUri', 'body'),
]);
