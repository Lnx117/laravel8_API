<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\UserController;

use App\Http\Controllers\AppController;


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

Route::prefix('sanctum')->namespace('Auth')->group(function() {
    //create user
    Route::post('register', [AuthController::class, 'register']);
    //get token by log/pas
    Route::post('token', [AuthController::class, 'token']);
});

Route::middleware('auth:sanctum')->prefix('sanctum')->namespace('Users')->group(function() {
    Route::get('getUsersList', [UserController::class, 'getUsersList']);
    Route::put('updateUserByIdOrEmail/{user}', [UserController::class, 'updateUserByIdOrEmail']);
    Route::get('getUserByIdOrEmail/{user}', [UserController::class, 'getUserByIdOrEmail']);
    Route::delete('deleteUserByIdOrEmail/{user}', [UserController::class, 'deleteUserByIdOrEmail']);
   /*  Update, delete by id or email
    Route::get('getUsersList', [UserController::class, 'getUsersList']);
    Route::get('getUsersList', [UserController::class, 'getUsersList']);
    Route::get('getUsersList', [UserController::class, 'getUsersList']); */

    /* Change email and change pass
    Route::get('getUsersList', [UserController::class, 'getUsersList']); 
    Route::get('getUsersList', [UserController::class, 'getUsersList']);*/

});

// Route to reset password
Route::post('reset-password', function (Request $request) {
    $status = Password::sendResetLink(['email' => 'vlados117@gmail.com']);
    $x = Hash::make('19960620v');
    $y = Hash::make('adminadmin');

    return response()->json(1);

});