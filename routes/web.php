<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::view('/',('welcome'))->name('dashboard');

Route::get('login',[AuthController::class,'login'])->name('login');

Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('store',[AuthController::class,'store'])->name('store');
Route::post('login',[AuthController::class,'doLogin'])->name('auth_login');
Route::get('test',TestController::class)->name('');

Route::get('/verify/{code}', [AuthController::class,'verify'])->name('verify_link');

Route::get('logout', function (){
    Auth::logout();
    return redirect(route('login'));
});

Route::get('users_list',[UserController::class,'index']);

