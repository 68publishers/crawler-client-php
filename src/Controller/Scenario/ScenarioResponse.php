<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ScenarioResponseBody;

/**
 * @template-extends AbstractControllerResponse<ScenarioResponseBody>
 */
final class ScenarioResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response, ScenarioResponseBody $body)
    {
        parent::__construct($response, $body);
    }
}
