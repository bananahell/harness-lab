<?php

declare(strict_types=1);

namespace App;

final class HealthStatus
{
    /** @return array{status: string, db: string} */
    public static function ok(string $dbVersion): array
    {
        return ['status' => 'ok', 'db' => $dbVersion];
    }

    /** @return array{status: string, message: string} */
    public static function error(string $message): array
    {
        return ['status' => 'error', 'message' => $message];
    }
}
