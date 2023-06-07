<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Serializer\Handler;

use ArrayObject;
use JMS\Serializer\Exception\SkipHandlerException;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Visitor\SerializationVisitorInterface;
use function is_array;

abstract class ObjectOrArrayHandler implements SubscribingHandlerInterface
{
    /**
     * @return array<int, array<string, scalar>>
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => static::getType(),
                'method' => 'serialize',
            ],
        ];
    }

    /**
     * @param mixed        $data
     * @param array<mixed> $type
     *
     * @return array<string, mixed>|ArrayObject<string, mixed>
     */
    public function serialize(SerializationVisitorInterface $visitor, $data, array $type, SerializationContext $context)
    {
        if (!is_array($data)) {
            throw new SkipHandlerException();
        }

        return $visitor->visitArray($data, $type);
    }

    abstract protected static function getType(): string;
}
