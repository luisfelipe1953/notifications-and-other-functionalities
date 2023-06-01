<?php

namespace App\Events\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatedProductEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product, $user;

    public function __construct(Product $product, User $user)
    {
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
            new Channel('created-product-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'CreatedProduct';
    }

    public function broadcastWith(): array
    {
        $message = 'El usuario ';
        $message .= $this->user->name;
        $message .= ' ha creado el producto <span class="font-bold text-green-700">';
        $message .= $this->product->name;
        $message .= '</span>';

        return [
            'message' => $message
        ];
    }
}
