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
                    <x-footer-link  href="{{ route('contact.index')}}">Contact</x-footer-link>
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
                    <li><a href="{{route('terms')}}" class="text-light text-decoration-none">Terms of Service</a></li>
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
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>