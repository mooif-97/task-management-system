<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskFilterRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // GET /items
    function index(TaskFilterRequest $request)
    {
        $filters = $request->validated();
        $items = Task::getTasksByFilterAndPagination($filters);
        Log::error('Validation failed: ' . json_encode($request));
        return response()->json($items);
    }

    function store(TaskStoreRequest $request) {
        $validatedData = $request->validated();
        $item = Task::create($validatedData);

        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    function show($id)
    {
        $item = Task::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }
}
