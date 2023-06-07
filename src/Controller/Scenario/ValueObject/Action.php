<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Action
{
    public string $action;

    /** @var array<string, mixed> */
    public array $options = [];

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(string $action, array $options)
    {
        $this->action = $action;
        $this->options = $options;
    }
}
