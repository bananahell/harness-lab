<?php
header('Content-Type: application/json');
try {
    $pdo = new PDO(
        'sqlsrv:Server=' . getenv('DB_HOST') . ',1433;TrustServerCertificate=1',
        'sa',
        getenv('DB_PASSWORD')
    );
    $version = $pdo->query('SELECT @@VERSION')->fetchColumn();
    echo json_encode(['status' => 'ok', 'db' => $version]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
