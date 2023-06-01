<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationReadResource;
use App\Http\Resources\NotificationUnreadResource;

class NotificationController extends Controller
{
    public function notifications($id)
    {
        return NotificationResource::collection(
            User::findOrFail($id)->notifications()->get()
        );
    }

    public function unreadNotifications($id)
    {
        return NotificationReadResource::collection(
            User::findOrFail($id)->unreadNotifications()->get()
        );
    }

    public function readNotifications($id)
    {
        return NotificationUnreadResource::collection(
            User::findOrFail($id)->readNotifications()->get()
        );
    }
}
