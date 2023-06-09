<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Bridge\Nette\DI\Config;

use Nette\DI\Definitions\Statement;

final class CrawlerClientConfig
{
    public string $crawler_host_url;

    /** @var array<string, mixed> */
    public array $guzzle_config = [];

    public CredentialsConfig $credentials;

    /** @var array<int, Statement> */
    public array $middlewares = [];

    public Statement $serializer;
}
