<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotificationController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications/{id}', 'notifications')->name('user.notifications');
    Route::get('/notifications-read/{id}', 'readNotifications')->name('user.notifications-read');
    Route::get('/notifications-unread/{id}', 'unreadNotifications')->name('user.notifications-unread');
});
