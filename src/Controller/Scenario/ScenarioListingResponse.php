<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioListingResponseBody;

/**
 * @template-extends AbstractControllerResponse<ScenarioListingResponseBody>
 */
final class ScenarioListingResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response, ScenarioListingResponseBody $body)
    {
        parent::__construct($response, $body);
    }
}
