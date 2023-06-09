<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Serializer;

use ReflectionClass;
use ReflectionException;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use function json_encode;

final class SerializerFixture implements SerializerInterface
{
    public function serialize(object $object): string
    {
        return json_encode($object);
    }

    /**
     * @throws ReflectionException
     */
    public function deserialize(string $json, string $classname)
    {
        return (new ReflectionClass($classname))->newInstanceWithoutConstructor();
    }
}
