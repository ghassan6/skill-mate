<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Models\Service;
use App\Notifications\NewInquiryNotification;
use App\Notifications\InquiryResponseNotification;
use App\Notifications\ServiceCompletedNotification;
use Illuminate\Auth\Events\Validated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function requests()
     {
         $user = Auth::user();

         // 1. Pull only the “new inquiry” notifications
         $notifications = $user->notifications()
             ->where('type', NewInquiryNotification::class)
             ->paginate(10);

         // 2. Build an array of “date slots” so we can detect overlaps
         $slots = [];
         foreach ($notifications as $i => $notification) {
            $inquiryId = $notification->data['inquiry_id'];
            $inquiry = Inquiry::find($inquiryId);

            // Only include if inquiry is still pending
            if (!$inquiry || $inquiry->status !== 'pending') {
                continue;
            }

             $slots[$i] = [
                 'id'      => $notification->data['inquiry_id'],
                 'service' => $notification->data['service_id'],
                 'start'   => Carbon::parse($notification->data['preferred_datetime']),
                 'end'     => Carbon::parse($notification->data['preferred_datetime'])
                                      ->addHours((int)$notification->data['estimated_hours']),
             ];
         }

         // 3. Build a map inquiry_id => bool hasConflict
         $conflictFlags = [];
         foreach ($slots as $i => $slotA) {
             $hasConflict = false;

             foreach ($slots as $j => $slotB) {
                 if ($i === $j) continue;
                 if ($slotA['id'] !== $slotB['id']  // different inquiries
                    && $slotA['service'] === $slotB['service'] // same service
                  && $slotA['start']->lt($slotB['end'])
                  && $slotA['end']->gt($slotB['start'])) {
                     $hasConflict = true;
                     break;
                 }
             }

             $conflictFlags[$slotA['id']] = $hasConflict;
         }
         return view('user.inquiries-requests', compact('notifications','conflictFlags'));
     }

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
            'estimated_hours' => $request->estimated_hours,
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

        $action = $request->input('action'); // 'accept' or 'reject'

        if (! in_array($action, ['accept','reject'])) {
            abort(422);
        }

        $inquiry->status = $action === 'accept' ? 'accepted' : 'rejected';

        $notification = Auth::user()->notifications()
        ->where('data->inquiry_id', $inquiry->id)
        ->where('type', NewInquiryNotification::class)
        ->first();

        // Mark the notification as read
        if ($notification) {
            $notification->markAsRead();
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
        // Optionally, ensure the authenticated user is the seeker
         if (Auth::id() !== $inquiry->user_id) { abort(403); }

        $inquiry->status = 'completed';
        $inquiry->completed_at = now();
        $inquiry->save();


        $inquiry->user->notify(new ServiceCompletedNotification($inquiry));
        $inquiry->service->user->notify(new ServiceCompletedNotification($inquiry));

        return back()->with('success', 'Service marked as completed.');
    }


    public function resolveConflict(Request $request)
    {
        $request->validate([
            'accept_id' => 'required|exists:inquiries,id',
            'message' => 'nullable|string|max:255',
        ], [
            'accept_id.required' => 'Please Select one Inquiry to proceed'
        ]);

        $acceptId = $request->input('accept_id');
        $message = $request->input('message');

        $acceptedInquiry = Inquiry::findOrFail($acceptId);
        $serviceID = $acceptedInquiry->service_id;

        $acceptedStart = Carbon::parse($acceptedInquiry->preferred_datetime);
        $acceptedEnd = $acceptedStart->copy()->addHours((int)$acceptedInquiry->estimated_hours);

        $conflictingInquiries = Inquiry::where('service_id', $serviceID)
            ->where('status', 'pending')
            ->where('id', '!=', $acceptId)
            ->get()
            ->filter(function ($inquiry) use ($acceptedStart, $acceptedEnd) {
                $start = Carbon::parse($inquiry->preferred_datetime);
                $end = $start->copy()->addHours((int)$inquiry->estimated_hours);

                return $start->lt($acceptedEnd) && $end->gt($acceptedStart);
            });

        // Reject conflicting ones
        foreach ($conflictingInquiries as $inquiry) {
            $inquiry->status = 'rejected';
            $inquiry->save();

            $inquiry->user->notify(new InquiryResponseNotification($inquiry, 'reject', $message));
        }

        // Accept the selected one
        $acceptedInquiry->status = 'accepted';
        $acceptedInquiry->save();
        $acceptedInquiry->user->notify(new InquiryResponseNotification($acceptedInquiry, 'accept'));

        return redirect()->route('inquiries.requests')->with('success', 'Conflict resolved: one accepted, conflicting ones rejected.');
    }



}
