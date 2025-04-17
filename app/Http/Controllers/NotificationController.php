<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewInquiryNotification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function notifications(Request $request)
    {
        $query = Auth::user()->notifications()->where('type', '!=', NewInquiryNotification::class );
        // dd($query[0]->data);

        if ($request->filter === 'unread') {
            $query = Auth::user()->unreadNotifications()->where('type', '!=', NewInquiryNotification::class );
        }

        $notifications = $query->paginate(10);

        return view('user.notifications', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read');
    }

    public function getInquiriesRequests() {

        $notifications = Auth::user()->notifications()->where('type', NewInquiryNotification::class)->paginate(10);
        return view('user.inquiriesNotifications' , compact('notifications'));
    }
}
