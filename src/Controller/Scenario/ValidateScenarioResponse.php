<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody\ValidateScenarioResponseBody;

/**
 * @template-extends AbstractControllerResponse<ValidateScenarioResponseBody>
 */
final class ValidateScenarioResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response, ValidateScenarioResponseBody $body)
    {
        parent::__construct($response, $body);
    }
}
