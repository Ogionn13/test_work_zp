<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return TaskStatus::all();
    }


}
