<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $userId = Auth::id();

        //  Check if current user has an accepted inquiry on this service
        $hasAccepted = Inquiry::where([
                            ['service_id', $service->id],
                            ['user_id',    $userId],
                            ['status',     'accepted'],
                        ])->exists();

        //   grab that inquiry’s ID only if the provider accepted his inquiry
        $acceptedInquiryId = $hasAccepted
            ? Inquiry::where([
                  ['service_id', $service->id],
                  ['user_id',    $userId],
                  ['status',     'accepted'],
              ])->value('id')
            : null;

        return view('services.singleService' , compact('service' , 'hasAccepted', 'acceptedInquiryId'));
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
}
