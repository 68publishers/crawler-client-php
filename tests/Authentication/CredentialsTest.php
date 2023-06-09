<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Tests\Authentication;

use SixtyEightPublishers\CrawlerClient\Authentication\Credentials;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

final class CredentialsTest extends TestCase
{
    public function testHeaderShouldBeCreated(): void
    {
        $credentials = new Credentials('test-user', 'test-password');

        Assert::same('Basic dGVzdC11c2VyOnRlc3QtcGFzc3dvcmQ=', $credentials->createHeader());
    }
}

(new CredentialsTest())->run();
