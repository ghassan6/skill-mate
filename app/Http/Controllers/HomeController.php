<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at' , 'desc')
        ->take(3)->get();
        $services = Service::all();
        return view('index' , compact('categories', 'services'));
    }

    public function about()
    {
        return view('about');
    }

}
