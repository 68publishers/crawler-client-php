<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Serializer\Handler;

use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;

final class ScenarioConfigHandler extends ObjectOrArrayHandler
{
    protected static function getType(): string
    {
        return ScenarioConfig::class;
    }
}
