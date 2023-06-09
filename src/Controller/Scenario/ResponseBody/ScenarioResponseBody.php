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

    /**
     * @param array<string, string> $flags
     */
    public function __construct(
        string $id,
        ?string $userId,
        ?string $username,
        string $name,
        DateTimeImmutable $createdAt,
        string $status,
        ?string $error,
        array $flags,
        ScenarioConfig $config,
        ScenarioResultsStats $stats,
        ScenarioResults $results
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->status = $status;
        $this->error = $error;
        $this->flags = $flags;
        $this->config = $config;
        $this->stats = $stats;
        $this->results = $results;
    }
}
