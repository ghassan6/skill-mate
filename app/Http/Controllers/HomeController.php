<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::take(3)->get();
        // dd($categories);
        return view('index' , compact('categories'));
    }
}
