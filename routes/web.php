<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\Pages\Applications\ApplicationsController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Тестовая страница
Route::get('/my-page', [MyPageController::class, 'index']);

//Страница заявлений
Route::get('/app', [ApplicationsController::class, 'getApplicationsFreeList'])->middleware('auth');

// //Страница заявлений
// Route::middleware(['auth'])->prefix('app')->group(function() {
//     //Новые заявки
//     Route::get('new', [ApplicationsController::class, 'getApplicationsFreeList'])->middleware('auth');
//     //Заявки назначенные
//     Route::get('wait', [ApplicationsController::class, 'getApplicationsWaitList'])->middleware('auth');
//     //Заявки в работе
//     Route::get('inProgress', [ApplicationsController::class, 'getApplicationsInProgressList'])->middleware('auth');
//     //Выполненные заявки
//     Route::get('done', [ApplicationsController::class, 'getApplicationsDoneList'])->middleware('auth');
// });