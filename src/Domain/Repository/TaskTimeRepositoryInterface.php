<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\TaskTime;

interface TaskTimeRepositoryInterface
{
    public function getLastByTaskId(int $taskId) : ?TaskTime;
    public function create(TaskTime $taskTime): TaskTime;
    public function update(TaskTime $taskTime): bool;
    public function getAllByTaskId(int $taskId): array;
}
