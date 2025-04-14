<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreInquiryRequest $request)
    {
        // dd($request->validated());

        Inquiry::create([
            'user_id' => Auth::user()->id,
            'service_id' => $request->service_id,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success' , 'Message has been sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
