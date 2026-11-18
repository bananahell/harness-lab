<?php

declare(strict_types=1);

namespace App;

final readonly class TaskRepository
{
    public function __construct(
        private \PDO $pdo,
    ) {}

    /** @return list<Task> */
    public function all(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, title, completed FROM tasks ORDER BY id',
        );

        if (!$statement instanceof \PDOStatement) {
            throw new \RuntimeException('Task query failed');
        }

        $tasks = [];

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            if (!isset(
                $row['id'],
                $row['title'],
                $row['completed'],
            )) {
                throw new \RuntimeException('Malformed task row');
            }

            $id = $row['id'];
            $title = $row['title'];
            $completed = $row['completed'];

            if (
                !\is_scalar($id)
                || !\is_scalar($title)
                || !\is_scalar($completed)
            ) {
                throw new \RuntimeException('Malformed task row');
            }

            $tasks[] = new Task(
                id: (int) $id,
                title: (string) $title,
                completed: (bool) $completed,
            );
        }

        return $tasks;
    }
}
