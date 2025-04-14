<?php

namespace App\Http\Controllers;

use App\Models\City;
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

    public function notifications() {
         return view('user.notifications');
    }

    public function services() {
         return view('user.services');
    }

    // for public routes

    public function show(User $user) {

        return view('user.public-profile' , compact('user'));
    }
}
