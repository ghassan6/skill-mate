<x-layout>
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet" type="text/css">
    <x-slot:title>Register</x-slot>

    <!-- Floating Alert for Success -->
    @if (session('success'))
        <div class="alert-floating">
            <div class="alert alert-success shadow-lg fade-in">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="register-container">
        <!-- Animated Background Side -->
        <div class="register-hero">
            <div class="hero-image" style="background-image: url('{{ asset('images/main/background.jpg') }}');"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2 class="hero-title">Join Our Community!</h2>
                <p class="hero-text">Connect with skilled professionals or find the services you need</p>
                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <span>Secure & Private</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bolt feature-icon"></i>
                        <span>Fast Registration</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users feature-icon"></i>
                        <span>Thousands of Members</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Form Side -->
        <div class="register-form-container">
            <div class="form-card slide-up">
                <div class="form-header">
                    <div class="logo-container">
                        <i class="fas fa-user-plus logo-icon"></i>
                    </div>
                    <h3 class="form-title">Create Account</h3>
                    <p class="form-subtitle">Join us in just a few steps</p>
                </div>

                <form action="{{ route('register') }}" method="POST" id="register-form" class="form-body">
                    @csrf

                    <!-- Progress Steps -->
                    <div class="form-steps">
                        <div class="step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Basic Info</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Account Details</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-circle">3</div>
                            <div class="step-label">Location</div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                    </div>

                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" data-step="1">
                        <!-- Username -->
                        <div class="form-group floating-label">
                            <x-text-input type="text" name="username" id="username" value="{{ old('username')}}" placeholder=" " required/>
                            <x-input-label for="username">Username</x-input-label>
                            <i class="fas fa-user input-icon"></i>
                            <x-input-error :messages="$errors->get('username')" class="error-message" />
                            <div class="form-hint">e.g. jondoe132</div>
                            <p class="text-danger err" id="username-error"></p>
                        </div>

                        <!-- First & Last Name -->
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group floating-label">
                                    <x-text-input type="text" name="first_name" id="first_name" value="{{ old('first_name')}}" placeholder=" " required/>
                                    <x-input-label for="first_name">First Name</x-input-label>
                                    <i class="fas fa-signature input-icon"></i>
                                    <x-input-error :messages="$errors->get('first_name')" class="error-message" />
                                    <p class="text-danger err" id="first_name-error"></p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group floating-label">
                                    <x-text-input type="text" name="last_name" id="last_name" value="{{ old('last_name')}}" placeholder=" " required/>
                                    <x-input-label for="last_name">Last Name</x-input-label>
                                    <i class="fas fa-signature input-icon"></i>
                                    <x-input-error :messages="$errors->get('last_name')" class="error-message" />
                                    <p class="text-danger err" id="last_name-error"></p>

                                </div>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn-next" data-next="2">Continue <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 2: Account Details -->
                    <div class="form-step" data-step="2">
                        <!-- Email -->
                        <div class="form-group floating-label">
                            <x-text-input type="email" name="email" id="email" value="{{ old('email')}}" placeholder=" " required/>
                            <x-input-label for="email">Email Address</x-input-label>
                            <i class="fas fa-envelope input-icon"></i>
                            <x-input-error :messages="$errors->get('email')" class="error-message" />
                            <p class="text-danger err" id="email-error"></p>

                        </div>

                        <!-- Phone -->
                        <div class="form-group floating-label">
                            <x-text-input type="tel" name="phone" id="phone" value="{{ old('phone')}}" placeholder=" " />
                            <x-input-label for="phone">Phone Number</x-input-label>
                            <i class="fas fa-phone input-icon"></i>
                            <x-input-error :messages="$errors->get('phone')" class="error-message" />
                            <div class="form-hint">Format: 07XXXXXXXX</div>
                            <p class="text-danger err" id="phone-error"></p>

                        </div>

                        <!-- Password -->
                        <div class="form-group floating-label">
                            <x-text-input type="password" name="password" id="password" placeholder=" " required/>
                            <x-input-label for="password">Password</x-input-label>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" aria-label="Show password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <x-input-error :messages="$errors->get('password')" class="error-message" />
                            <div class="password-strength">
                                <div class="strength-meter">
                                    <div class="strength-fill" data-strength="0"></div>
                                </div>
                                <div class="strength-text">Password Strength: <span>Weak</span></div>
                            </div>
                            <div class="form-hint">6-18 characters, uppercase & lowercase, no spaces or emoji</div>
                        </div>
                        <p class="text-danger err" id="password-error"></p>


                        <!-- Confirm Password -->
                        <div class="form-group floating-label">
                            <x-text-input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required/>
                            <x-input-label for="password_confirmation">Confirm Password</x-input-label>
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" aria-label="Show password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="error-message" />
                            <p class="text-danger err" id="password_confirmation-error"></p>

                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn-prev" data-prev="1"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="button" class="btn-next" data-next="3">Continue <i class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 3: Location & Terms -->
                    <div class="form-step" data-step="3">
                        <!-- City Dropdown -->
                        <div class="form-group floating-label">
                            <select name="city_id" id="city_id" class="form-select" required>
                                <option value="" disabled selected></option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ Str::ucfirst($city->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-label for="city_id">Your City</x-input-label>
                            <i class="fas fa-city input-icon"></i>
                            <x-input-error :messages="$errors->get('city_id')" class="error-message" />
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="form-group terms-checkbox">
                            <input type="checkbox" name="terms" id="terms" required class="form-check-input">
                            <label for="terms">
                                I agree to the <a href="{{ route('terms') }}" target="_blank" class="terms-link">Terms and Conditions</a>
                            </label>
                            <x-input-error :messages="$errors->get('terms')" class="error-message" />
                        </div>

                        <div class="required-fields-note">
                            <span class="red-asterisk">*</span> Indicates required field
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn-prev" data-prev="2"><i class="fas fa-arrow-left me-2"></i> Back</button>
                            <button type="submit" class="btn-register" id="register-btn">
                                <span class="btn-text">Complete Registration</span>
                                <i class="fas fa-user-plus btn-icon"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="form-footer">
                    Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>
</x-layout>
