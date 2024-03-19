<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail
{
    /**
     * @param  array{title: string, body: string}  $input
     */
    public function send(array $input): void
    {
        $title = $input['title'];
        $body = $input['body'];

        $customers = User::role('customer')->get();
        $mailable = new \App\Mail\NotificationEmail($title, $body);
        Mail::to($customers)->send($mailable);
    }
}
