<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewInquiryNotification;


class UserController extends Controller
{
    public function account()
    {
        $cities = City::all();
        $user = Auth::user();
        return view('user.profile', compact('user', 'cities'));
    }

    // public function notifications() {
    //      return view('user.notifications');
    // }

    public function notifications(Request $request)
    {
        $query = Auth::user()->notifications();
        // dd($query[0]->data);

        if ($request->filter === 'unread') {
            $query = Auth::user()->unreadNotifications();
        } elseif ($request->filter === 'inquiries') {
            $query->where('type', NewInquiryNotification::class);
        }

        $notifications = $query->paginate(10);

        return view('user.notifications', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    }


    public function services() {
         return view('user.services');
    }

    // for public routes

    public function show(User $user) {

        return view('user.public-profile' , compact('user'));
    }
}
