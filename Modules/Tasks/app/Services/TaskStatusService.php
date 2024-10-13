<?php

namespace Modules\Tasks\app\Services;

use Modules\Tasks\app\Models\Task;

class TaskStatusService
{
    public function updateTaskStatus(int $taskId, array $validatedData)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return false;
        }

        return $task->update($validatedData);
    }
}
