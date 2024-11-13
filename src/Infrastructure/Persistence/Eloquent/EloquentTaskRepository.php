<?php

namespace Src\Infrastructure\Persistence\Eloquent;


use Carbon\Carbon;
use Src\Domain\Entity\Task;
use Src\Domain\Entity\TaskTime;
use Src\Domain\Repository\TaskRepositoryInterface;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function getOrCreateByName(string $name): Task
    {
        $taskObj = \App\Models\Task::firstOrCreate([
            'name' => $name
        ]);

        $taskObj->load(['taskTimes']);
        $taskTimes = $taskObj->taskTimes->map(function ($taskTime) {
            return new TaskTime(
                $taskTime->id,
                $taskTime->task_id,
                $taskTime->start_at,
                $taskTime->end_at
            );
        })->toArray();

        return new Task($taskObj->id, $taskObj->name, $taskTimes);
    }

    public function getByName(string $name): ?Task
    {
zº        $taskObj = \App\Models\Task::with(['taskTimes'])->where('name', $name)->first();
        $taskTimes = $taskObj->taskTimes->map(function ($taskTime) {
            return new TaskTime(
                $taskTime->id,
                $taskTime->task_id,
                $taskTime->start_at,
                $taskTime->end_at
            );
        })->toArray();
        return new Task($taskObj->id, $taskObj->name, $taskTimes);
    }

    public function getAllWorkedToday() : array
    {
        $dayStart = Carbon::today()->startOfDay();
        $dayEnd = Carbon::today()->endOfDay();

        $tasks = \App\Models\Task::with(['taskTimes' => function ($query) use ($dayStart, $dayEnd) {
            $query->whereBetween('start_at', [$dayStart, $dayEnd])
                ->orWhere(function ($query) use ($dayStart, $dayEnd) {
                    $query->whereNull('end_at')->whereBetween('start_at', [$dayStart, $dayEnd]);
                });
        }])->whereHas('taskTimes')->get();

        $tasks = $tasks->map(function ($task) {
            return new Task(
                $task->id,
                $task->name,
                $task->taskTimes->map(function ($taskTime) {
                    return new TaskTime(
                        $taskTime->task_id,
                        $taskTime->id,
                        $taskTime->start_at,
                        $taskTime->end_at
                    );
                })->toArray()
            );
        })->toArray();

        return $tasks;
    }
}
