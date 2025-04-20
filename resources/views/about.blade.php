<x-layout>
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
    <x-slot:title>About Us</x-slot>

    <!-- Main Container with Fade Animation -->
    <div id="page-container" class="page-fade">
        <!-- Hero Section -->
        <section class="about-hero py-5 py-lg-7 position-relative overflow-hidden">
            <div class="container position-relative z-index-1">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="display-3 fw-bold mb-4 text-gradient-primary">Skill Mate</h1>
                        <p class="lead fs-2 text-muted mb-5">Empowering connections through trusted services</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 shadow-sm hover-lift transition-link">
                                Join Our Community <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            <a href="#how-it-works" class="btn btn-outline-primary btn-lg px-4 py-3 hover-lift">
                                Learn More <i class="fas fa-info-circle ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animated Background Elements -->
            <div class="">
                <div class="about-hero-shape-1"></div>
                <div class="about-hero-shape-2"></div>
                <div class="about-hero-shape-3"></div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-5 py-lg-7 bg-light">
            <div class="container">
                <div class="row align-items-center g-5 mb-5">
                    <div class="col-lg-7">
                        <h3 class="mb-4 text-gradient-primary">Our Mission</h3>
                        <p class="fs-5 mb-4">We're revolutionizing service connections by creating a trusted ecosystem where skills meet needs.</p>
                        <p class="mb-0">Whether you're a freelancer, technician, or business owner, our platform amplifies your reach while ensuring quality and reliability for those seeking services.</p>
                    </div>
                    <div class="col-lg-5">
                        <img src="{{ asset('images/main/mission.jpg') }}" alt="Our Mission" class="img-fluid rounded-4 shadow-lg hover-scale">
                    </div>
                </div>
            </div>
        </section>

        <!-- What We Do Section -->
        <section class="py-5 py-lg-7" id="how-it-works">
            <div class="container">
                <div class="row align-items-center g-5 mb-5">


                    <div class="col-lg-5 order-lg-1">
                        <img src="{{ asset('images/main/about-service.jpg') }}" alt="Our Services" class="img-fluid rounded-4 shadow-lg hover-scale">
                    </div>

                    <div class="col-lg-7">
                        <h3 class="mb-4 text-gradient-primary">How It Works</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-primary-light text-primary rounded-circle me-3">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Discover Services</h5>
                                    <p class="text-muted mb-0">Browse our extensive directory of skilled professionals</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-primary-light text-primary rounded-circle me-3">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Connect Directly</h5>
                                    <p class="text-muted mb-0">Secure messaging to discuss your specific needs</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-primary-light text-primary rounded-circle me-3">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Get It Done</h5>
                                    <p class="text-muted mb-0">Hire with confidence using our verified system</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="py-5 py-lg-7 bg-light">
            <div class="container">
                <div class="row align-items-center g-5 mb-5">
                    <div class="col-lg-7">
                        <h3 class="mb-4 text-gradient-primary">Why Choose Skill Mate?</h3>
                        <div class="features-grid">
                            <div class="feature-card bg-white rounded-4 p-4 shadow-sm hover-lift">
                                <div class="icon-box-lg bg-primary-light text-primary mb-3">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h5 class="mb-2">Verified Professionals</h5>
                                <p class="text-muted mb-0">All providers undergo strict verification</p>
                            </div>
                            <div class="feature-card bg-white rounded-4 p-4 shadow-sm hover-lift">
                                <div class="icon-box-lg bg-primary-light text-primary mb-3">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <h5 class="mb-2">Secure Payments</h5>
                                <p class="text-muted mb-0">Protected transactions with escrow options</p>
                            </div>
                            <div class="feature-card bg-white rounded-4 p-4 shadow-sm hover-lift">
                                <div class="icon-box-lg bg-primary-light text-primary mb-3">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h5 class="mb-2">Rating System</h5>
                                <p class="text-muted mb-0">Transparent reviews from real clients</p>
                            </div>
                            <div class="feature-card bg-white rounded-4 p-4 shadow-sm hover-lift">
                                <div class="icon-box-lg bg-primary-light text-primary mb-3">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <h5 class="mb-2">24/7 Support</h5>
                                <p class="text-muted mb-0">Dedicated team to assist you</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img src="{{ asset('images/main/what-we-do.jpg') }}" alt="What We Do" class="img-fluid rounded-4 shadow-lg hover-scale">
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5 py-lg-7 bg-gradient-primary text-white position-relative overflow-hidden">
            <div class="container position-relative z-index-1">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold mb-4">Ready to Transform Your Service Experience?</h2>
                        <p class="lead mb-5 opacity-75">Join thousands of satisfied users who found the perfect service match</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold hover-lift transition-link">
                                Get Started Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Animated Background Elements -->
            <div>
                <div class="cta-shape-1"></div>
                <div class="cta-shape-2"></div>
            </div>
        </section>
    </div>

    <style>

    </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pageContainer = document.getElementById('page-container');

        window.addEventListener('pageshow', function (event) {
        // If the page was loaded from bfcache, remove fade-out
        if (event.persisted) {
            pageContainer.classList.remove('fade-out');
        }
    });
        // Fade-in on load (optional if using CSS fade-in)
        pageContainer.classList.add('page-fade');

        // Intersection Observer for scroll-in animations
        const animateOnScroll = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target); // Only animate once
                }
            });
        }, { threshold: 0.1 });

        // Select elements to animate
        document.querySelectorAll('.row.align-items-center, .feature-card').forEach(el => {
            el.classList.add('will-animate'); // initial state via CSS
            animateOnScroll.observe(el);
        });

        // Smooth page transition on link click
        const transitionLinks = document.querySelectorAll('.transition-link');
        transitionLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                if (this.href && this.href !== '#' && !this.hasAttribute('data-bs-toggle')) {
                    e.preventDefault();
                    const destination = this.href;

                    pageContainer.classList.add('fade-out');

                    setTimeout(() => {
                        window.location.href = destination;
                    }, 300);
                }
            });
        });
    });
    </script>


</x-layout>
