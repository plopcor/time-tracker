<?php

namespace Src\Infrastructure\Persistence\Eloquent;

use Src\Domain\Entity\TaskTime;
use Src\Domain\Repository\TaskTimeRepositoryInterface;

class EloquentTaskTimeRepository implements TaskTimeRepositoryInterface
{

    public function getLastByTaskId(int $taskId): ?TaskTime
    {
        $taskTimeObj = \App\Models\TaskTime::where('task_id', $taskId)->whereNull('end_at')->orderBy('start_at', 'desc')->first();
        if (!$taskTimeObj)
            return null;

        return new TaskTime($taskTimeObj->task_id, $taskTimeObj->id, $taskTimeObj->start_at);
    }

    public function create(TaskTime $taskTime): TaskTime
    {
        $taskTimeObj = new \App\Models\TaskTime();
        $taskTimeObj->task_id = $taskTime->getTaskId();
        $taskTimeObj->start_at = $taskTime->getStartAt();
        $taskTimeObj->end_at = $taskTime->getEndAt();
        $taskTimeObj->save();

        return new TaskTime($taskTimeObj->task_id, $taskTimeObj->id, $taskTimeObj->start_at);
    }

    public function update(TaskTime $taskTime): bool
    {
        $taskTimeObj = \App\Models\TaskTime::find($taskTime->getId());
        if (!$taskTimeObj)
            return false;

        $taskTimeObj->end_at = $taskTime->getEndAt();

        return $taskTimeObj->save();
    }

    public function getAllByTaskId(int $taskId): array
    {
        $taskTimes = \App\Models\TaskTime::where('task_id', $taskId)->get();
        $taskTimes = $taskTimes->map(function($el) {
            return new TaskTime($el->task_id, $el->id, $el->start_at, $el->end_at);
        });
        return $taskTimes->toArray();
    }
}
