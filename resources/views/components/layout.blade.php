<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/main/wrench-tool.png')}}">
    @livewireStyles
    @livewireScripts
    <script src="https://js.pusher.com/8.4/pusher.min.js"></script>
    <script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>


    <title>{{ $title}}</title>

        <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">



    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- boxicon link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- favicon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr Plugins (for additional features) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>

</head>
<body>
<div class="container-fluid nav-bar bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
            <a href="/" class="navbar-brand d-flex align-items-center m-0 p-0 d-lg-none">
                <h1 class="text-primary m-0">SkillMate</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <x-application-logo></x-application-logo>
                <div class="navbar-nav me-auto">
                    <x-nav-link href="{{route('home')}}" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="{{route('about')}}" :active="request()->is('about')" >About</x-nav-link>
                    <x-nav-link href="{{route('categories.index')}}" :active="request()->is('categories')" >Categories</x-nav-link>
                    <x-nav-link href="{{route('contact.index')}}" :active="request()->is('contact')">Contact</x-nav-link>
                </div>
                @if(Auth::check())
                    <div class="d-flex align-items-center">
                        <!-- Notification Bell Icon with Badge -->
                        <div class="position-relative me-4">
                            <a href="{{ route('user.notifications') }}" class="nav-link position-relative">
                                <i class="fas fa-bell fa-lg"></i>
                                @if($unreadCount = Auth::user()->unreadNotifications->where('type' , '!=', \App\Notifications\NewInquiryNotification::class)->count())
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="position-relative me-3">
                            <a href="{{ route('inquiries.requests') }}" class="nav-link position-relative">
                                <i class="fas fa-helmet-safety fa-lg"></i>
                                @if($unreadCount = Auth::user()->unreadNotifications->where('type' , \App\Notifications\NewInquiryNotification::class)->count())
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                        <span class="visually-hidden">unread inquires requests</span>
                                    </span>
                                @endif
                            </a>
                        </div>

                        <!-- User Dropdown -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset(str_contains(Auth::user()->image, 'profile') ? 'storage/' . Auth::user()->image : Auth::user()->image) }}"
                                    alt="{{ Auth::user()->username }}'s image"
                                    class="profile-image-dropdown rounded-circle me-2">
                                    {{ Auth::user()->username }}
                            </a>
                            <div class="dropdown-menu fade-up m-0 box-shadow px-2 mt-2">
                                <x-nav-link href="{{ route('user.profile') }}" class="dropdown-item mb-2 fs-5">
                                    <i class="fas fa-user me-2"></i> Account
                                </x-nav-link>
                                <x-nav-link href="{{ route('saved-services.index') }}" class="dropdown-item mb-2 fs-5">
                                    <i class="fas fa-heart me-2"></i> Favorites
                                </x-nav-link>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-link p-0 ms-n3 text-decoration-none text-black fs-5">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                <div class="navbar-nav">
                    <x-nav-link href="{{route('login')}}" class="nav-item nav-link" :active="request()->is('login')">Login</x-nav-link>
                    <x-nav-link href="{{route('register')}}" class="nav-item nav-link" :active="request()->is('register')">Register</x-nav-link>
                </div>
            @endif
            </div>
        </nav>
    </div>

    {{ $slot }}


  <x-footer></x-footer>


</body>
</html>
