<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Authentication;

use function base64_encode;

final class Credentials implements CredentialsInterface
{
    private string $username;

    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function createHeader(): string
    {
        return 'Basic ' . base64_encode($this->username . ':' . $this->password);
    }
}
