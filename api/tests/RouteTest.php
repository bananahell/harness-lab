<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class RouteTest extends TestCase
{
    public function testUnknownRouteReturnsJsonNotFound(): void
    {
        [$status, $body] = $this->request('GET', '/missing');

        self::assertSame(404, $status);
        self::assertSame(
            ['status' => 'error', 'message' => 'Not Found'],
            json_decode($body, true, flags: JSON_THROW_ON_ERROR),
        );
    }

    public function testTasksRejectsNonGetMethods(): void
    {
        [$status, $body] = $this->request('POST', '/tasks');

        self::assertSame(405, $status);
        self::assertSame(
            ['status' => 'error', 'message' => 'Method Not Allowed'],
            json_decode($body, true, flags: JSON_THROW_ON_ERROR),
        );
    }

    public function testRootRejectsNonGetMethods(): void
    {
        [$status, $body] = $this->request('POST', '/');

        self::assertSame(405, $status);
        self::assertSame(
            ['status' => 'error', 'message' => 'Method Not Allowed'],
            json_decode($body, true, flags: JSON_THROW_ON_ERROR),
        );
    }

    /** @return array{int, string} */
    private function request(string $method, string $uri): array
    {
        $previousMethod = $_SERVER['REQUEST_METHOD'] ?? null;
        $previousUri = $_SERVER['REQUEST_URI'] ?? null;
        $previousStatus = http_response_code();

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;
        http_response_code(200);

        ob_start();

        try {
            include __DIR__.'/../public/index.php';
            $body = ob_get_contents();
            $status = http_response_code();
        } finally {
            ob_end_clean();

            if (\is_int($previousStatus)) {
                http_response_code($previousStatus);
            } else {
                http_response_code(200);
            }

            if (null === $previousMethod) {
                unset($_SERVER['REQUEST_METHOD']);
            } else {
                $_SERVER['REQUEST_METHOD'] = $previousMethod;
            }

            if (null === $previousUri) {
                unset($_SERVER['REQUEST_URI']);
            } else {
                $_SERVER['REQUEST_URI'] = $previousUri;
            }
        }

        self::assertIsString($body);
        self::assertIsInt($status);

        return [$status, $body];
    }
}
