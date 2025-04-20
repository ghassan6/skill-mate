<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inquiry;
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

    public function viewService($notificationId)
    {
        // Find the notification by ID
        $notification = DatabaseNotification::findOrFail($notificationId);

        // Mark as read
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        // Check if the notification contains an inquiry ID
        $inquiryId = $notification->data['inquiry_id'] ?? null;
        if (!$inquiryId) {
            return redirect()->back()->with('error', 'No inquiry associated with this notification.');
        }

        // Get the service related to the inquiry
        $inquiry = Inquiry::find($inquiryId);
        $service = $inquiry?->service;

        // If no service found, redirect with an error
        if (!$service) {
            return redirect()->back()->with('error', 'Service not found.');
        }

        // Redirect to the service page
        return redirect()->route('services.show', $service->slug);
    }

}
