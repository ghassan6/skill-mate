<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
}
