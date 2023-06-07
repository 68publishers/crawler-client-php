<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;

final class DefaultControllerFactory implements ControllerFactoryInterface
{
    /** @var class-string<ControllerInterface> */
    private string $classname;

    /**
     * @param class-string<ControllerInterface> $classname
     */
    public function __construct(string $classname)
    {
        $this->classname = $classname;
    }

    public function getControllerClassname(): string
    {
        return $this->classname;
    }

    public function create(GuzzleClientInterface $client, SerializerInterface $serializer): ControllerInterface
    {
        return new $this->classname($client, $serializer);
    }
}
