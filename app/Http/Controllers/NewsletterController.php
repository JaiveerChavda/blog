<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    // $newsletter = new Newsletter(Apiclient $client,!!?); // laravel automatic resolution.
    public function __invoke(Newsletter $newsletter)
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        try {
            $newsletter->subscribe(request('email'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
             'email' => 'please provide valid email for newsletter subscription.',
            ])->redirectTo('/#newsletter');
        }

        return redirect('/')
            ->with('success', 'You have successfully subscribed to our newsletter list');
    }
}
