<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use GuzzleHttp\Client as GuzzleClient;
use SixtyEightPublishers\CrawlerClient\Controller\DefaultControllerFactory;
use SixtyEightPublishers\CrawlerClient\Tests\Controller\ControllerFixture;
use SixtyEightPublishers\CrawlerClient\Tests\Serializer\SerializerFixture;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class DefaultControllerFactoryTest extends TestCase
{
    public function testControllerShouldCreated(): void
    {
        $client = new GuzzleClient();
        $serializer = new SerializerFixture();
        $factory = new DefaultControllerFactory(ControllerFixture::class);

        $controller = $factory->create($client, $serializer);

        Assert::same($client, $controller->client);
        Assert::same($serializer, $controller->serializer);
    }
}

(new DefaultControllerFactoryTest())->run();
