<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreatedProductNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user, $product;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Se ha creado un nuevo producto')
            ->greeting('Hello ' . $this->user->name)
            ->line('Han surgido cambios en la tabla de Productos y te hemos notificado.')
            ->line('El producto que se creó es: ' . $this->product->name)
            ->action('Ir al sitio principal', route('welcome'))
            ->line('Gracias por utilizar la aplicacion');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_name' => $this->product->name,
            'product_description' => $this->product->description
        ];
    }
}
