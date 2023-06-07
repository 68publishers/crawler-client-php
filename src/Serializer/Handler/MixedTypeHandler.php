<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Serializer\Handler;

use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Visitor\SerializationVisitorInterface;

final class MixedTypeHandler implements SubscribingHandlerInterface
{
    /**
     * @return array<int, array<string, scalar>>
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'mixed',
                'method' => 'deserialize',
            ],
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'mixed',
                'method' => 'serialize',
            ],
        ];
    }

    /**
     * @param mixed        $data
     * @param array<mixed> $type
     *
     * @return mixed
     */
    public function deserialize(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        return $data;
    }

    /**
     * @param mixed        $data
     * @param array<mixed> $type
     *
     * @return mixed
     */
    public function serialize(SerializationVisitorInterface $visitor, $data, array $type, SerializationContext $context)
    {
        return $data;
    }
}
