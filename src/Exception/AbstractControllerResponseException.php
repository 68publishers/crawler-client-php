<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;
use Throwable;

abstract class AbstractControllerResponseException extends Exception implements ControllerResponseExceptionInterface
{
    private RequestInterface $request;

    private ResponseInterface $response;

    private ErrorResponseBody $responseBody;

    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        ErrorResponseBody $responseBody,
        ?Throwable $previous = null
    ) {
        parent::__construct($responseBody->message, $response->getStatusCode(), $previous);

        $this->request = $request;
        $this->response = $response;
        $this->responseBody = $responseBody;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getResponseBody(): ErrorResponseBody
    {
        return $this->responseBody;
    }
}
