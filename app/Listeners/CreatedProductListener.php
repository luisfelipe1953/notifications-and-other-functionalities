<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Product;
use App\Classes\Facades\CacheComposite;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Products\CreatedProductEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreatedProductNotification;

class CreatedProductListener
{
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CreatedProductEvent $event): void
    {
        CacheComposite::updateCache(
            Product::class,
            'products',
            ['id', 'name', 'description', 'category_id']
        );

        User::all()
            ->each(fn (User $user) =>
            Notification::send($user, new CreatedProductNotification(
                $user,
                $event->product
            )));
    }
}
