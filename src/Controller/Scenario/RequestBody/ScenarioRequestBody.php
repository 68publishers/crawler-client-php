<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody;

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;

final class ScenarioRequestBody
{
    public string $name;

    /** @var array<string, string> */
    public array $flags;

    /** @var ScenarioConfig|array<string, mixed> */
    public $config;

    /**
     * @param array<string, string>               $flags
     * @param ScenarioConfig|array<string, mixed> $config
     */
    public function __construct(
        string $name,
        array $flags,
        $config
    ) {
        $this->name = $name;
        $this->flags = $flags;
        $this->config = $config;
    }
}
