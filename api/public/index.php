<?php

declare(strict_types=1);

use App\HealthStatus;
use App\TaskRepository;

require __DIR__.'/../vendor/autoload.php';

header('Content-Type: application/json');

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

if (!is_string($requestUri)) {
    throw new RuntimeException('REQUEST_URI must be a string');
}

$path = parse_url($requestUri, PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!is_string($requestMethod)) {
    throw new RuntimeException('REQUEST_METHOD must be a string');
}

if ('/' !== $path && '/tasks' !== $path) {
    http_response_code(404);

    echo json_encode(
        HealthStatus::error('Not Found'),
    );

    return;
}

if ('GET' !== $requestMethod) {
    header('Allow: GET');
    http_response_code(405);

    echo json_encode(
        HealthStatus::error('Method Not Allowed'),
    );

    return;
}

try {
    $host = getenv('DB_HOST');
    $password = getenv('DB_PASSWORD');

    if (false === $host || false === $password) {
        throw new RuntimeException('DB_HOST and DB_PASSWORD must be set');
    }

    $pdo = new PDO(
        "sqlsrv:Server={$host},1433;Database=HarnessLab;TrustServerCertificate=1",
        'sa',
        $password,
    );

    if ('/tasks' === $path) {
        $repository = new TaskRepository($pdo);

        echo json_encode(
            array_map(
                static fn ($task): array => $task->toArray(),
                $repository->all(),
            ),
        );

        exit;
    }

    $statement = $pdo->query('SELECT @@VERSION');

    if (false === $statement) {
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
