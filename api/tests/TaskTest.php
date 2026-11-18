<?php

declare(strict_types=1);

namespace Tests;

use App\Task;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TaskTest extends TestCase
{
    public function testTaskCanBeConvertedToArray(): void
    {
        $task = new Task(
            id: 1,
            title: 'Learn harness engineering',
            completed: false,
        );

        self::assertSame(
            [
                'id' => 1,
                'title' => 'Learn harness engineering',
                'completed' => false,
            ],
            $task->toArray(),
        );
    }
}
