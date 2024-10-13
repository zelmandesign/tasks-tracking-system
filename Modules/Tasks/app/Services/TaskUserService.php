<?php

namespace Modules\Tasks\app\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Tasks\app\Models\Task;
use Modules\Tasks\app\Models\TaskAssignment;

class TaskUserService
{
    public function getTasksAssignedToUser(int $userId): Collection
    {
        return TaskAssignment::where('user_id', $userId)->get();
    }

    public function getTasksCreatedByUser(int $userId): Collection
    {
        return Task::where('user_id', $userId)->get();
    }
}
