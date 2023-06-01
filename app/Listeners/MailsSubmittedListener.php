<?php

namespace App\Listeners;

use App\Models\User;
use App\Jobs\MailWelcomeJob;
use App\Events\MailsSubmittedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReceiveEmailNotification;
use App\Notifications\AuthUserHasSentEmailsNotification;

class MailsSubmittedListener
{
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(MailsSubmittedEvent $event): void
    {
        Notification::send(auth()->user(), new AuthUserHasSentEmailsNotification($event->user));

        User::all()->each(function ($user) use ($event) {
            Notification::send($user, new ReceiveEmailNotification($user, $event->user));
            MailWelcomeJob::dispatch($user);
        });
    }
}
