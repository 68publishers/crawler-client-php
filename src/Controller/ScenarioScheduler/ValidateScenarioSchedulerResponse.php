<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ValidateScenarioSchedulerResponseBody;

/**
 * @template-extends AbstractControllerResponse<ValidateScenarioSchedulerResponseBody>
 */
final class ValidateScenarioSchedulerResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response, ValidateScenarioSchedulerResponseBody $body)
    {
        parent::__construct($response, $body);
    }
}
