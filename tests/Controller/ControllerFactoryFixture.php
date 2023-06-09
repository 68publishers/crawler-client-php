<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Controller;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerFactoryInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;

final class ControllerFactoryFixture implements ControllerFactoryInterface
{
    public int $numberOfCreatedControllers = 0;

    public function getControllerClassname(): string
    {
        return ControllerFixture::class;
    }

    public function create(GuzzleClientInterface $client, SerializerInterface $serializer): ControllerInterface
    {
        ++$this->numberOfCreatedControllers;

        return new ControllerFixture($client, $serializer);
    }
}
