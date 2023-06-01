<?php

namespace App\Events;

use App\Models\File;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUploadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public File $file,
        public User $user
    ) {
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('file-upload-channel.' . $this->user->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'FileUpload';
    }

    public function broadcastWith(): array
    {
        $message = 'Felicidades ';
        $message .= $this->user->name;
        $message .= ' tu archivo ha subido con éxito.';
        $message .= '<br><span class="font-bold text-green-700">';
        $message .= $this->file->origin_name;
        $message .= '</span>';

        return [
            'message' => $message
        ];
    }
}
