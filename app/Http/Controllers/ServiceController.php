<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceImage;
use App\Models\User;
use Carbon\Carbon;

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
        if( Auth::user()->role != 'user') return abort(403);

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
            'image' => 'required|image|mimes:jpg,png,bmp,gif|max:5120',
        ]);

        $path = $request->file('image')->store('images/service-images', 'public');


        // return JSON with whatever you need
        return response()->json([
            'success'   => true,
            'file_path' => $path,
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

        if($service->user_id != Auth::id()) return abort(403);
        $categories = Category::all();
        $cities = City::all();
        return view('user.services.user-edit-service', compact('service', 'categories', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {

        $service->fill($request->validated());
        $service->save();

        if($request->has('images')) {
            foreach($request->file('images') as $image) {
                $path = $image->store('images/service-images', 'public');

                ServiceImage::create([
                    'service_id'=> $service->id,
                    'image' => $path,
                ]);

            }

        }

        return redirect()->route('user.services', Auth::user())->with('success', 'Service has been updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
       if($service->user_id != Auth::id()) abort(403);

       $service->delete();

       return response()->noContent();
    }

    public function activate(Service $service) {


        $service->status == 'inactive' ? $service->update(['status'=> 'active']) : $service->update(['status'=> 'inactive']);;

        return response()->noContent();
    }

    public function showPaymentPage(Request $request, Service $service) {
        $days = $request->input('days');
        $amount = $request->input('amount');

        return view('services.payment',compact('service', 'days', 'amount'));
    }

    public function promote(Request $request, Service $service)
    {

        // dd($service->status);
        if ($service->status == 'inactive') {
            $service->update(['status' => 'active']);
        }

        $payment = Payment::create([
            'sender_id' => Auth::id(),
            'service_id' => $request->service_id,
            'amount' => $request->amount
        ]);
        $service->update([
            'is_featured' => 1,
            'featured_until' => Carbon::now()->addDays(intval($request->days))
        ]);

        $service = Service::find($request->service_id);

        return redirect()
            ->route('user.services', Auth::user())
            ->with('status', $service->title . ' Has been promoted');

    }


}
