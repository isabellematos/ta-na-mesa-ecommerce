<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('welcome');
});

Route::get('/create-user',[UserController::class,'create'])->name('user.create');
Route::post('/store-user',[UserController::class,'store'])->name('user.store');

Route::prefix('auth')->group(function(){
    Route::get('/login', [\App\Http\Controllers\auth\LoginController::class, 'login'])->name('login');
});