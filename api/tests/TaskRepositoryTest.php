<?php

declare(strict_types=1);

namespace Tests;

use App\TaskRepository;
use PHPUnit\Framework\TestCase;

final class TaskRepositoryTest extends TestCase
{
    public function testReturnsTasks(): void
    {
        $repository = new TaskRepository();

        $tasks = $repository->all();

        self::assertCount(1, $tasks);
        self::assertSame(
            'Learn harness engineering',
            $tasks[0]->title,
        );
    }
}
