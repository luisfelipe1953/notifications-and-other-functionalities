<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('created-product-channel', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('restored-product-channel.{userId}', fn ($user, $userId) => (int) $user->id === (int) $userId);

Broadcast::channel('deleted-product.{userId}', fn ($user, $userId) => (int) $user->id === (int) $userId);

Broadcast::channel('softdeleted-product-channel.{userId}', fn ($user, $userId) => (int) $user->id === (int) $userId);

Broadcast::channel('file-upload-channel.{userId}', fn ($user, $userId) => (int) $user->id === (int) $userId);

Broadcast::channel('notification-read-channel.{notificationId}', function ($user, $notificationId) {
    return (int) $user->id === (int) $user->notifications()->find($notificationId)->notifiable_id;
});
