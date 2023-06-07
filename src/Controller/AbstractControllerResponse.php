<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * @template T of object
 */
abstract class AbstractControllerResponse implements ControllerResponseInterface
{
    protected ResponseInterface $response;

    /** @var T */
    protected $body;

    /**
     * @param T $body
     */
    public function __construct(ResponseInterface $response, $body)
    {
        $this->response = $response;
        $this->body = $body;
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return T
     */
    public function getBody()
    {
        return $this->body;
    }
}
