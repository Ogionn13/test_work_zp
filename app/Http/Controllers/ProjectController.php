<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    public function index()
    {
        return auth()->user()->getProjects;
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $project = Project::create($data);
        return $project;
    }

    public function show(Project $project)
    {
        $project = $project->load(['tasks.taskStatus', 'category']);
        $project->created_at_formated = date('d.m.Y', strtotime($project->created_at));
        return $project;
    }

    public function projectList(){
        return auth()->user()->getProjectsList;
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $project->fill($data);
        $project->save();
        return $project;
    }

    public function timeReport(){
        $userId = auth()->id();
        return Project::select('id', 'title', 'deadline')
            ->orderBy('tasks_sum_length', 'desc')
            ->withCount('tasks')
            ->withSum('tasks', 'length')
            ->where('user_id', $userId)
            ->get();
    }

}
