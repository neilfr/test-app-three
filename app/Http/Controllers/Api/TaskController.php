<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function index()
    {
        return new TaskCollection(Task::all());
    }

    public function store(Request $request)
    {
        $task = Task::make($request->input());
        $task->save();
        return response('', 200);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->input());
        return response('', 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('', 200);
    }
}
