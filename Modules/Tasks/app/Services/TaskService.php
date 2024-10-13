<?php

namespace Modules\Tasks\app\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Tasks\app\Models\Task;

class TaskService
{
    public function find(int $id): Task|bool
    {
        $task = Task::find($id);
        if ($task) {
            return $task;
        }

        return false;
    }

    public function all(): Collection
    {
        return Task::all();
    }

    public function delete(int $id): bool
    {
        $task = Task::find($id);
        if ($task) {
            return $task->delete();
        }
        return false;
    }

    public function create(array $data): Task|bool
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['user_id'] ?? null,  // Default to null if not provided
            'assignment' => $data['assignment_status'] ?? 'unassigned',
            'due_date' => $data['due_date'] ?? null,  // Default to null if not provided
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $task = Task::find($id);
        if ($task) {
            return $task->update($data);
        }
        return false;
    }

    public function getTasksCreatedByUserId(int $id): Collection|bool
    {
        return Task::where('user_id', $id)->get();
    }

    public function getUnassignedTasks(): Collection|bool
    {
        return Task::all()->where('assignment', 'unassigned');
    }

    public function getAssignedTasks(): Collection|bool
    {
        return Task::all()->where('assignment', 'assigned');
    }
}
