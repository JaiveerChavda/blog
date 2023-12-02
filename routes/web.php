<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show']);
Route::post('/posts/{post:slug}/comments',[PostCommentController::class,'store']); //store post comment's

Route::get('/register',[RegisterController::class,'create'])->middleware('guest');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest');

Route::post('/logout',[SessionController::class,'destroy']);
Route::get('login',[SessionController::class,'create']);
Route::post('login',[SessionController::class,'store']);

Route::get('ping',function(){
    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us8',
    ]);

    $response = $mailchimp->lists->addListMember('b7f782816d',[
        'email_address' => 'jayveersinhchavda555@gmail.com',
        'status' => 'subscribed'
    ]);

    ddd($response);
});
