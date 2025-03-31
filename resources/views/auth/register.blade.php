<x-layout>
<!-- import a css file -->
<link href="{{asset('css/forms.css')}}" rel="stylesheet" type="text/css">
    <x-slot:title>Register</x-slot>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-2">
        <div class="row justify-content-center">
            <!-- Left Side: Registration Form -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf

                            <!-- Username -->
                            <div class="mb-3">
                                <x-input-label for="username" >Username <span class="red-asterisk">*</span> </x-input-label>
                                <x-text-input type="text" name="username" id="username" value="{{ old('username')}}" placeholder="e.g. Jondoe132"  required/>
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- First Name & Last Name (Side by Side) -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <x-input-label for="first_name" >First Name <span class="red-asterisk">*</span></x-input-label>
                                    <x-text-input type="text" name="first_name" id="first_name" value="{{ old('first_name')}}" placeholder="e.g. Jon"  required/>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-input-label for="last_name" >Last Name <span class="red-asterisk">*</span></x-input-label>
                                    <x-text-input type="text" name="last_name" id="last_name" value="{{ old('last_name')}}" placeholder="e.g. Doe"  required/>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <x-input-label for="email" >Email <span class="red-asterisk">*</span></x-input-label>
                                <x-text-input type="email" name="email" id="email" value="{{ old('email')}}" placeholder="e.g. Email@example.com"  required/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" >Password <span class="red-asterisk">*</span></x-input-label>
                                <x-text-input type="password" name="password" id="password" required/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <div class="form-text">
                                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, or emoji.
                                </div>


                            </div>

                            <div class="mb-3">
                                <x-input-label for="password_confirmation" >Confirm Password <span class="red-asterisk">*</span></x-input-label>
                                <x-text-input type="password" name="password_confirmation" id="password_confirmation" required/>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                            </div>

                            <!-- City Dropdown -->
                            <div class="mb-3">
                                <x-input-label for="city" >City</x-input-label>
                                <select name="city" id="city" class="form-select">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{Str::ucfirst( $city->name )}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <x-input-label for="phone" >Phone Number <span class="red-asterisk">*</span></x-input-label>
                                <x-text-input type="tel" name="phone" id="phone" value="{{ old('phone')}}" placeholder="e.g. 07XXXXXXXX"  required/>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div class="text-muted mt-3 mb-3">
                                Fields with <span class="red-asterisk">*</span> Required
                            </div>


                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>

                            <div class="text-center mt-3">
                                Already have an account? <a href="{{ route('login') }}" class="text-primary">Log in</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Image Section -->
            <div class="col-md-6 d-none d-md-block">
                <div class="image-section" style="background-image: url('{{ asset('images/main/background.jpg') }}');">
                </div>
            </div>
        </div>
    </div>
</x-layout>
