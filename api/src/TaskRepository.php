<?php

declare(strict_types=1);

namespace App;

final class TaskRepository
{
    /** @return list<Task> */
    public function all(): array
    {
        return [
            new Task(
                id: 1,
                title: 'Learn harness engineering',
                completed: false,
            ),
        ];
    }
}
