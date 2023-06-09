<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use SixtyEightPublishers\CrawlerClient\Authentication\CredentialsInterface;

final class CredentialsFixture implements CredentialsInterface
{
    private string $header;

    public function __construct(string $header)
    {
        $this->header = $header;
    }

    public function createHeader(): string
    {
        return $this->header;
    }
}
