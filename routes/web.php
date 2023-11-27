<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show']);

Route::get('/register',[RegisterController::class,'create'])->middleware('guest');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest');

Route::post('/logout',[SessionController::class,'destroy']);
Route::get('login',[SessionController::class,'create']);
Route::post('login',[SessionController::class,'store']);
