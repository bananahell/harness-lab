<?php

declare(strict_types=1);

use App\HealthStatus;
use App\Task;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

if (!is_string($requestUri)) {
    throw new RuntimeException('REQUEST_URI must be a string');
}

$path = parse_url($requestUri, PHP_URL_PATH);

if ($path === '/tasks') {
    echo json_encode([
        (new Task(
            id: 1,
            title: 'Learn harness engineering',
            completed: false,
        ))->toArray(),
    ]);

    exit;
}

try {
    $host = getenv('DB_HOST');
    $password = getenv('DB_PASSWORD');

    if ($host === false || $password === false) {
        throw new RuntimeException('DB_HOST and DB_PASSWORD must be set');
    }

    $pdo = new PDO(
        "sqlsrv:Server={$host},1433;TrustServerCertificate=1",
        'sa',
        $password,
    );

    $statement = $pdo->query('SELECT @@VERSION');

    if ($statement === false) {
        throw new RuntimeException('Version query failed');
    }

    echo json_encode(
        HealthStatus::ok(
            (string) $statement->fetchColumn(),
        ),
    );
} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode(
        HealthStatus::error($e->getMessage()),
    );
}
