<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show']);
Route::post('/posts/{post:slug}/comments', [PostCommentController::class,'store']); //store post comment's

Route::post('newsletter',NewsletterController::class);

Route::get('/register', [RegisterController::class,'create'])->middleware('guest');
Route::post('/register', [RegisterController::class,'store'])->middleware('guest');

Route::post('/logout', [SessionController::class,'destroy']);
Route::get('login', [SessionController::class,'create']);
Route::post('login', [SessionController::class,'store']);

Route::get('admin/create/posts',[AdminPostController::class,'create'])->middleware('admin');
Route::post('/admin/posts',[AdminPostController::class,'store'])->middleware('admin');

Route::get('admin/posts/',[AdminPostController::class,'index'])->middleware('admin');
Route::get('admin/posts/{post:id}/edit',[AdminPostController::class,'edit'])->middleware('admin');
Route::patch('admin/posts/{post:id}',[AdminPostController::class,'update'])->middleware('admin');
Route::delete('admin/posts/{post:id}',[AdminPostController::class,'destroy'])->middleware('admin');
