<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValueObject;

use DateTimeImmutable;

final class ScenarioSchedulerListingItem
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
}
