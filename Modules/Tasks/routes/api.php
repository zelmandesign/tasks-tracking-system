<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\app\Http\Controllers\TaskNotificationController;
use Modules\Tasks\app\Http\Controllers\TasksController;
use Modules\Tasks\app\Http\Controllers\TaskAssignmentController;
use Modules\Tasks\app\Http\Controllers\TaskStatusController;
use Modules\Tasks\app\Http\Controllers\TaskUserController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['auth:sanctum'])->group(function () {

    // TaskController CRUD Routes
    Route::prefix('tasks')->group(function () {
        // Typical CRUD routes
        Route::get('/', [TasksController::class, 'index'])->name('tasks.index'); // Get all tasks
        Route::get('/{id}', [TasksController::class, 'show'])->name('tasks.show'); // Get a specific task
        Route::post('/', [TasksController::class, 'store'])->name('tasks.store'); // Create a new task
        Route::put('/{id}', [TasksController::class, 'update'])->name('tasks.update'); // Update a task
        Route::delete('/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy'); // Delete a task

        // Assign and Unassign Tasks
        Route::post('{taskId}/assign', [TaskAssignmentController::class, 'assignTask'])->name('tasks.assign');
        Route::delete('{taskId}/unassign', [TaskAssignmentController::class, 'unassignTask'])->name('tasks.unassign');

        // Task Status
        Route::put('{taskId}/status', [TaskStatusController::class, 'updateStatus'])->name('tasks.updateStatus');
    });

    // TaskUserController Routes for tasks related to a user
    Route::prefix('users/{userId}/tasks')->group(function () {
        Route::get('assigned', [TaskUserController::class, 'getUserAssignedTasks'])->name('users.tasks.assigned');
        Route::get('created', [TaskUserController::class, 'getUserCreatedTasks'])->name('users.tasks.created');
    });

    Route::post('/notify', [TaskNotificationController::class, 'notifyUser']);
});
