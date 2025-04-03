<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
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
                    <x-nav-link href="{{route('home')}}" class=" nav-item nav-link " :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="{{route('about')}}" class=" nav-item nav-link" :active="request()->is('about')" >About</x-nav-link>
                    <x-nav-link href="{{route('services')}}" class="nav-item nav-link" :active="request()->is('services')" >Services</x-nav-link>
                    <x-nav-link href="{{route('contact')}}" class="nav-item nav-link" :active="request()->is('contact')">Contact</x-nav-link>
                    <!-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu fade-up m-0">
                            <a href="booking.html" class="dropdown-item">Booking</a>
                            <a href="team.html" class="dropdown-item">Technicians</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div> -->
                </div>
                @if(Auth::check()) 
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->username }}</a>
                        <div class="dropdown-menu fade-up m-0">
                            <x-nav-link href="/dashboard" class="dropdown-item">Dashboard</x-nav-link>
                            <x-nav-link href="{{route('user.profile')}}" class="dropdown-item">Account</x-nav-link>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-link p-0 m-0 text-decoration-none text-black">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                <div class="navbar-nav">
                    <x-nav-link href="/login" class="nav-item nav-link " :active="request()->is('login')">Login</x-nav-link >
                    <x-nav-link  href="/register" class="nav-item nav-link" :active="request()->is('register')">Register</x-nav-link >
                </div>
                @endif
            </div>
        </nav>
    </div>

    {{ $slot }}


    <footer class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 col-xl-2 mx-auto mb-0">
                    <h5 class="text-uppercase fw-bold">About</h5>
                    <x-footer-hr></x-footer-hr>
                    <p>
                    We connect freelancers and clients, offering a seamless platform for hiring and providing services.

                    </p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>skilmate@example.com</p>
                    <!-- <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div> -->
                </div>
                <div class="col-lg-3 col-md-6 col-xl-2 mx-auto mb-0">
                    <h5 class="text-uppercase fw-bold">Quick Links</h5>
                    <x-footer-hr></x-footer-hr>
                    <x-footer-link  href="{{route('home')}}">Home </x-footer-link>
                    <x-footer-link href="{{ route('about')}}">About</x-footer-link>
                    <x-footer-link  href="{{ route('services') }}">Browse Services</x-footer-link>
                    <x-footer-link  href="{{ route('contact')}}">Contact</x-footer-link>
                    <a  href=""></a>
                </div>
                <!-- <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <x-footer-hr></x-footer-hr>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div> -->

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-0">
                <h5 class="text-uppercase fw-bold">Support</h5>
                <x-footer-hr></x-footer-hr>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none">FAQs</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Terms of Service</a></li>
                </ul>
            </div>
                
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="text-decoration-none" href=""><strong>Skill mate</strong></a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
</body>
</html>