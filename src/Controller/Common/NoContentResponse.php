<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Common;

use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\AbstractControllerResponse;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\NoContentResponseBody;

/**
 * @template-extends AbstractControllerResponse<NoContentResponseBody>
 */
final class NoContentResponse extends AbstractControllerResponse
{
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response, new NoContentResponseBody());
    }
}
