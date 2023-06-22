<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\TeamUserController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\MilestoneTaskController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('projects', ProjectController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('role_user', RoleUserController::class);
Route::resource('tasks', TaskController::class);
Route::resource('milestones', MilestoneController::class);
Route::resource('milestone_task', MilestoneTaskController::class);
Route::resource('teams', TeamController::class);
Route::resource('team_user', TeamUserController::class);
