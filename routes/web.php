<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\BookmarkPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\User;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show'])->name('post.show');
Route::get('post-feed/{post}', [PostController::class,'showPostsFeed'])->name('post.show-feed');

Route::post('newsletter', NewsletterController::class);

//guest routes
Route::group(['middleware' => 'guest'], function () {

    Route::get('login', [SessionController::class,'create'])->name('login');
    Route::post('login', [SessionController::class,'store']);

    Route::get('/register', [RegisterController::class,'create'])->middleware('guest');

    Route::post('/register', [RegisterController::class,'store'])->middleware('guest');

    // social login routes
    Route::post('/auth/redirect', [SocialLoginController::class,'redirect'])->middleware('guest');

    Route::get('/auth/callback', [SocialLoginController::class,'callback'])->middleware('guest');

    // social login routes end
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('posts', AdminPostController::class)->except('show');
});

//auth routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/follow/{author:username}', [UserController::class,'follow'])->name('follow.author');
    Route::delete('/unfollow/{author:username}', [UserController::class,'unFollow'])->name('unfollow.author');

    Route::get('followers', [UserController::class,'followers'])->name('followers');
    Route::get('followings', [UserController::class,'followings'])->name('followings');


    Route::resource('profile', ProfileController::class)->only(['index','edit','update']);

    Route::put('password', [PasswordController::class,'update'])->name('password.update');

    Route::get('remove/{follower}', [UserController::class,'remove']);

    Route::resource('bookmark', BookmarkPostController::class)->only(['index','store','destroy']);

    Route::post('/logout', [SessionController::class,'destroy']);

    Route::post('/posts/{post:slug}/comments', [PostCommentController::class,'store'])->name('post.comment'); //store post comment's
});

// In routes/web.php
Route::feeds();
