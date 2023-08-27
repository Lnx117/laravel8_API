<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\Pages\Applications\ApplicationsController;
use App\Http\Controllers\Pages\Users\UsersController;
use App\Http\Controllers\Pages\Auth\NewLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/login', [NewLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [NewLoginController::class, 'login']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Тестовая страница
Route::get('/my-page', [MyPageController::class, 'index']);

//Страница заявлений
Route::get('/app/new', [ApplicationsController::class, 'getApplicationsFreeList'])->middleware('auth')->name('app.new');

Route::get('/app/wait', [ApplicationsController::class, 'getApplicationsWaitList'])->middleware('auth')->name('app.wait');

Route::get('/app/inProgress', [ApplicationsController::class, 'getApplicationsInProgressList'])->middleware('auth')->name('app.inProgress');

Route::get('/app/done', [ApplicationsController::class, 'getApplicationsDoneList'])->middleware('auth')->name('app.done');

Route::get('/app/deleted', [ApplicationsController::class, 'getApplicationsDeletedList'])->middleware('auth')->name('app.deleted');

Route::get('/app/create', [ApplicationsController::class, 'getApplicationsCreateList'])->middleware('auth')->name('app.create');

//Страница пользователей
Route::get('/users/free', [UsersController::class, 'getFreeUsersList'])->middleware('auth')->name('users.free');

Route::get('/users/working', [UsersController::class, 'getWorkingUsersList'])->middleware('auth')->name('users.working');

Route::get('/users/vacatioin', [UsersController::class, 'getVacationUsersList'])->middleware('auth')->name('users.vacatioin');

Route::get('/users/create', [UsersController::class, 'createMaster'])->middleware('auth')->name('users.create');

Route::get('/users/createManager', [UsersController::class, 'createManager'])->middleware('auth')->name('users.createManager');

Route::get('/users/managers', [UsersController::class, 'managers'])->middleware('auth')->name('users.managers');

Route::get('/users/managersDeleted', [UsersController::class, 'deletedManagers'])->middleware('auth')->name('users.managersDeleted');

