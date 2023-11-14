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
//Регистрация
Route::get('/registration',[\App\Http\Controllers\GeneralPageController::class,'registrationPage'])->name('registrationPage');
Route::post('/registration/save',[\App\Http\Controllers\UserController::class,'registration'])->name('registration');
//Авторизация
Route::get('/authorization',[\App\Http\Controllers\GeneralPageController::class,'authorization'])->name('login');
Route::post('/login',[\App\Http\Controllers\UserController::class,'Auth'])->name('Auth');

//Страница пользователя
Route::get('/user/index',[\App\Http\Controllers\UserController::class, 'index_user'])->name('index_user');

//Выход
Route::get('/exit',[\App\Http\Controllers\UserController::class,'exit'])->name('exit');

//Ограничения доступа к страницам администратоа
Route::group(['middleware'=>['auth','admin'],'prefix'=>'admin'],function (){
    Route::get('/admin/index',[\App\Http\Controllers\AdminPageController::class,'index_admin'])->name('index_admin');
    Route::get('/categories',[\App\Http\Controllers\AdminPageController::class,'categories'])->name('categories');

    Route::post('/categories/type/save',[\App\Http\Controllers\TypeController::class,'store'])->name('type_save');
    Route::post('/categories/material/save',[\App\Http\Controllers\MaterialController::class,'store'])->name('material_save');
    Route::post('/categories/stone/save',[\App\Http\Controllers\StoneController::class,'store'])->name('stone_save');
    Route::post('/categories/whom/save',[\App\Http\Controllers\WhomeController::class,'store'])->name('whom_save');
    Route::post('/categories/sample/save',[\App\Http\Controllers\SampleController::class,'store'])->name('sample_save');
    Route::post('/categories/cutting/save',[\App\Http\Controllers\CuttingController::class,'store'])->name('cutting_save');


    Route::get('/categories/type/get',[\App\Http\Controllers\TypeController::class,'show'])->name('get_type');
    Route::get('/categories/material/get',[\App\Http\Controllers\MaterialController::class,'show'])->name('get_material');
    Route::get('/categories/stone/get',[\App\Http\Controllers\StoneController::class,'show'])->name('get_stone');
    Route::get('/categories/whom/get',[\App\Http\Controllers\WhomeController::class,'show'])->name('get_whom');
    Route::get('/categories/sample/get',[\App\Http\Controllers\SampleController::class,'show'])->name('get_sample');
    Route::get('/categories/cutting/get',[\App\Http\Controllers\CuttingController::class,'show'])->name('get_cutting');

    Route::post('/categories/subtype/edit',[\App\Http\Controllers\SubtypeController::class,'edit'])->name('edit_subtype');
    Route::post('/categories/sizes/edit',[\App\Http\Controllers\SizeController::class,'edit'])->name('edit_sizes');

    Route::post('/categories/subtype/delete',[\App\Http\Controllers\SubtypeController::class,'destroy'])->name('destroy_subtypes');
    Route::post('/categories/sizes/delete',[\App\Http\Controllers\SizeController::class,'destroy'])->name('destroy_sizes');
});


