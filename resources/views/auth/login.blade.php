<x-layout>
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet" type="text/css">
    <x-slot:title>Login</x-slot>

    <!-- Floating Alert for Errors -->
    @if (session('error'))
        <div class="alert-floating">
            <div class="alert alert-danger shadow-lg fade-in">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="login-container">
        <!-- Animated Background Side -->
        <div class="login-hero">
            <div class="hero-image" style="background-image: url('{{ asset('images/main/cleaning.jpg') }}');"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2 class="hero-title">Welcome Back!</h2>
                <p class="hero-text">Connect with skilled professionals or find the services you need</p>
                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <span>Secure & Private</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bolt feature-icon"></i>
                        <span>Instant Access</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Form Side -->
        <div class="login-form-container">
            <div class="form-card slide-up">
                <div class="form-header">
                    <div class="logo-container">
                        <i class="fas fa-hands-helping logo-icon"></i>
                    </div>
                    <h3 class="form-title">Sign In</h3>
                    <p class="form-subtitle">Access your account to continue</p>
                </div>

                <form action="{{ route('login') }}" method="POST" id="login-form" class="form-body">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group floating-label">
                        <x-text-input type="email" name="email" id="email" value="{{ old('email')}}" required/>
                        <x-input-label for="email">Email Address</x-input-label>
                        <i class="fas fa-envelope input-icon"></i>
                        <x-input-error :messages="$errors->get('email')" class="error-message" />
                    </div>

                    <!-- Password Field -->
                    <div class="form-group floating-label">
                        <x-text-input type="password" name="password" id="password" required/>
                        <x-input-label for="password">Password</x-input-label>
                        <i class="fas fa-lock input-icon"></i>
                        <x-input-error :messages="$errors->get('password')" class="error-message" />
                        <button type="button" class="password-toggle" aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="form-options">
                        <div class="form-check remember-me">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login" id="login-btn" disabled>
                        <span class="btn-text">Login</span>
                        <i class="fas fa-arrow-right btn-icon"></i>
                    </button>

                    <!-- Registration Link -->
                    <div class="register-link">
                        Don't have an account? <a href="{{ route('register') }}" class="register-text">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/login.js')}}" defer></script>

</x-layout>
