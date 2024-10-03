<?php

use Illuminate\Support\Facades\Route;
use Modules\Tasks\Http\Controllers\TasksController;

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

    Route::apiResource('tasks', TasksController::class)->names('tasks');
});

//GET     /api/tasks                  # Get all tasks
//GET     /api/tasks/{id}             # Get specific task by ID
//POST    /api/tasks                  # Create a new task
//PUT     /api/tasks/{id}             # Update a task
//DELETE  /api/tasks/{id}             # Delete a task
//GET     /api/users/{userId}/tasks   # Get all tasks for a user
//POST    /api/tasks/{taskId}/assign  # Assign task to a user
//PUT     /api/tasks/{taskId}/status  # Update task status
//DELETE  /api/tasks/{taskId}/unassign# Unassign task from a user
