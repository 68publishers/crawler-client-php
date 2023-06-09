<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests;

use InvalidArgumentException;
use function file_exists;
use function sprintf;

final class FileFixtureHelper
{
    private string $baseDir;

    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getRaw(string $name): string
    {
        $contentFile = $this->baseDir . '/' . $name . '.txt';

        if (!file_exists($contentFile)) {
            $contentFile = $this->baseDir . '/' . $name . '.json';
        }

        if (!file_exists($contentFile)) {
            throw new InvalidArgumentException(sprintf(
                'Missing content file %s/%s.(txt|json)',
                $this->baseDir,
                $name,
            ));
        }

        return (string) file_get_contents($contentFile);
    }

    public function getPhp(string $name)
    {
        $contentFile = $this->baseDir . '/' . $name . '.php';

        if (!file_exists($contentFile)) {
            throw new InvalidArgumentException(sprintf(
                'Missing content file %s/%s.php',
                $this->baseDir,
                $name,
            ));
        }

        return (require $contentFile);
    }
}
