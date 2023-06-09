<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Bridge\Nette\DI;

use Nette\Bootstrap\Configurator;
use Nette\DI\Container;
use Tester\Helpers;
use function sys_get_temp_dir;
use function uniqid;

final class ContainerFactory
{
    private function __construct() {}

    /**
     * @param string|array<string> $configFiles
     */
    public static function create($configFiles, bool $debug = true): Container
    {
        $tempDir = sys_get_temp_dir() . '/' . uniqid('68publishers:CrawlerClientPhp', true);

        Helpers::purge($tempDir);

        $configurator = new Configurator();
        $configurator->setTempDirectory($tempDir);
        $configurator->setDebugMode($debug);

        foreach ((array) $configFiles as $configFile) {
            $configurator->addConfig($configFile);
        }

        return $configurator->createContainer();
    }
}
