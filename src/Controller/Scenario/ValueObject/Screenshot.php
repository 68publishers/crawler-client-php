<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Screenshot
{
    public string $identity;

    public string $name;

    public string $foundOnUrl;

    public string $screenshot;

    public function __construct(
        string $identity,
        string $name,
        string $foundOnUrl,
        string $screenshot
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->foundOnUrl = $foundOnUrl;
        $this->screenshot = $screenshot;
    }
}
