<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Bridge\Nette\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use SixtyEightPublishers\CrawlerClient\Authentication\Credentials;
use SixtyEightPublishers\CrawlerClient\Authentication\CredentialsInterface;
use SixtyEightPublishers\CrawlerClient\Bridge\Nette\DI\Config\CrawlerClientConfig;
use SixtyEightPublishers\CrawlerClient\Bridge\Nette\DI\Config\CredentialsConfig;
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\CrawlerClientInterface;
use SixtyEightPublishers\CrawlerClient\Middleware\MiddlewareInterface;
use SixtyEightPublishers\CrawlerClient\Serializer\JmsSerializer;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use function assert;
use function count;

final class CrawlerClientExtension extends CompilerExtension
{
    public function getConfigSchema(): Schema
    {
        $parameters = $this->getContainerBuilder()->parameters;
        $debugMode = $parameters['debugMode'] ?? false;
        $tempDir = $parameters['tempDir'];

        return Expect::structure([
            'crawler_host_url' => Expect::string()->required(),
            'guzzle_config' => Expect::array(),
            'credentials' => Expect::structure([
                'username' => Expect::string()->dynamic(),
                'password' => Expect::string()->dynamic(),
            ])->castTo(CredentialsConfig::class),
            'middlewares' => Expect::listOf(
                Expect::anyOf(Expect::string(), Expect::type(Statement::class))
                    ->before(static function ($factory) {
                        return $factory instanceof Statement ? $factory : new Statement($factory);
                    }),
            ),
            'serializer' => Expect::anyOf(Expect::string(), Expect::type(Statement::class))
                ->default(new Statement([JmsSerializer::class, 'default'], [
                    'cacheDir' => $tempDir . '/cache/68publishers.crawler_client.serializer.cache',
                    'debug' => $debugMode,
                ]))
                ->before(static function ($factory) {
                    return $factory instanceof Statement ? $factory : new Statement($factory);
                }),
        ])->castTo(CrawlerClientConfig::class);
    }

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig();
        assert($config instanceof CrawlerClientConfig);

        $builder->addDefinition($this->prefix('client'))
            ->setType(CrawlerClientInterface::class)
            ->setCreator([CrawlerClient::class, 'create'], [
                'crawlerHostUrl' => $config->crawler_host_url,
                'guzzleConfig' => $config->guzzle_config,
            ]);

        $builder->addDefinition($this->prefix('serializer'))
            ->setType(SerializerInterface::class)
            ->setCreator($config->serializer)
            ->setAutowired(false);

        foreach ($config->middlewares as $index => $middleware) {
            $builder->addDefinition($this->prefix('middleware.' . $index))
                ->setType(MiddlewareInterface::class)
                ->setCreator($middleware)
                ->setAutowired(false);
        }

        if (null !== $config->credentials->username && null !== $config->credentials->password) {
            $builder->addDefinition($this->prefix('credentials'))
                ->setType(CredentialsInterface::class)
                ->setCreator(Credentials::class, [
                    'username' => $config->credentials->username,
                    'password' => $config->credentials->password,
                ])
                ->setAutowired(false);
        }
    }

    public function beforeCompile(): void
    {
        $builder = $this->getContainerBuilder();
        $client = $builder->getDefinition($this->prefix('client'));
        $serializer = $builder->getDefinition($this->prefix('serializer'));
        assert($client instanceof ServiceDefinition && $serializer instanceof ServiceDefinition);

        $credentialsServiceName = $builder->getByType(CredentialsInterface::class);

        if (null === $credentialsServiceName) {
            $credentialsServiceName = $builder->hasDefinition($this->prefix('credentials')) ? $this->prefix('credentials') : null;
        }

        $middlewares = $builder->findByType(MiddlewareInterface::class);

        $clientCreator = $client->getCreator();

        $clientCreator = new Statement([$clientCreator, 'withSerializer'], [
            $serializer,
        ]);

        if (null !== $credentialsServiceName) {
            $clientCreator = new Statement([$clientCreator, 'withAuthentication'], [
                '@' . $credentialsServiceName,
            ]);
        }

        if (count($middlewares)) {
            $clientCreator = new Statement([$clientCreator, 'withMiddlewares'], array_values($middlewares));
        }

        $client->setCreator($clientCreator);
    }
}
