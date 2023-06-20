<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

use DateTimeImmutable;

final class ScenarioListingItem
{
    public string $id;

    public ?string $userId = null;

    public ?string $username = null;

    public string $name;

    public DateTimeImmutable $createdAt;

    public ?DateTimeImmutable $finishedAt = null;

    public string $status;

    public ?string $error = null;

    /** @var array<string, string> */
    public array $flags = [];

    /**
     * @param array<string, string> $flags
     */
    public function __construct(
        string $id,
        ?string $userId,
        ?string $username,
        string $name,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $finishedAt,
        string $status,
        ?string $error,
        array $flags
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->finishedAt = $finishedAt;
        $this->status = $status;
        $this->error = $error;
        $this->flags = $flags;
    }
}
