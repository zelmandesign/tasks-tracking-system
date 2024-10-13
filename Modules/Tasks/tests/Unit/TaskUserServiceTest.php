<?php

namespace Modules\Tasks\tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Tasks\app\Models\Task;
//use Modules\Tasks\app\Services\TaskAssignmentService;
use Modules\Tasks\app\Services\TaskUserService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskUserServiceTest extends TestCase
{
    use RefreshDatabase;  // Ensures database is reset between tests

    protected TaskUserService $taskUserService;
//    protected TaskAssignmentService $taskAssignmentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskUserService = app(TaskUserService::class);
//        $this->taskAssignmentService = app(TaskAssignmentService::class);
    }

//    #[test]
//    public function it_can_get_tasks_assigned_to_user(): void
//    {
//        // Create a user
//        $user = User::factory()->create();
//        $tasks = Task::factory()->count(3)->create();  // Create tasks
//
//        // Use TaskAssignmentService to assign tasks to the user
//        foreach ($tasks as $task) {
//            $this->taskAssignmentService->create([
//                'user_id' => $user->id,
//                'task_id' => $task->id,
//            ]);
//        }
//
//        // Test fetching assigned tasks for the user
//        $tasksAssigned = $this->taskUserService->getTasksAssignedToUser($user->id);
//        $this->assertCount(3, $tasksAssigned);
//    }

    #[test]
    public function it_can_get_tasks_created_by_user(): void
    {
        // Create a user with tasks
        $user = User::factory()->create();
        Task::factory()->count(4)->create(['user_id' => $user->id]);

        // Test fetching tasks created by the user
        $tasks = $this->taskUserService->getTasksCreatedByUser($user->id);
        $this->assertCount(4, $tasks);
    }

    #[test]
    public function it_returns_empty_collection_when_no_tasks_assigned_to_user(): void
    {
        // Create a user with no task assignments
        $user = User::factory()->create();

        // Test fetching assigned tasks for a user with no assignments
        $tasks = $this->taskUserService->getTasksAssignedToUser($user->id);
        $this->assertTrue($tasks->isEmpty());
    }

    #[test]
    public function it_returns_empty_collection_when_no_tasks_created_by_user(): void
    {
        // Create a user with no tasks created
        $user = User::factory()->create();

        // Test fetching tasks created by the user
        $tasks = $this->taskUserService->getTasksCreatedByUser($user->id);
        $this->assertTrue($tasks->isEmpty());
    }
}
