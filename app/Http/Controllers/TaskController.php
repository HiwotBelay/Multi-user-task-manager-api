<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed,in_progress',
            'priority' => 'nullable|in:low,medium,high',
            'deadline' => 'required|date',
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'priority' => $request->priority ?? 'medium',
            'deadline' => $request->deadline,
        ]);

        return response()->json($task, 201);
    }

public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);
    $user = $request->user();

    // Check permissions
    if ($user->role !== 'admin' && $task->user_id !== $user->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $request->validate([
        'title' => 'sometimes|required|string',
        'description' => 'sometimes|nullable|string',
        'status' => 'sometimes|in:pending,completed,in_progress',
        'priority' => 'sometimes|in:low,medium,high',
        'deadline' => 'sometimes|required|date',
    ]);

    $task->update($request->only(['title', 'description', 'status', 'priority', 'deadline']));

    return response()->json($task);
}
public function destroy(Request $request, $id)
{
    $task = Task::findOrFail($id);
    $user = $request->user();

    if ($user->role !== 'admin' && $task->user_id !== $user->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $task->delete();

    return response()->json(['message' => 'Task deleted successfully']);
}
public function index() {
    $user = auth()->user();

    if ($user->role === 'admin') {
        $tasks = Task::all();
    } else {
        $tasks = Task::where('user_id', $user->id)->get();
    }

    return view('dashboard', compact('tasks'));
}



public function edit($id) {
    $task = Task::findOrFail($id);

    // Authorization check
    if (auth()->user()->role !== 'admin' && $task->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tasks.edit', compact('task'));
}





}
