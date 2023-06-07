<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Authentication;

interface CredentialsInterface
{
    public function createHeader(): string;
}
