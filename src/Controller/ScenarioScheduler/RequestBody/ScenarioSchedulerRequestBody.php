<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody;

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;

final class ScenarioSchedulerRequestBody
{
    public string $name;

    /** @var array<string, string> */
    public array $flags;

    public bool $active;

    public string $expression;

    /** @var ScenarioConfig|array<string, mixed> */
    public $config;

    /**
     * @param array<string, string>               $flags
     * @param ScenarioConfig|array<string, mixed> $config
     */
    public function __construct(
        string $name,
        array $flags,
        bool $active,
        string $expression,
        $config
    ) {
        $this->name = $name;
        $this->flags = $flags;
        $this->active = $active;
        $this->expression = $expression;
        $this->config = $config;
    }
}
