<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AddJsonContentTypeHeader;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



//Route::middleware('auth:sanctum')->get("/users", [UserController::class, 'index']);

Route::group(['middleware'=>'auth:sanctum'], function (){
    Route::get('/projects/list', [ProjectController::class, 'projectList']);
    Route::get('/projects/timeReport', [ProjectController::class, 'timeReport']);

    Route::resource('/projects', ProjectController::class)->only(['index', 'store', 'update', 'show']);
    Route::resource('/tasks', TaskController::class)->only(['index', 'store', 'update', 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/taskStatuses', [TaskStatusController::class, 'index']);

    Route::get('/user/name', [UserController::class, 'get_name']);
});



