<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Entrypoint
{
    public string $url;

    public string $scene;

    public function __construct(string $url, string $scene)
    {
        $this->url = $url;
        $this->scene = $scene;
    }
}
