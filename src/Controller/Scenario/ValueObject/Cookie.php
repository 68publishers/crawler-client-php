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

    public function __construct(
        string $identity,
        string $name,
        string $domain,
        bool $secure,
        bool $session,
        bool $httpOnly,
        ?string $sameSite,
        string $foundOnUrl
    ) {
        $this->identity = $identity;
        $this->name = $name;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->session = $session;
        $this->httpOnly = $httpOnly;
        $this->sameSite = $sameSite;
        $this->foundOnUrl = $foundOnUrl;
    }
}
