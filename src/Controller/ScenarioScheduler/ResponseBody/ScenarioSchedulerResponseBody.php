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
}
