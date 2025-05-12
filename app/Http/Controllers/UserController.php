<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function account()
    {
        $cities = City::all();
        $user = Auth::user();
        return view('user.profile', compact('user', 'cities'));
    }


    public function services() {

         return view('user.services.user-services' );
    }

    // for public routes

    public function show(User $user) {

        return view('user.public-profile' , compact('user'));
    }

    public function increaseListingLimit(Request $request, User $user) {
        $additional_slots = $request->input(['additional_slots']);
        $amount = $request->input(['amount']);

        return view('services.payment',compact('additional_slots', 'amount'));
    }

    public function increaseLimit(Request $request, User $user) {
        $payment = Payment::create([
            'sender_id' => Auth::id(),
            'amount' => $request->amount
        ]);

        $user->update([
            'listing_limit' => $user->listing_limit + $request->additional_slots
        ]);
        return redirect()->route('user.profile')->with('status', 'Your listing limit has been increased successfully.');
    }
}
