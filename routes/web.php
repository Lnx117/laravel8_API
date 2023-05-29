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
Route::get('/app', [ApplicationsController::class, 'getApplicationsList'])->middleware('auth');