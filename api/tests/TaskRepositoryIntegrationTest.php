<?php

declare(strict_types=1);

namespace Tests;

use App\TaskRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class TaskRepositoryIntegrationTest extends TestCase
{
    public function testAllReturnsSeedTask(): void
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

        $tasks = (new TaskRepository($pdo))->all();

        self::assertCount(1, $tasks);
        self::assertSame('Learn harness engineering', $tasks[0]->title);
        self::assertFalse($tasks[0]->completed);
    }
}
