<x-layout>
    <x-slot:title>Skill Mate - Find & Offer Services</x-slot>
    <script src="{{asset('js/index.js')}}" defer></script>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Find the perfect service or showcase your skills</h1>
                <p class="hero-subtitle">Connect with skilled professionals or find clients for your services</p>
                <div class="hero-buttons">
                    <a href="{{ route('services.index') }}" class="btn btn-primary btn-lg">Browse Services</a>
                    <a href="{{ route('services.create') }}" class="btn btn-outline-light btn-lg">Offer Service</a>
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </div>

    <!-- Featured Services Section  -->
    <section class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Featured Services</h2>
            <div class="carousel-nav d-flex">
                <button class="btn btn-outline-primary me-2 featured-prev" type="button">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-outline-primary featured-next" type="button">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="position-relative">
            <div id="featuredCarousel" class="carousel slide" data-bs-ride="false" data-bs-wrap="true">
                <div class="carousel-inner">
                    @foreach ($featuredServices->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex === 0) active @endif">
                            <div class="row g-4">
                                @foreach ($chunk as $service)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card h-100 border-0 shadow-sm hover-scale">
                                            <div class="card-img-top overflow-hidden" style="height: 180px;">
                                                <img src="{{ $service->images->first()->image }}"
                                                     class="img-fluid w-100 h-100 object-fit-cover"
                                                     alt="{{ $service->title }}"
                                                     loading="lazy">
                                                <div class="image-overlay"></div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h5 class="card-title mb-0">{{ $service->title }}</h5>
                                                    <span class="badge bg-primary rounded-pill">Featured</span>
                                                </div>
                                                <p class="card-text text-muted small mb-3">{{ Str::limit($service->description, 80) }}</p>
                                            </div>
                                            <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-primary stretched-link">
                                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">How Skill Mate Works</h2>
            <div class="row">
                <!-- For Service Seekers -->
                <div class="col-lg-6">
                    <div class="guide-card seeker-guide">
                        <div class="guide-header">
                            <h3>For Service Seekers</h3>
                            <div class="icon-container">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="guide-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Sign Up</h4>
                                    <p>Create your account in less than a minute</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>Find Services</h4>
                                    <p>Browse our categories or search for specific services</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Contact Providers</h4>
                                    <p>Message service providers directly through our platform</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h4>Get Work Done</h4>
                                    <p>Hire the right professional and get your project completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- For Service Providers -->
                <div class="col-lg-6">
                    <div class="guide-card provider-guide">
                        <div class="guide-header">
                            <h3>For Service Providers</h3>
                            <div class="icon-container">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <div class="guide-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Create Profile</h4>
                                    <p>Set up your professional profile in minutes</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>List Services</h4>
                                    <p>Add the services you offer with details and pricing</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Get Hired</h4>
                                    <p>Receive inquiries from potential clients</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h4>Grow Your Business</h4>
                                    <p>Build your reputation with reviews and ratings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- Categories Section -->
    <section class="categories-section py-5">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-5">
                <h2 class="section-title">Browse by Category</h2>
                <x-index-button url='categories.index' color='primary'>See All Categories</x-index-button>
            </div>

            <div class="row g-4">
                @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('category.services', $category->slug) }}" class="category-card">
                        <div class="category-image" style="background-image: url('{{ asset('images/categories/' . $category->slug . '.jpg') }}');">
                            <div class="category-overlay"></div>
                            <h3 class="category-title">{{ $category->name }}</h3>
                        </div>
                        <div class="category-count">{{ $category->services->count()}} Services</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="cta-section py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="cta-title mb-4">Ready to get started?</h2>
            <p class="cta-subtitle mb-5">Join thousands of professionals and clients finding each other every day</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-3">Sign Up Free</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline-light btn-lg px-4">Browse Services</a>
            </div>
        </div>
    </section>
</x-layout>
