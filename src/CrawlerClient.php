<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\HandlerStack;
use InvalidArgumentException;
use SixtyEightPublishers\CrawlerClient\Authentication\CredentialsInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerFactoryInterface;
use SixtyEightPublishers\CrawlerClient\Controller\ControllerInterface;
use SixtyEightPublishers\CrawlerClient\Controller\DefaultControllerFactory;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenariosController;
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulersController;
use SixtyEightPublishers\CrawlerClient\Middleware\AuthenticationMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\MiddlewareInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\ResponseExceptionMiddleware;
use SixtyEightPublishers\CrawlerClient\Middleware\UnexpectedErrorMiddleware;
use SixtyEightPublishers\CrawlerClient\Serializer\JmsSerializer;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use function array_combine;
use function array_map;
use function array_merge;
use function array_values;
use function in_array;
use function ltrim;
use function sprintf;
use function usort;

final class CrawlerClient implements CrawlerClientInterface
{
    /** @var array<string, mixed> */
    private array $guzzleConfig;

    /** @var array<int, MiddlewareInterface> */
    private array $middlewares;

    /** @var array<class-string<ControllerInterface>, ControllerFactoryInterface> */
    private array $controllerFactories;

    private ?GuzzleClientInterface $guzzleClient = null;

    private ?SerializerInterface $serializer;

    /** @var array<class-string<ControllerInterface>, ControllerInterface> */
    private array $controllers = [];

    /**
     * @param array<string, mixed>                                                 $guzzleConfig
     * @param array<int, MiddlewareInterface>                                      $middlewares
     * @param array<class-string<ControllerInterface>, ControllerFactoryInterface> $controllerFactories
     */
    private function __construct(array $guzzleConfig, array $middlewares, array $controllerFactories, ?SerializerInterface $serializer)
    {
        $guzzleConfig['serializer_getter'] = function () {
            return $this->getSerializer();
        };

        $this->guzzleConfig = $guzzleConfig;
        $this->middlewares = $middlewares;
        $this->controllerFactories = $controllerFactories;
        $this->serializer = $serializer;
    }

    /**
     * @param array<string, mixed> $guzzleConfig
     */
    public static function create(string $crawlerHostUrl, array $guzzleConfig = []): self
    {
        $crawlerHostUrl = ltrim($crawlerHostUrl, '/') . '/api/';

        $guzzleConfig['base_uri'] = $crawlerHostUrl;
        $guzzleConfig['http_errors'] = false; # custom exceptions middlewares

        return new self($guzzleConfig, [
            new UnexpectedErrorMiddleware(),
            new ResponseExceptionMiddleware(),
        ], [
            ScenariosController::class => new DefaultControllerFactory(ScenariosController::class),
            ScenarioSchedulersController::class => new DefaultControllerFactory(ScenarioSchedulersController::class),
        ], null);
    }

    public function getController(string $controllerClassname): ControllerInterface
    {
        if (isset($this->controllers[$controllerClassname])) {
            return $this->controllers[$controllerClassname]; // @phpstan-ignore-line
        }

        if (!isset($this->controllerFactories[$controllerClassname])) {
            throw new InvalidArgumentException(sprintf(
                'Factory for controller of type %s is not defined.',
                $controllerClassname,
            ));
        }

        // @phpstan-ignore-next-line
        return $this->controllers[$controllerClassname] = $this->controllerFactories[$controllerClassname]->create(
            $this->getGuzzleClient(),
            $this->getSerializer(),
        );
    }

    public function withAuthentication(CredentialsInterface $credentials): CrawlerClientInterface
    {
        return $this->withMiddlewares(new AuthenticationMiddleware($credentials));
    }

    public function withMiddlewares(MiddlewareInterface ...$middlewares): CrawlerClientInterface
    {
        $currentMiddlewares = $this->middlewares;
        $newMiddlewaresNames = array_map(static fn (MiddlewareInterface $middleware): string => $middleware->getName(), $middlewares);
        $newMiddlewares = array_combine($newMiddlewaresNames, $middlewares);

        foreach ($currentMiddlewares as $index => $currentMiddleware) {
            if (in_array($currentMiddleware->getName(), $newMiddlewaresNames, true)) {
                $currentMiddlewares[$index] = $newMiddlewares[$currentMiddleware->getName()];
                unset($newMiddlewares[$currentMiddleware->getName()]);
            }
        }

        return new self(
            $this->guzzleConfig,
            array_merge(
                array_values($currentMiddlewares),
                array_values($newMiddlewares),
            ),
            $this->controllerFactories,
            $this->serializer,
        );
    }

    public function withoutMiddlewares(string ...$names): CrawlerClientInterface
    {
        $newMiddlewares = [];

        foreach ($this->middlewares as $middleware) {
            if (!in_array($middleware->getName(), $names, true)) {
                $newMiddlewares[] = $middleware;
            }
        }

        return new self($this->guzzleConfig, $newMiddlewares, $this->controllerFactories, $this->serializer);
    }

    public function withControllerFactories(ControllerFactoryInterface ...$controllerFactories): CrawlerClientInterface
    {
        $factories = $this->controllerFactories;

        foreach ($controllerFactories as $controllerFactory) {
            $factories[$controllerFactory->getControllerClassname()] = $controllerFactory;
        }

        return new self($this->guzzleConfig, $this->middlewares, $factories, $this->serializer);
    }

    public function withSerializer(SerializerInterface $serializer): CrawlerClientInterface
    {
        return new self($this->guzzleConfig, $this->middlewares, $this->controllerFactories, $serializer);
    }

    private function getGuzzleClient(): GuzzleClientInterface
    {
        if (null !== $this->guzzleClient) {
            return $this->guzzleClient;
        }

        $guzzleConfig = $this->guzzleConfig;
        $handlerStack = $guzzleConfig['handler'] ?? null;
        $handlerStack = $handlerStack instanceof HandlerStack ? clone $handlerStack : HandlerStack::create();

        $guzzleConfig['handler'] = $handlerStack;
        $middlewares = $this->middlewares;

        usort(
            $middlewares,
            static fn (MiddlewareInterface $left, MiddlewareInterface $right): int => $right->getPriority() <=> $left->getPriority(),
        );

        foreach ($middlewares as $middleware) {
            $handlerStack->push($middleware, $middleware->getName());
        }

        return $this->guzzleClient = new GuzzleClient($guzzleConfig);
    }

    private function getSerializer(): SerializerInterface
    {
        if (null === $this->serializer) {
            $this->serializer = JmsSerializer::default();
        }

        return $this->serializer;
    }
}
