<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MailsSubmittedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('email-submitted-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'EmailSubmitted';
    }

    public function broadcastWith(): array
    {
        $message = 'El usuario ';
        $message .= $this->user->name;
        $message .= ' ha notificado a los <span class="text-bold text-green-700">';
        $message .= count(User::all());
        $message .= '</span> usuarios registrados a traves de una funcionalidad de la aplicación';

        return [
            'message' => $message
        ];
    }
}
