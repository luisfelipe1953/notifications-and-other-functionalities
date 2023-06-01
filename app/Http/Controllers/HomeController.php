<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationReadEvent;
use App\Classes\Facades\CacheComposite;

class HomeController extends Controller
{
    public function index()
    {
        $users = CacheComposite::getCacheOrCreate(
            'users',
            User::class,
            ['id', 'name']
        );

        return view('welcome', compact('users'));
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('create', 'Notificaciones leidas');
    }

    public function readNotification(Request $request, $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);

        $user->unreadNotifications
            ->when($id, fn ($query, $id) => $query->where('id', $id))
            ->markAsRead();

        event(new NotificationReadEvent($notification));
    }
}
