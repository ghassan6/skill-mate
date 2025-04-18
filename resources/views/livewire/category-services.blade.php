<div>

    <link rel="stylesheet" href="{{ asset('css/category-services.css') }}">

    <div class="category-header py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="text-white fw-bold mb-3">{{ str_contains($category->name , 'Services') ? $category->name : $category->name . ' Services' }}</h1>
                    <p class="text-white-50 lead mb-4">{{ $category->description ?? 'Find professional services in this category' }}</p>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-warning text-dark me-2 px-3 py-2">
                            <i class="fas fa-fire me-1"></i> {{ $services->total() }} Services Available
                        </span>
                        <span class="text-white small">
                            <i class="fas fa-star me-1"></i> {{ number_format($category->services->avg(function($service) {
                                return $service->reviews->avg('rating');
                            }), 1) }} Average Rating
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <img src="{{ asset($category->image) }}" alt="Category Illustration" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            </div>
        </div>
    </div>

    {{-- filter and listing part --}}
    <div class="container py-4">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i> Filters</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="applyFilters">
                            <!-- Search by Name -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Search by Name</h6>
                                <div class="input-group">
                                    <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Service name...">
                                </div>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Price Range</h6>
                                <div class="d-flex">
                                    <div class="input-group me-2">
                                        <span class="input-group-text">Min</span>
                                        <input type="number" wire:model="minPrice" class="form-control" min="0">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Max</span>
                                        <input type="number" wire:model="maxPrice" class="form-control" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Service Type Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Service Type</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedTypes" value="offer" id="type-offer">
                                    <label class="form-check-label" for="type-offer">
                                        Offers (Hourly Rate)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedTypes" value="request" id="type-request">
                                    <label class="form-check-label" for="type-request">
                                        Requests (Budget Price)
                                    </label>
                                </div>
                            </div>

                            <!-- City Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">City</h6>
                                <select class="form-select" wire:model="selectedCityId">
                                    <option value="">All Cities</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Rating Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Minimum Rating</h6>
                                <div class="star-rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" wire:model="selectedRating" value="{{ $i }}" id="rating-{{ $i }}">
                                            <label class="form-check-label" for="rating-{{ $i }}">
                                                @for($j = 1; $j <= $i; $j++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                                @if($i < 5)
                                                    @for($j = 1; $j <= (5 - $i); $j++)
                                                        <i class="fas fa-star text-secondary"></i>
                                                    @endfor
                                                @endif
                                                & Up
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="fas fa-sync-alt me-2"></i> Apply Filters
                            </button>

                            <a href="{{ route('category.services', $category->slug) }}" class="btn btn-outline-secondary w-100 py-2 fw-bold mt-2">
                                <i class="fas fa-times me-2"></i> Clear Filters
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Services Listing -->
            <div class="col-lg-9">
                <!-- Sorting Options -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="text-muted">Showing {{ $services->firstItem() }}-{{ $services->lastItem() }} of {{ $services->total() }} services</span>
                    </div>
                    <div>
                        <select class="form-select form-select-sm" wire:model="sort">
                            <option value="recommended">Sort by: Recommended</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating">Rating: Highest</option>
                            <option value="newest">Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="row">
                    @if($services->count() > 0)
                        @foreach($services as $service)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card service-card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $service->images->first() ? asset($service->images->first()->image) : asset('images/services/service-default.png') }}"
                                            class="card-img-top"
                                            alt="{{ $service->title }}"
                                            style="height: 180px; object-fit: cover;">
                                        <div class="card-badge position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-{{ $service->type == 'offer' ? 'warning text-dark' : 'primary' }}">
                                                {{ $service->type == 'offer' ? 'Hourly Rate' : 'Budget Price' }}
                                            </span>
                                        </div>
                                        <div class="card-views position-absolute bottom-0 start-0 m-2">
                                            <span class="badge bg-dark bg-opacity-75 text-white">
                                                <i class="fas fa-eye me-1"></i> {{ $service->views }}
                                            </span>
                                        </div>
                                    </div>
                                    <h2></h2>

                                    <div class="card-body">
                                        <h5 class="card-title mb-2">
                                            <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none text-dark">{{ Str::limit($service->title, 50) }}</a>
                                        </h5>
                                        <p class="card-text text-muted small mb-3">{{ Str::limit($service->description, 100) }}</p>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <span class="fw-bold" style="color: #1E60AA;">
                                                    @if($service->type == 'offer')
                                                        {{ $service->hourly_rate }} JOD/Hour
                                                    @else
                                                        {{ $service->min_price }} - {{ $service->max_price }} JOD
                                                    @endif
                                                </span>
                                            </div>

                                            @php
                                                $avgRating = $service->reviews->avg('rating');
                                                $fullStars = floor($avgRating);
                                                $halfStar = ($avgRating - $fullStars) >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                            @endphp

                                            <div class="text-warning">
                                                @if($service->reviews->isNotEmpty())
                                                    {{-- full stars display --}}
                                                    @for($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor

                                                    {{-- half star the if to ensure that if exists --}}
                                                    @if($halfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @endif

                                                    {{-- Show empty stars --}}
                                                    @for($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor

                                                    <span class="text-muted small">({{ $service->reviews->count() }})</span>
                                                @else
                                                    No reviews yet.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0 pt-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a class="d-flex align-items-center owner-link" href="{{route('users.show', $service->user_id)}}">
                                                <img src="{{ $service->user->image ? asset(str_contains($service->user->image, 'profile') ? 'storage/' . $service->user->image : $service->user->image) : asset('images/user-placeholder.jpg') }}"
                                                    class="rounded-circle me-2"
                                                    width="30"
                                                    height="30"
                                                    alt="{{ $service->user->username }}">
                                                <span class="small">{{ Str::ucfirst(Str::limit($service->user->username, 12)) }}</span>
                                            </a>
                                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-sm btn-outline-primary py-1 px-3">
                                                View <i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <p class="text-muted fs-4">No Services Found</p>
                    @endif
                </div>

                <!-- Pagination -->
                <nav class="mt-5">
                    {{ $services->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
