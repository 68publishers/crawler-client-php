<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class VisitedUrl
{
    public string $identity;

    public string $url;

    public ?string $error = null;

    public ?string $foundOnUrl = null;

    public int $statusCode;
}
