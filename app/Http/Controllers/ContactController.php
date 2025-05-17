<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {


        $validatedData = $request->validated();
        $contactData = Contact::create($validatedData);

        // Send email to admin
        Mail::to('skillmate.services@gmail.com')
            ->send(new ContactMail($contactData));


        return redirect()->route('contact.index')->with('success', 'Your message has been sent!, We will get back to shortly!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if(!Auth::check() && Auth::user()->role != 'admin') {abort(403);}

        $contact->delete();

        return response()->noContent();
    }
}
