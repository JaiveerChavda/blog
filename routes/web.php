<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/', [PostController::class,'index'])->name('home');

Route::get('/posts/{post}', [PostController::class,'show']);
Route::post('/posts/{post:slug}/comments', [PostCommentController::class,'store']); //store post comment's

Route::get('/register', [RegisterController::class,'create'])->middleware('guest');
Route::post('/register', [RegisterController::class,'store'])->middleware('guest');

Route::post('/logout', [SessionController::class,'destroy']);
Route::get('login', [SessionController::class,'create']);
Route::post('login', [SessionController::class,'store']);

Route::post('newsletter', function () {

    // dd(request()->all());
    request()->validate([
        'email' => 'required|email',
    ]);

    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us8',
    ]);

    try {
        $response = $mailchimp->lists->addListMember('b7f782816d', [
            'email_address' => request('email'),
            'status' => 'subscribed'
        ]);
    } catch(Exception $e) {
        throw ValidationException::withMessages([
         'email' => 'please provide valid email for newsletter subscription.'
    ]);
    }
    return redirect('/')
        ->with('success', 'You have successfully subscribed to our newsletter list');
});
