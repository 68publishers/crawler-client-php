<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;

interface ControllerResponseExceptionInterface extends ControllerExceptionInterface
{
    public function getRequest(): RequestInterface;

    public function getResponse(): ResponseInterface;

    public function getResponseBody(): ErrorResponseBody;
}
