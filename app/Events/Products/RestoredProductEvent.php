<?php

namespace App\Events\Products;

use App\Models\User;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RestoredProductEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Product $product,
        public User $user
    ) {
        $this->product = $product;
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
            new PrivateChannel('restored-product-channel.' . $this->user->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'RestoredProduct';
    }

    public function broadcastWith(): array
    {
        $message = 'Has restaurado el producto <span class="font-bold text-green-700">';
        $message .= $this->product->name;
        $message .= '</span>';
        $message .= ' de la papelera.';

        return [
            'message' => $message
        ];
    }
}
