<x-layout>
<!-- import a css file -->
<link href="{{ asset('css/forms.css') }}" rel="stylesheet" type="text/css">
    <x-slot:title>Login</x-slot>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mt-2">
        <div class="row justify-content-center">
            <!-- Left Side: Image Section -->
            <div class="col-md-6 d-none d-md-block">
                <div class="image-section" style="background-image: url('{{ asset('images/main/cleaning.jpg') }}');">
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <!-- Email or Username -->
                            <div class="mb-3">
                                <x-input-label for="email" >Email <span class="red-asterisk">*</span> </x-input-label>
                                <x-text-input type="email" name="email" id="email" value="{{ old('email')}}" placeholder="e.g. email@example.com" required/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" >Password <span class="red-asterisk">*</span></x-input-label>
                                <x-text-input type="password" name="password" id="password" required/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-primary">Forgot Your Password?</a>
                                </div>
                            </div>

                            <div class="text-muted mt-3 mb-3">
                                Fields with <span class="red-asterisk">*</span> are Required
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                            <div class="text-center mt-3">
                                Don't have an account? <a href="{{ route('register') }}" class="text-primary">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
