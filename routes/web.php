<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('general.welcome');
});

Route::get('/registration',[\App\Http\Controllers\GeneralPageController::class,'RegistrationPage'])->name('RegistrationPage');
Route::post('/registration/save',[\App\Http\Controllers\UserController::class,'Registration'])->name('Registration');
Route::get('/authorization',[\App\Http\Controllers\GeneralPageController::class,'authorization'])->name('login');
Route::get('/login',[\App\Http\Controllers\GeneralPageController::class,'auth'])->name('auth');
