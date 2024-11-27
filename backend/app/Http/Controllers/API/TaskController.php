<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemFilterRequest;
use App\Http\Requests\ItemStoreRequest;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // GET /items
    function index(ItemFilterRequest $request)
    {
        $filters = $request->validated();
        $items = TaskModel::getItemsByFilterAndPagination($filters);
        Log::error('Validation failed: ' . json_encode($request));
        return response()->json($items);
    }

    function store(ItemStoreRequest $request) {
        $validatedData = $request->validated();
        $item = TaskModel::create($validatedData);

        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    function show($id)
    {
        $item = TaskModel::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }
}
