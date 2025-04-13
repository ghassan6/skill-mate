<?php

namespace App\Http\Controllers;

use App\Models\SavedService;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SavedServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function toggleSaved(Service $service)
    {
        $user = Auth::user();

        // Get the record including soft-deleted ones
        $saved = SavedService::withTrashed()
                    ->where('user_id', $user->id)
                    ->where('service_id', $service->id)
                    ->first();

        if ($saved) {
            if ($saved->trashed()) {
                // The record is soft-deleted; restore it.
                $saved->restore();
                $message = 'Added to saved services';
                $status = 'added';
            } else {
                // The record exists and is active; delete (soft-delete) it.
                $saved->delete();
                $message = 'Removed from saved services';
                $status = 'removed';
            }
        } else {
            // No record exists at all; create a new one.
            SavedService::create([
                'user_id'    => $user->id,
                'service_id' => $service->id,
            ]);
            $message = 'Added to saved services';
            $status = 'added';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'status'   => $status,
                'message'  => $message,
                'is_saved' => $status === 'added'
            ]);
        }

        return back()->with('status', $message);
    }



    public function index()
    {
        $user = Auth::user();
        // dd(method_exists($user, 'savedServices'));
        $services = Auth::user()->savedServiceItems()
                    ->with(['user', 'category', 'city', 'images'])
                    ->paginate(10);
        // dd($services);

        return view('user.saved-services', compact('services'));
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
    public function show(SavedService $savedService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedService $savedService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedService $savedService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedService $savedService)
    {
        //
    }
}
