<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show'])->name('post.show');
Route::get('post-feed/{post}',[PostController::class,'showPostsFeed'])->name('post.show-feed');

Route::post('/posts/{post:slug}/comments', [PostCommentController::class,'store']); //store post comment's

Route::post('newsletter',NewsletterController::class);

Route::get('/register', [RegisterController::class,'create'])->middleware('guest');
Route::post('/register', [RegisterController::class,'store'])->middleware('guest');

Route::post('/logout', [SessionController::class,'destroy']);
Route::get('login', [SessionController::class,'create']);
Route::post('login', [SessionController::class,'store']);

Route::middleware('can:admin')->prefix('admin')->name('admin.')->group( function () {
    Route::resource('posts',AdminPostController::class)->except('show');
});

Route::get('/follow/{author:username}',[UserController::class,'follow'])->name('follow.author');
Route::get('/unfollow/{author:username}',[UserController::class,'unFollow'])->name('unfollow.author');

Route::get('followers',[UserController::class,'followers']);
Route::get('followings',[UserController::class,'followings']);

Route::get('remove/{follower}',[UserController::class,'remove']);

// In routes/web.php
Route::feeds();
