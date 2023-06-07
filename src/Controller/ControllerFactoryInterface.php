<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;

interface ControllerFactoryInterface
{
    /**
     * @return class-string<ControllerInterface>
     */
    public function getControllerClassname(): string;

    public function create(GuzzleClientInterface $client, SerializerInterface $serializer): ControllerInterface;
}
