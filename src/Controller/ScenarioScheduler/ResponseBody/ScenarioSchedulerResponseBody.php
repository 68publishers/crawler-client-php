<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ResponseBody;

use DateTimeImmutable;
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;

final class ScenarioSchedulerResponseBody
{
    public string $id;

    public string $userId;

    public string $username;

    public string $name;

    public DateTimeImmutable $createdAt;

    public DateTimeImmutable $updatedAt;

    public string $expression;

    /** @var array<string, string> */
    public array $flags = [];

    public ScenarioConfig $config;

    /**
     * @param array<string, string> $flags
     */
    public function __construct(
        string $id,
        string $userId,
        string $username,
        string $name,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        string $expression,
        array $flags,
        ScenarioConfig $config
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->expression = $expression;
        $this->flags = $flags;
        $this->config = $config;
    }
}
