<?php

require '../../vendor/autoload.php';

use App\Http\Controllers\TaskController;

if ($argc < 3) {
    echo "Specify a task action (start/stop) and a name";
    exit(1);
}

$action = $argv[1];
$name = $argv[2];
if (empty($action) || !in_array($action, ['start', 'stop'])) {
    echo "Invalid action";
    exit(1);
}
if (empty(trim($name))) {
    echo "Specify a task name";
    exit(1);
}

$app = require_once '../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Create controller
$taskController = $app->make(TaskController::class);

// Emulate the request and call the controller
if ($action == 'start') {
    $request = \App\Http\Requests\StartTaskRequest::create(
        '/task/start',
        'POST',
        ['name' => $name]
    );
    $response = $taskController->start($request);

} else {
    $request = \App\Http\Requests\StopTaskRequest::create(
        '/task/stop',
        'POST',
        ['name' => $name]
    );
    $response = $taskController->stop($request);
}

echo $response->getContent();
