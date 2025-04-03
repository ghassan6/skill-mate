<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {     
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']); 
        } else {
            unset($data['password']); // Remove password from the update array
        }
        $request->user()->fill($data);
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }   

        
        Auth::user()->image = $request->file('image') ? $request->file('image')->store('images/user-profile', 'public') : $request->user()->image;
        $request->user()->save();

        return Redirect::route('user.profile')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
