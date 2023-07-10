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

    public bool $active;

    public string $expression;

    /** @var array<string, string> */
    public array $flags = [];

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
        bool $active,
        string $expression,
        array $flags
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->active = $active;
        $this->expression = $expression;
        $this->flags = $flags;
    }
}
