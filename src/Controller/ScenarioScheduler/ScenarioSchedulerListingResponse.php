<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerListingResponseBody;

/**
 * @template-extends AbstractControllerResponse<ScenarioSchedulerListingResponseBody>
 */
final class ScenarioSchedulerListingResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response, ScenarioSchedulerListingResponseBody $body)
    {
        parent::__construct($response, $body);
    }
}
