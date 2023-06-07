<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Data
{
    public string $identity;

    /** @var array<string, string|array<string>> */
    public array $values = [];

    /** @var array<string, string> */
    public array $foundOnUrl = [];
}
