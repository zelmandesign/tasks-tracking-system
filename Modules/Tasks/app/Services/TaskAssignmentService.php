<?php
declare(strict_types=1);
namespace Modules\Tasks\app\Services;

use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Modules\Tasks\app\Models\TaskAssignment;

class TaskAssignmentService
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function all(): Collection
    {
        return TaskAssignment::all();
    }

    public function find(int $id): TaskAssignment|bool
    {
        $status = TaskAssignment::find($id);
        if ($status) {
            return $status;
        }
        return false;
    }

    public function create(array $data): TaskAssignment
    {
        return TaskAssignment::create($data);
    }

    public function delete(int $id): bool
    {
        $status = TaskAssignment::find($id);
        if ($status) {
            return $status->delete();
        }
        return false;
    }

    public function update(int $id, array $data): TaskAssignment|bool
    {
        $updated = TaskAssignment::where('id', $id)->update($data);

        if ($updated) {
            return TaskAssignment::find($id);
        }

        return false;
    }

    // get task from TaskUserStatusTable
    public function getTaskByTaskId(int $taskId): TaskAssignment|bool
    {
        $taskUserStatus = TaskAssignment::where('task_id', $taskId)->first();
        if ($taskUserStatus) {
            return $taskUserStatus;
        }

        return false;
    }

    public function updateOrCreate(array $data): TaskAssignment|int
    {
        $checkIfExists = $this->getTaskByTaskId($data['task_id']);

        if ($checkIfExists) {
            return $this->update($checkIfExists['id'], $data);
        }

        return $this->create($data);
    }

    public function assignTaskToUser(int $userId, int $taskId): bool
    {
        // Retrieve the task
        $task = $this->taskService->find($taskId);

        // Check if the task exists and is unassigned
        if (!$task) {
            return false; // Task cannot be assigned it doesn't exist
        }

        // Update the task assignment status in task repository
        $this->taskService->update($taskId, [
            'assignment' => 'assigned'
        ]);

        // TaskUserStatusTable operation
        $data = [
            'task_id' => $taskId,
            'user_id' => $userId,
        ];
        $this->updateOrCreate($data);

        return true;
    }

    public function unassignTask(int $taskId): bool
    {
        // Retrieve the task
        $task = $this->taskService->find($taskId);

        // Check if the task exists
        if (!$task) {
            return false; // Task cannot be unassigned if it doesn't exist
        }

        // Check if the task assignment exists
        $taskAssignment = $this->getTaskByTaskId($taskId);
        if (!$taskAssignment) {
            return false; // Task assignment does not exist
        }

        // Update the task assignment status to 'unassigned'
        $this->taskService->update($taskId, [
            'assignment' => 'unassigned'
        ]);

        // Delete the task assignment from task_assignment table
        $this->delete($taskAssignment['id']);

        return true;
    }
}
