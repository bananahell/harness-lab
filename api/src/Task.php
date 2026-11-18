<?php

declare(strict_types=1);

namespace App;

final readonly class Task
{
    public function __construct(
        public int $id,
        public string $title,
        public bool $completed,
    ) {}

    /** @return array{id:int,title:string,completed:bool} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed,
        ];
    }
}
