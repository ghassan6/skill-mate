<x-layout>
    <x-slot:title>{{ $service->title }}</x-slot>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <script src="{{ asset('js/singleService.js') }}" defer></script>

    <div class="container py-4">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="/services">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Service Title -->
                <h1 class="fw-bold mb-3">{{ $service->title }}</h1>

                <!-- Location Badge -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    <span class="text-muted">{{ $service->city->name }}</span>
                    <span class="mx-2 text-muted">•</span>
                    <span class="badge bg-primary">{{ $service->category->name }}</span>
                </div>

                <!-- Image Gallery -->
                <div id="serviceGallery" class="carousel slide mb-4 shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($service->images as $image)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img src="{{ asset($image->image) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $service->title }}">
                            </div>
                        @endforeach
                    </div>
                    <!-- Gallery Counter -->
                    <span class="position-absolute top-0 end-0 p-2 bg-dark text-white rounded" id="carousel-counter">
                        / {{ $service->images->count() }}
                    </span>
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#serviceGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#serviceGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Price Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1 fw-bold" style="color: #1E60AA;">
                                    @if($service->type == 'offer')
                                        {{ $service->hourly_rate }} JOD <small class="text-muted fw-normal">/ hour</small>
                                    @else
                                        {{ $service->min_price }} - {{ $service->max_price }} JOD
                                    @endif
                                </h4>
                                <p class="mb-0 text-muted">
                                    @if($service->type == 'offer')
                                        Hourly Rate
                                    @else
                                        Service Budget
                                    @endif
                                </p>
                            </div>
                            <button class="btn btn-warning btn-lg px-4 py-2 fw-bold" style="background-color: #f39c11; color: white;">
                                <i class="fas fa-paper-plane me-2"></i> Contact Owner
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <section class="mb-5">
                    <h3 class="fw-bold mb-3" style="color: #1E60AA;">Service Details</h3>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <p class="lead">{{ $service->description }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Owner Card -->
                <x-owner-card :service="$service"></x-owner-card>

                <!-- Service Stats Card -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2"></i> Service Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span><i class="fas fa-eye me-2"></i> Views</span>
                            <span class="fw-bold">{{$service->views}}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span><i class="fas fa-calendar-check me-2"></i> Posted</span>
                            <span class="fw-bold">{{ $service->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-sync-alt me-2" style="color: #1E60AA;"></i> Last Updated</span>
                            <span class="fw-bold">{{ $service->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
