<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // redirect admin to dashboard
        if(Auth::check() && Auth::user()->role == 'admin') return redirect()->route('admin.dashboard');

        $categories = Category::orderBy('created_at' , 'asc')
        ->take(4)->get();

        $services = Service::all();
        $featuredServices = Service::with('images')
        ->where('is_featured' , 1)
        ->orderByDesc('created_at')
        ->get();

        return view('index' , compact('categories', 'services', 'featuredServices'));
    }

    public function about()
    {
        return view('about');
    }

}
