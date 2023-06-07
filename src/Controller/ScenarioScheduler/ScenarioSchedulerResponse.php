<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody\ScenarioSchedulerResponseBody;
use function count;

/**
 * @template-extends AbstractControllerResponse<ScenarioSchedulerResponseBody>
 */
final class ScenarioSchedulerResponse extends AbstractControllerResponse
{
    private string $etag;

    public function __construct(ResponseInterface $response, ScenarioSchedulerResponseBody $body)
    {
        parent::__construct($response, $body);

        $etagHeaders = $response->getHeader('ETag');
        $this->etag = 0 < count($etagHeaders) ? $etagHeaders[0] : '';
    }

    public function getEtag(): string
    {
        return $this->etag;
    }
}
