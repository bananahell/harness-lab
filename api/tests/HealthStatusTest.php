<?php

declare(strict_types=1);

namespace Tests;

use App\HealthStatus;
use PHPUnit\Framework\TestCase;

final class HealthStatusTest extends TestCase
{
    public function testOkContainsDatabaseVersion(): void
    {
        $result = HealthStatus::ok('SQL Server 2022');

        self::assertSame('ok', $result['status']);
        self::assertSame('SQL Server 2022', $result['db']);
    }

    public function testErrorContainsMessage(): void
    {
        $result = HealthStatus::error('boom');

        self::assertSame('error', $result['status']);
        self::assertSame('boom', $result['message']);
    }
}
