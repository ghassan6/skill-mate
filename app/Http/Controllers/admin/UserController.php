<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\unbanned;
use App\Mail\userBanned;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated and has the 'admin' role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }


        // Return the view with the users data
        return view('admin.users.index');
    }

    public function destroy(User $user) {
        if (Auth::id() === $user->id) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }
        $user->delete();
        return redirect()->back()->with('status', 'User Deleted successfully');
    }

    public function toggleBanUser(User $user) {
        is_null($user->banned_at) ? $user->update(['banned_at' => now()]) : $user->update(['banned_at' => null]);

        if(!is_null($user->banned_at)) {
            Mail::to($user)->send(
                new userBanned($user)
            );
        }
        else {
            Mail::to($user)->send(
                new unbanned($user)
            );
        }
        
        return Response()->noContent();

    }

    public function create() {

        $cities = City::all();
        return view('admin.users.create' , compact('cities'));
    }

    public function store(CreateUserRequest $request) {


        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user',
            'city_id' => $request->city_id,
            'phone_number' => $request->phone,
            'listing_limit' => $request->listing_limit,

        ]);
        if($request->has('email_verified')) {
            $user->email_verified_at = now();
            $user->save();
        }

        if($request->has('image')) {
            $image = $request->file('image');
            $path = $image->store('images/user-profile', 'public');
            $user->image = $path;
            $user->save();
        }

        return redirect()->back()->with('status' , 'User created successfully');
    }

    public function show(User $user) {

    }

    public function edit(User $user) {
        $cities = City::all();
        return view('admin.users.edit-user', compact('user', 'cities'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // Remove password from the update array
        }

        if($request->has('email_verified')) {
            $user->email_verified_at = now();
            $user->save();
        }

        $user->fill($data);
        $user->save();

        return redirect()->back()->with('status', 'User Updates successfully!');
    }

    public function banAppeal() {


        return view('admin.users.ban-appeal');
    }
}
