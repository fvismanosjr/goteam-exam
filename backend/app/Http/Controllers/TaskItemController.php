<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskItem;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $taskId)
    {
        $tasks = Task::with('taskItems')->findOrFail($taskId);

        return response()->json([
            'taskItems' => $tasks->taskItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $taskId)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $taskId)
    {
        $validated = $request->validate([
            'task_id' => 'required',
            'description' => 'required'
        ]);

        $taskItem = TaskItem::query()->create($validated);

        return response()->json($taskItem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $taskId)
    {
        return TaskItem::query()->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $taskId, string $id)
    {
        $validated = $request->validate([
            'task_id' => 'required',
            'description' => 'required'
        ]);

        $taskItem = TaskItem::query()->findOrFail($id);
        $taskItem->update($validated);

        return response()->json($taskItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $taskId, string $id)
    {
        $taskItem = TaskItem::query()->findOrFail($id);
        $taskItem->delete();

        return response()->json(null, 204);
    }
}
