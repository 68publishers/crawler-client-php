<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class ScenarioConfig
{
    /** @var array<string, mixed> */
    public array $options = [];

    public ?string $callbackUri = null;

    /** @var array<string, array<int, Action>> */
    public array $scenes = [];

    public Entrypoint $entrypoint;

    public function __construct(Entrypoint $entrypoint)
    {
        $this->entrypoint = $entrypoint;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function withOptions(array $options): self
    {
        $config = clone $this;
        $config->options = $options;

        return $config;
    }

    public function withCallbackUri(?string $callbackUri): self
    {
        $config = clone $this;
        $config->callbackUri = $callbackUri;

        return $config;
    }

    /**
     * @param array<int, Action> $actions
     */
    public function withScene(string $name, array $actions): self
    {
        $config = clone $this;
        $config->scenes[$name] = $actions;

        return $config;
    }
}
