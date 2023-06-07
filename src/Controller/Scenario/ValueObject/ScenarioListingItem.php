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

    public string $status;

    public ?string $error = null;

    /** @var array<string, string> */
    public array $flags = [];
}
