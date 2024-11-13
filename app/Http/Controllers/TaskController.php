<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartTaskRequest;
use App\Http\Requests\StopTaskRequest;
use Illuminate\Http\JsonResponse;
use Src\Application\Service\TaskService;
use Src\UserInterface\Command\StartTaskCommand;
use Src\UserInterface\Command\StopTaskCommand;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function startTask(StartTaskRequest $request): JsonResponse
    {
        $command = new StartTaskCommand($request->input('name'));
        $task = $this->taskService->startTask($command);
        return response()->json($task, 200);
    }

    public function stopTask(StopTaskRequest $request)
    {
        $command = new StopTaskCommand($request->input('name'));
        $task = $this->taskService->stopTask($command);
        return response()->json($task, 200);
    }

    public function resumeToday()
    {
        $todayResume = $this->taskService->getTodayWorkedTasks();
        return response()->json($todayResume, 200);
    }

}
