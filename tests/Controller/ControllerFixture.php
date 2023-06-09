<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Controller;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;

final class ControllerFixture implements ControllerInterface
{
    public GuzzleClientInterface $client;

    public SerializerInterface $serializer;

    public function __construct(GuzzleClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }
}
