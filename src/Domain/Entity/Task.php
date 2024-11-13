<?php

namespace Src\Domain\Entity;

use JsonSerializable;

class Task implements JsonSerializable
{
    public int $id;
    private string $name;
    private array $taskTimes = [];

    public function __construct(int $id, string $name, $taskTimes = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->taskTimes = $taskTimes;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTaskTimes(): array
    {
        return $this->taskTimes;
    }

    public function addTaskTime(TaskTime $timeEntry): void
    {
        $this->taskTimes[] = $timeEntry;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'taskTimes' => $this->getTaskTimes()
        ];
    }
}
