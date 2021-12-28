<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();//laravel 封裝好了，包含登入登出註冊重設密碼等認證功能
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/modify/user', [App\Http\Controllers\Auth\UserController::class,'modifyUser'])->name('modify.user');
Route::post('/modify/user', [App\Http\Controllers\Auth\UserController::class,'modifyUserData'])->name('modify.user.data');
Route::get('/modify/user/pwd', [App\Http\Controllers\Auth\UserController::class,'modifyUserPwd'])->name('modify.user.pwd');
Route::post('/modify/user/pwd', [App\Http\Controllers\Auth\UserController::class,'modifyUserPwdData'])->name('modify.user.pwd.data');
Route::get('/delete/user', [App\Http\Controllers\Auth\UserController::class,'deleteUser'])->name('delete.user');
Route::post('/delete/user', [App\Http\Controllers\Auth\UserController::class,'deleteUserData'])->name('delete.user.data');