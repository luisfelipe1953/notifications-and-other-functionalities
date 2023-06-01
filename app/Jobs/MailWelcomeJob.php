<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\MailWelcome;
use Illuminate\Bus\Queueable;
use App\Events\MailsSubmittedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\MailsSubmittedNotification;

class MailWelcomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $userAuthor;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->userAuthor = auth()->user();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailWelcome = new MailWelcome($this->user, $this->userAuthor);
        Mail::to($this->user->email)->send($mailWelcome);
        sleep(1);
    }
}
