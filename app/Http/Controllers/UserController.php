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


    public function services() {
        $services = Auth::user()->services()->with('images', 'city', 'category')
        ->orderByDesc('is_featured')
        ->orderBy('featured_until')
        ->orderByDesc('status')
        ->paginate(10); /* eager loading */
        $activeCount = Auth::user()->services->where('status', 'active')->count();
        $inactiveCount = Auth::user()->services->where('status', 'inactive')->count();
        $featuredCount = Auth::user()->services->where('is_featured', 1)->count();

         return view('user.services.user-services' , compact('services', 'activeCount', 'inactiveCount', 'featuredCount'));
    }

    // for public routes

    public function show(User $user) {

        return view('user.public-profile' , compact('user'));
    }
}
