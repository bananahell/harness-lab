<?php

declare(strict_types=1);

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase;

final class TaskRepositoryIntegrationTest extends TestCase
{
    public function testDatabaseContainsSeedTask(): void
    {
        $host = getenv('DB_HOST');
        $password = getenv('DB_PASSWORD');

        self::assertIsString($host);
        self::assertIsString($password);

        $pdo = new PDO(
            "sqlsrv:Server={$host},1433;Database=HarnessLab;TrustServerCertificate=1",
            'sa',
            $password,
        );

        $statement = $pdo->query(
            'SELECT COUNT(*) FROM tasks',
        );

        self::assertNotFalse($statement);

        $count = $statement->fetchColumn();

        self::assertSame(1, (int) $count);
    }
}
