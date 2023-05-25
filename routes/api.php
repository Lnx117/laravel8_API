<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Users\UserController;
use App\Http\Controllers\API\Task\TaskController;
use App\Http\Controllers\API\Applications\ApplicationsController;

// use App\Http\Controllers\AppController;


use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
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

//Register and auth
Route::prefix('sanctum')->namespace('Auth')->group(function() {
    //create user
    Route::post('register', [AuthController::class, 'register']);
    //create manager
    Route::post('registerManager', [AuthController::class, 'registerManager'])
    ->middleware(['auth:sanctum', 'CheckAdminRole']);
    //get token by log/pas
    Route::post('token', [AuthController::class, 'token']);
});

//Work with users (employes)
Route::middleware(['auth:sanctum','checkAdminOrManagerRole'])->prefix('sanctum')->namespace('Users')->group(function() {
    Route::get('getUsersList', [UserController::class, 'getUsersList']);
    Route::put('updateUserByIdOrEmail/{user}', [UserController::class, 'updateUserByIdOrEmail']);
    Route::get('getUserByIdOrEmail/{user}', [UserController::class, 'getUserByIdOrEmail']);
    Route::delete('deleteUserByIdOrEmail/{user}', [UserController::class, 'deleteUserByIdOrEmail']);
});

//Work with tasks
Route::middleware(['auth:sanctum'])->prefix('sanctum')->namespace('task')->group(function() {
    Route::get('createTask/{application_id}/{master_id}/{status}', [TaskController::class, 'createTask']);
    Route::get('getTasksList', [TaskController::class, 'getTasksList']);
    Route::put('updateTaskById/{id}', [TaskController::class, 'updateTaskById']);
    Route::get('getTaskById/{id}', [TaskController::class, 'getTaskById']);
    Route::delete('deleteTaskById/{id}', [TaskController::class, 'deleteTaskById']);
});

//Work with applications
Route::middleware(['auth:sanctum','checkAdminOrManagerRole'])->prefix('sanctum')->namespace('applications')->group(function() {
    Route::post('createApplication', [ApplicationsController::class, 'createApplication']);
    Route::get('getApplicationsList', [ApplicationsController::class, 'getApplicationsList']);
    Route::put('updateApplicationById/{id}', [ApplicationsController::class, 'updateApplicationById']);
    Route::get('getApplicationById/{id}', [ApplicationsController::class, 'getApplicationById']);
    Route::delete('deleteApplicationById/{id}', [ApplicationsController::class, 'deleteApplicationById']);
});

// Route to reset password
Route::post('reset-password', function (Request $request) {
    $status = Password::sendResetLink(['email' => 'vlados117@gmail.com']);
    $x = Hash::make('19960620v');
    $y = Hash::make('adminadmin');

    return response()->json(1);

});