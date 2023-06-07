<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Cookie
{
    public string $identity;

    public string $name;

    public string $domain;

    public bool $secure;

    public bool $session;

    public bool $httpOnly;

    public ?string $sameSite = null;

    public string $foundOnUrl;
}
