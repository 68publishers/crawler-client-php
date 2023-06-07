<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Serializer;

use DateTimeInterface;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface as JmsSerializerInterface;
use SixtyEightPublishers\CrawlerClient\Controller\Common\CommonMetadataPaths;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenariosMetadataPaths;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulersMetadataPaths;
use SixtyEightPublishers\CrawlerClient\Serializer\Handler\MixedTypeHandler;
use SixtyEightPublishers\CrawlerClient\Serializer\Handler\ScenarioConfigHandler;
use function array_merge;
use function assert;

final class JmsSerializer implements SerializerInterface
{
    private JmsSerializerInterface $serializer;

    public function __construct(JmsSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function default(?string $cacheDir = null, bool $debug = false): self
    {
        return new self(
            self::createDefaultSerializerBuilder($cacheDir, $debug)->build(),
        );
    }

    public static function createDefaultSerializerBuilder(?string $cacheDir = null, bool $debug = false): SerializerBuilder
    {
        $builder = SerializerBuilder::create()
            ->setDebug($debug)
            ->setSerializationContextFactory(static function () {
                return SerializationContext::create()
                    ->setSerializeNull(false);
            })
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());

        $metadataPaths = array_merge(
            CommonMetadataPaths::PATHS,
            ScenariosMetadataPaths::PATHS,
            ScenarioSchedulersMetadataPaths::PATHS,
        );

        foreach ($metadataPaths as $path => $namespacePrefix) {
            $builder->addMetadataDir($path, $namespacePrefix);
        }

        $builder->configureHandlers(function (HandlerRegistryInterface $registry) {
            $registry->registerSubscribingHandler(new DateHandler(DateTimeInterface::RFC3339_EXTENDED));
            $registry->registerSubscribingHandler(new MixedTypeHandler());
            $registry->registerSubscribingHandler(new ScenarioConfigHandler());
        });

        if (null !== $cacheDir) {
            $builder->setCacheDir($cacheDir);
        }

        return $builder;
    }

    public function serialize(object $object): string
    {
        return $this->serializer->serialize($object, 'json');
    }

    public function deserialize(string $json, string $classname)
    {
        $object = $this->serializer->deserialize($json, $classname, 'json');
        assert($object instanceof $classname);

        return $object;
    }
}
