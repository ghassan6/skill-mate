<footer class="bg-dark text-light pt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Logo Column -->
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <a href="{{ route('home') }}" class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/main/logo.svg') }}" alt="SkillMate Logo" class="img-fluid" style="max-height: 80px;">
                </a>
            </div>

            <!-- About Column -->
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <h5 class="text-uppercase fw-bold mb-4">About Us</h5>
                <p class="small">
                    Connecting talented freelancers with clients worldwide through our seamless platform.
                </p>
                <div class="footer-contact">
                    <p class="small mb-2"><i class="fas fa-envelope me-2 text-primary"></i> contact@skillmate.com</p>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Explore</h5>
                <ul class="list-unstyled footer-links small">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('categories.index') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Services
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support Column -->
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Support</h5>
                <ul class="list-unstyled footer-links small">
                    <li class="mb-2">
                        <a href="{{ route('contact.index') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Contact
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="text-light text-decoration-none hover-primary">
                            <i class="fas fa-angle-right me-2 text-primary"></i> Terms
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter Column -->
            {{-- <div class="col-lg-2 col-md-4 col-6 mb-4">
                <h5 class="text-uppercase fw-bold mb-4">Stay Updated</h5>
                <p class="small">Subscribe for updates and offers</p>
                <form class="newsletter-form">
                    <div class="input-group input-group-sm mb-3">
                        <input type="email" class="form-control bg-transparent text-light border-secondary"
                               placeholder="Your Email" aria-label="Your Email">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-top border-secondary py-3" style="color: white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <small class="text-light ">
                        &copy; <span id="current-year"></span> SkillMate. All Rights Reserved.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-light">
                        Made with <i class="fas fa-heart text-danger"></i> by SkillMate Team
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg back-to-top rounded-circle">
        <i class="fas fa-arrow-up"></i>
    </a>
</footer>


<script>
    // Auto-update copyright year
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Back to top button
    window.addEventListener('scroll', function() {
        var backToTop = document.querySelector('.back-to-top');
        if (window.pageYOffset > 300) {
            backToTop.style.display = 'flex';
        } else {
            backToTop.style.display = 'none';
        }
    });

    document.querySelector('.back-to-top').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
</script>
