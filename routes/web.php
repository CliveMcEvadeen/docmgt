<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::view('/', 'dashboard')->name('dashboard');

Route::get('login',[AuthController::class,'login'])->name('login');

Route::get('register',[AuthController::class,'register'])->name('register');
Route::post('store',[AuthController::class,'store'])->name('store');
Route::post('login',[AuthController::class,'doLogin'])->name('auth_login');
Route::get('test',TestController::class)->name('');

Route::get('/verify/{code}', [AuthController::class,'verify'])->name('verify_link');

Route::get('logout', function (){
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

// Password Reset Routes
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

Route::get('users_list',[UserController::class,'index']);

