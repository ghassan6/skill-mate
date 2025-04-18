<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Notifications\NewInquiryNotification;
use App\Notifications\InquiryResponseNotification;
use App\Notifications\ServiceCompletedNotification;
use Illuminate\Auth\Events\Validated;

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

        $inquiry = Inquiry::create([
            'user_id' => Auth::user()->id,
            'service_id' => $request->service_id,
            'message' => $request->message,
            'preferred_datetime' => $request->preferred_datetime,
            'status' => 'pending'
        ]);

        $provider = $inquiry->service->user;

        $provider->notify(new NewInquiryNotification($inquiry));



        return redirect()->back()->with('success' , 'Inquiry has been sent to ' . $inquiry->service->user->username);
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
        $action = $request->input('action');

        if ($action === 'accept') {
            $inquiry->status = 'accepted';
            } elseif ($action === 'reject') {
                $inquiry->status = 'rejected';
            }

        // dd($inquiry->user_id);
        $seeker = $inquiry->user;
        $seeker->notify(new InquiryResponseNotification($inquiry, $action));
        $inquiry->save();

        return back()->with('success', 'Inquiry has been ' . $action . 'ed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }

    public function markInquiryCompleted(Inquiry $inquiry)
    {
        // Optionally, ensure the authenticated user is the seeker or provider
         if (Auth::id() !== $inquiry->user_id) { abort(403); }
         
        $inquiry->status = 'completed';
        $inquiry->completed_at = now();
        $inquiry->save();

        // Optionally notify the other party or trigger review prompt:
        $inquiry->user->notify(new ServiceCompletedNotification($inquiry));
        $inquiry->service->user->notify(new ServiceCompletedNotification($inquiry));

        return back()->with('success', 'Service marked as completed.');
    }
}
