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

    public function __construct(string $identity, string $url, ?string $error, ?string $foundOnUrl, int $statusCode)
    {
        $this->identity = $identity;
        $this->url = $url;
        $this->error = $error;
        $this->foundOnUrl = $foundOnUrl;
        $this->statusCode = $statusCode;
    }
}
