<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Serializer;

interface SerializerInterface
{
    public function serialize(object $object): string;

    /**
     * @template T
     * @param class-string<T> $classname
     *
     * @return T
     */
    public function deserialize(string $json, string $classname);
}
