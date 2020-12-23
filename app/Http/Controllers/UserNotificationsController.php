<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notification;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\Notifications;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class UserNotificationsController extends Controller
{
    public function index()
    {
//        $notifications = auth()->user()->notifications;
//        $countUnread = $notifications->where('read_at', null)->count();

//        return response(
//            ['notifications' => $notifications, 'countUnread' => $countUnread]);
        return new NotificationCollection(auth()->user()->notifications);
    }

    public function read(Request $request)
    {

        $notification = auth()->user()->unreadNotifications->where('id', $request->id);

        $notification->markAsRead();

        return new NotificationCollection(auth()->user()->notifications);

    }


    public function readAll()
    {

        auth()->user()->unreadNotifications->markAsRead();

        return new NotificationCollection(auth()->user()->notifications);


    }
}
