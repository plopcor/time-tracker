<?php

namespace Src\Application\Service;

use Src\Domain\Entity\Task;
use Src\Domain\Entity\TaskTime;
use Src\Domain\Repository\TaskRepositoryInterface;
use Src\Domain\Repository\TaskTimeRepositoryInterface;
use Src\UserInterface\Command\StartTaskCommand;
use Src\UserInterface\Command\StopTaskCommand;

class TaskService
{
    private TaskRepositoryInterface $taskRepository;
    private TaskTimeRepositoryInterface $taskTimeRepository;

    public function __construct(TaskRepositoryInterface $taskRepository, TaskTimeRepositoryInterface $taskTimeRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->taskTimeRepository = $taskTimeRepository;
    }

    public function startTask(StartTaskCommand $command) : Task
    {
        $task = $this->taskRepository->getOrCreateByName($command->getName());

        $taskTime = new TaskTime($task->getId());
        $taskTime = $this->taskTimeRepository->create($taskTime);

        $task->addTaskTime($taskTime);

        return $task;
    }

    public function stopTask(StopTaskCommand $command) : Task
    {
        $task = $this->taskRepository->getByName($command->getName());
        if (is_null($task))  {
            throw new \Exception("Task not found");
        }

        $taskTime = $this->taskTimeRepository->getLastByTaskId($task->getId());
        if (is_null($taskTime)) {
            throw new \Exception("Task is not started");
        }

        $taskTime->setEndAt(new \DateTime());

        $this->taskTimeRepository->update($taskTime);

        return $task;
    }

    public function getTodayWorkedTasks() : array
    {
        $tasks = $this->taskRepository->getAllWorkedToday();

        $ret = [];
        foreach ($tasks as $task) {
            $total = 0;
            foreach ($task->getTaskTimes() as $taskTime) {
                $total += $taskTime->getDuration();
            }

            $ret[] = [
                'task' => $task,
                'total' => $total
            ];
        }
        return [
            'tasks' => $ret,
            'total' => array_sum(array_map(fn ($task) => $task['total'], $ret))
        ];
    }
}
