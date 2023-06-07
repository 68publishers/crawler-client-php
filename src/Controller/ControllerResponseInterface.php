<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller;

use Psr\Http\Message\ResponseInterface;

interface ControllerResponseInterface
{
    public function getStatusCode(): int;

    public function getResponse(): ResponseInterface;

    /**
     * @return mixed
     */
    public function getBody();
}
