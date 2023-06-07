<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ResponseBody;

use DateTimeImmutable;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioResults;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioResultsStats;

final class ScenarioResponseBody
{
    public string $id;

    public ?string $userId = null;

    public ?string $username = null;

    public string $name;

    public DateTimeImmutable $createdAt;

    public string $status;

    public ?string $error = null;

    /** @var array<string, string> */
    public array $flags = [];

    public ScenarioConfig $config;

    public ScenarioResultsStats $stats;

    public ScenarioResults $results;
}
