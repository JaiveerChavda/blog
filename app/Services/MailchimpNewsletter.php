<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements Newsletter
{
    public function __construct(protected ApiClient $client) {}

    public function subscribe(string $email, ?string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');

        // generate md5 lowercase version of subscriber
        // email to use in setListMember function

        $subscriberHash = md5(strtolower($email));

        return $this->client->lists->setListMember($list, $subscriberHash, [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
    }
}
