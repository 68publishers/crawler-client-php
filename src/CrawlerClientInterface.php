<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient;

use InvalidArgumentException;
use SixtyEightPublishers\CrawlerClient\Authentication\CredentialsInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerFactoryInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\MiddlewareInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;

interface CrawlerClientInterface
{
    /**
     * @template T of ControllerInterface
     * @param class-string<T> $controllerClassname
     *
     * @return T
     * @throws InvalidArgumentException
     */
    public function getController(string $controllerClassname): ControllerInterface;

    public function withAuthentication(CredentialsInterface $credentials): self;

    public function withMiddlewares(MiddlewareInterface ...$middlewares): self;

    public function withoutMiddlewares(string ...$names): self;

    public function withControllerFactories(ControllerFactoryInterface ...$controllerFactories): self;

    public function withSerializer(SerializerInterface $serializer): self;
}
