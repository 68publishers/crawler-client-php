<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject;

final class Data
{
    public string $identity;

    /** @var array<string, string|array<string>> */
    public array $values = [];

    /** @var array<string, string> */
    public array $foundOnUrl = [];

    /**
     * @param array<string, string|array<string>> $values
     * @param array<string, string>               $foundOnUrl
     */
    public function __construct(string $identity, array $values, array $foundOnUrl)
    {
        $this->identity = $identity;
        $this->values = $values;
        $this->foundOnUrl = $foundOnUrl;
    }
}
