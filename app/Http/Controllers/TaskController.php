<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $task = Task::create($data);
        return $task;
    }

    public function show(Task $task)
    {
        return $task->load(['taskStatus']);
    }

    public function index()
    {
        $userId = auth()->id();
        return DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')
            ->where('projects.user_id', '=', $userId)
            ->where('task_statuses.is_closed', '=', 0)
            ->select('tasks.title', 'tasks.id', 'tasks.deadline', 'tasks.length', 'projects.title as project_title', 'projects.id as project_id', 'task_statuses.name as task_status_name')
            ->orderBy('task_statuses.sort')
            ->orderBy('tasks.deadline')
            ->get();
    }

        public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $task->fill($data);
        $task->save();
        return $task;
    }
}
