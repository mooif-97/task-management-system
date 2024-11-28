<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskFilterRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index(TaskFilterRequest $request)
    {
        $filters = $request->validated();
        return Task::getTasksByFilterAndPagination($filters);
    }

    /**
     * Store a newly created resource in storage.
     */
    function store(TaskStoreRequest $request)
    {
        $validatedData = $request->validated();
        $item = Task::create($validatedData);

        return response()->json(['message' => 'Task created successfully.', 'item' => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    function show($task_id)
    {
        $task = $this->searchTaskByTaskId($task_id);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    function update(TaskUpdateRequest $request, string $task_id)
    {
        $task = $this->searchTaskByTaskId($task_id);

        $task->update($request->validated());

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    function destroy(string $task_id)
    {
        //
    }

    private function searchTaskByTaskId(string $task_id)
    {
        $task = Task::where('task_id', $task_id)->first();
        if (!$task) {
            return response()->json(['message' => "Task with [Task ID: {$task_id}] is not found."], 404);
        }
        return $task;
    }
}
