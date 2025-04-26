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
        ->take(3)->get();

        $services = Service::all();
        return view('index' , compact('categories', 'services'));
    }

    public function about()
    {
        return view('about');
    }

}
