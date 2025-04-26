<x-layout>
    <x-slot:title>My Services</x-slot>
    <script src="{{asset('js/service-managing.js')}}" defer></script>
    <x-user-sidebar>
        <div class="container py-4">
            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="h3 mb-2"><i class="fas fa-briefcase me-2 text-primary"></i> My Services</h1>
                    <p class="text-muted mb-0">Manage all your services in one place</p>
                </div>
            </div>
            @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <!-- Stats Cards -->
            <div class="row mb-4 g-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-25 p-3 rounded-circle me-3">
                                    <i class="fas fa-check-circle text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Active Services</h6>
                                    <h3 class="mb-0 text-primary">{{ $activeCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-secondary bg-opacity-10 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-25 p-3 rounded-circle me-3">
                                    <i class="fas fa-pause-circle text-secondary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Inactive Services</h6>
                                    <h3 class="mb-0 text-secondary">{{ $inactiveCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-warning bg-opacity-10 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-25 p-3 rounded-circle me-3">
                                    <i class="fas fa-star text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Featured Services</h6>
                                    <h3 class="mb-0 text-warning">{{ $featuredCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            @if($services->isEmpty())
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-briefcase text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">No services yet</h4>
                        <p class="text-muted mb-4">Start by creating your first service to get discovered</p>
                        <a href="{{ route('services.create') }}" class="btn btn-primary px-4">
                            <i class="fas fa-plus me-2"></i> Create Service
                        </a>
                    </div>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($services as $service)
                    <div class="col">
                        <div class="card service-card h-100 border-0 shadow-sm overflow-hidden">
                            <!-- Featured Ribbon -->
                            @if($service->is_featured)
                            <div class="position-absolute end-0 top-0 bg-warning text-dark px-3 py-1 small fw-bold" style="z-index: 999">
                                <i class="fas fa-crown me-1" ></i> Featured
                            </div>
                            @endif

                            <!-- Service Image -->
                            <div class="service-image-container">
                                <img src="{{ asset(Str::contains($service->images->first()->image, 'service-images') ? 'storage/' . $service->images->first()->image : $service->images->first()->image) }}"
                                     class="card-img-top"
                                     alt="{{ $service->title }}"
                                     style="height: 180px; object-fit: cover;">
                                <div class="service-status-badge {{ $service->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($service->status) }}
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body position-relative">
                                <!-- Category & Location -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $service->category->name }}
                                    </span>
                                    <span class="text-muted small">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ $service->city->name ?? 'Remote' }}
                                    </span>
                                </div>

                                <!-- Title & Description -->
                                <h5 class="card-title mb-2">
                                    <a href="{{ route('services.show', $service->slug) }}" class="text-dark text-decoration-none">
                                        {{ Str::limit($service->title, 40) }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($service->description, 90) }}
                                </p>

                                <!-- Price & Views -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 text-primary">
                                        {{ $service->hourly_rate }} <small class="text-muted">JOD/hr</small>
                                    </h5>
                                    <span class="text-muted small">
                                        <i class="fas fa-eye me-1"></i> {{ $service->views }}
                                    </span>
                                </div>

                                <!-- Featured Time (if applicable) -->
                                @if($service->is_featured && $service->featured_until)
                                <div class="alert alert-warning alert-dismissible fade show py-2 px-3 mb-3 small" role="alert">
                                    <i class="fas fa-clock me-2"></i> Featured until {{ $service->featured_until->format('M d, Y') }}
                                    <button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
                                </div>
                                @endif
                            </div>

                            <!-- Card Footer - Actions -->
                            <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                <div class="d-flex justify-content-between">
                                    <!-- View Button -->
                                    <a href="{{ route('services.show', $service->slug) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>

                                    <!-- Action Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="fas fa-cog me-1"></i> Manage
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <!-- Edit -->
                                            <li>
                                                <a class="dropdown-item" href="{{ route('services.edit', $service->slug) }}">
                                                    <i class="fas fa-edit me-2 text-primary"></i> Edit
                                                </a>
                                            </li>
                                            <!-- Status Toggle -->
                                            <li>
                                                    <button  class="dropdown-item" onclick="toggleActivity(`{{ $service->slug   }}`, `{{$service->status}}`)">
                                                        <i class="fas {{ $service->status == 'active' ? 'fa-pause' : 'fa-play' }} me-2 text-{{ $service->status == 'active' ? 'warning' : 'success' }}"></i>
                                                        {{ $service->status == 'active' ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                            </li>
                                            <!-- Promote -->
                                            <li>
                                                @if(!$service->is_featured)
                                                <a class="dropdown-item" href="{{ route('services.show', $service->slug) }}">
                                                    <i class="fas fa-bullhorn me-2 text-warning"></i>
                                                    Promote
                                                </a>
                                                @endif
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <!-- Delete -->
                                            <li>
                                                    <a href="{{ route('services.edit', $service->slug) }}"
                                                            class="dropdown-item text-danger"
                                                            onclick="delteService(`{{$service->slug}}`)">
                                                        <i class="fas fa-trash me-2"></i> Delete
                                                    </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($services->hasPages())
                <div class="mt-5">
                    {{ $services->links('pagination::bootstrap-5') }}
                </div>
                @endif
            @endif
        </div>

        <style>

        </style>

    </x-user-sidebar>
</x-layout>
