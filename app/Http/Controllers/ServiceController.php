<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceImage;
use App\Models\User;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::check()) return redirect()->route('login');
        $categories = Category::all();
        $cities = City::all();
        return view('user.services.user-service-create' , compact('categories', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        if(!Auth::check()) return redirect()->route('login');

        $service = new Service;

        $service->title = $request->title;
        $service->category_id = $request->category_id;
        $service->description = $request->description;
        $service->hourly_rate = $request->hourly_rate;
        $service->city_id = $request->city_id;
        $service->address = $request->address;
        $service->user_id = Auth::user()->id;
        $service->slug = $service->createSlug($request->title);
        $service->save();

          foreach ($request->uploaded_images as $filePath) {
            // if you returned DB IDs instead, you could just do a relation attach
            ServiceImage::create([
                'image' => $filePath,
                'service_id' => $service->id
            ]);
        }

        // update the listing limit after adding a new service
        $user = Auth::user();
        $user->listing_limit = $user->listing_limit - 1;
        $user->save();


        return redirect()->route('user.profile')->with('status', 'Service published!');
    }

    public function upload(Request $request)
    {
        if(!Auth::check()) return redirect()->route('login');

        // validate one image
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,bmp|max:5120',
        ]);

        // store under storage/app/public/temp-service-images
        $path = $request->file('image')->store('service-images', 'public');


        // return JSON with whatever you need
        return response()->json([
            'success'   => true,
            'file_path' => Storage::url($path),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        $userId = Auth::id();

        //  Check if current user has an accepted inquiry on this service
        $hasAccepted = Inquiry::where([
                            ['service_id', $service->id],
                            ['user_id',    $userId],
                            ['status',     'accepted'],
                        ])->exists();

        //  grab that inquiry’s ID only if the provider accepted his inquiry
        $acceptedInquiryId = $hasAccepted
            ? Inquiry::where([
                  ['service_id', $service->id],
                  ['user_id',    $userId],
                  ['status',     'accepted'],
              ])->value('id')
            : null;

        if($service->reviews()->where('user_id', Auth::id())->exists()) {
            $reviews = $service->reviews()->where('user_id', Auth::id())->get();

            $reviews = $reviews->merge($service->reviews()->latest()->get());
        }

        else {
            $reviews = $service->reviews()
            ->latest()
            ->get();
        }
        // no pagination

        // dd($service->reviews);
        return view('services.singleService' , compact('service' , 'hasAccepted', 'acceptedInquiryId', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }

    public function activate() {

    }
    public function promote() {

    }


}
