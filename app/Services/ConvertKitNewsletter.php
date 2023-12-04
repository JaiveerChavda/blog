<?php

namespace App\Services;

class ConvertKitNewsletter implements Newsletter
{
    public function subscribe(string $email, ?string $list = null)
    {
     return 'subscribe to convert kit newsletter service';
    }
}
