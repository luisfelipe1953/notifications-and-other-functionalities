<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiveEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user, $userAuthor;

    public function __construct(User $user, User $userAuthor)
    {
        $this->user = $user;
        $this->userAuthor = $userAuthor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'userAuthor_name' => $this->userAuthor->name,
            'userAuthor_id' => $this->userAuthor->id,
            'userAuthor_email' => $this->userAuthor->email,
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'user_email' => $this->user->email,
        ];
    }
}
