<?php
declare(strict_types=1);
namespace Modules\Tasks\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Tasks\app\Services\TaskService;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller
{
    private TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // GET /api/tasks -> Get all tasks
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->all();
        return response()->json($tasks, Response::HTTP_OK); // Return
    }

    // GET /api/tasks/{id} -> Get specific task by ID
    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND); // 404 if task not found
        }

        return response()->json($task, Response::HTTP_OK); // Return task as JSON
    }
    // POST /api/tasks -> Create a new task
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assignment' => 'nullable|in:unassigned,assigned',
            'due_date' => 'nullable|date',
        ]);

        // Automatically set the user_id to the authenticated user's ID
        $validatedData['user_id'] = Auth::id();  // or $request->user()->id

        // Create the task using the TaskService
        $task = $this->taskService->create($validatedData);

        // Return the created task as a JSON response with a 201 status code
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], Response::HTTP_CREATED);
    }

    // PUT /api/tasks/{id} -> Update a task
    public function update(Request $request, int $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'assignment_status' => 'nullable|string|in:assigned,unassigned',
            'due_date' => 'nullable|date',
        ]);

        // Call the taskService to update the task
        $updated = $this->taskService->update($id, $validated);

        if (!$updated) {
            return response()->json(['error' => 'Task not found or not updated'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Task updated successfully'], Response::HTTP_OK);
    }

    // DELETE /api/tasks/{id} -> Delete a task
    public function destroy(int $id)
    {
        $deleted = $this->taskService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);
    }
}
