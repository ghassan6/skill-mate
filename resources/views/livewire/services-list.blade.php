<div class="container-fluid px-lg-5 py-4">
    <!-- Hero Header -->
    <div class="hero-header bg-gradient-primary rounded-4 p-5 mb-5 text-white">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Find Perfect Services</h1>
                <p class="lead mb-4 opacity-75">Browse thousands of professional services tailored to your needs</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('services.create') }}" class="btn btn-light btn-lg px-4 rounded-pill">
                        <i class="fas fa-plus me-2"></i> Post a Service
                    </a>
                    <a href="{{route('categories.index')}}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                        <i class="fas fa-search me-2"></i> Browse categories
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('images/categories/home-repair.jpg') }}" class="img-fluid" alt="Services Illustration">
            </div>
        </div>
    </div>

    {{-- Fiter section --}}
    <section class="card shadow-sm border-0 rounded-3 mb-5">
        <div class="card-body p-4">
            <form id="filterForm" wire:submit.prevent="filterServices">
                <!-- Search and Filter Button (Stacked) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 py-3"
                                   name="search" placeholder="Search by service name..." value="{{ request('search') }}" wire:model.debounce.500ms="search">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 h-100 py-3">
                            <i class="fas fa-filter me-2"></i> Filter Results
                        </button>
                    </div>
                </div>

                <!-- Filter Row -->
                <div class="row g-3">
                    <!-- Category -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Category</label>
                        <select class="form-select py-3" name="category" wire:model="category">
                            <option value=0 >All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ Str::ucfirst($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Location</label>
                        <select class="form-select py-3" name="city" wire:model="city">
                            <option value=0>All Locations</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                    {{ Str::ucfirst($city->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Price Range</label>
                        <select class="form-select py-3" name="price_range" wire:model="priceRange">
                            <option value="">Any Price</option>
                            <option value="0-10" {{ request('price_range') == '0-10' ? 'selected' : '' }}> 10 JOD Or less</option>
                            <option value="10-15" {{ request('price_range') == '10-15' ? 'selected' : '' }}>10-15 JOD</option>
                            <option value="15-20" {{ request('price_range') == '15-20' ? 'selected' : '' }}>15-20 JOD</option>
                            <option value="20+" {{ request('price_range') == '20+' ? 'selected' : '' }}>20+ JOD</option>
                        </select>
                    </div>

                    <!-- Rating -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Minimum Rating</label>
                        <select class="form-select py-3" name="rating" wire:model="rating">
                            <option value="0">Any Rating</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4+ Stars</option>
                            <option value="3">3+ Stars</option>
                        </select>
                    </div>
                </div>

                <!-- Reset Button -->
                <div class="text-end mt-3">
                    <a href="{{ route('services.index') }}" class="btn btn-sm btn-link text-muted">
                        <i class="fas fa-undo me-1"></i> Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Services Grid -->
    @if($services->isEmpty())
        <div class="card shadow-soft border-0 rounded-4 text-center p-5">
            <div class="card-body py-5">
                <img src="{{ asset('images/empty-services.svg') }}" class="img-fluid mb-4" style="max-height: 200px;" alt="No services found">
                <h3 class="fw-bold mb-3">No services match your search</h3>
                <p class="text-muted mb-4">Try adjusting your filters or explore these popular categories</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @foreach($categories->take(5) as $category)
                        <a href="{{ route('services.index', ['category' => $category->id]) }}"
                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card service-card h-100 border-0 shadow-soft-hover overflow-hidden">

                    <!-- Image with Badges -->
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="{{ Str::contains($service->images->first(), 'service-images') ? asset('storage/' . $service->images->first()->image) : asset('images/services/service-default.png') }}"
                             class="img-fluid w-100 h-100 object-cover" alt="{{ $service->title }}"
                             @if($service->is_featured)
                             <div class="position-absolute end-0 top-0 bg-warning text-dark px-3 py-1 small fw-bold" style="z-index: 999">
                                 <i class="fas fa-crown me-1" ></i> Featured
                             </div>
                             @endif
                             >

                        <!-- Category Badge -->
                        <div class="position-absolute start-0 top-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2">
                                {{ $service->category->name }}
                            </span>
                        </div>

                        <!-- Price Badge -->
                        <div class="position-absolute end-0 bottom-0 m-3">
                            <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm">
                                    {{ number_format($service->hourly_rate) }} JOD/hr
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h3 class="h5 fw-bold mb-1">
                                    <a href="{{ route('services.show', $service) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ Str::limit($service->title, 40) }}
                                    </a>
                                </h3>
                                <div class="d-flex align-items-center text-muted small mb-2 position-relative">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $service->city->name }}

                                    <!-- Favorite Button -->
                                    @if(!Auth::check() || Auth::user()->role != 'admin' && $service->user_id != Auth::id())
                                        <div class="position-absolute end-0 top-0 z-1">
                                            <form action="{{ route('services.save', $service->slug) }}" method="POST">
                                                @csrf
                                                @php
                                                    $isSaved = Auth::check() && auth()->user()->isServiceSaved($service->id);
                                                @endphp

                                                <button type="submit"
                                                    class="btn btn-lg px-3 py-2 save-service-btn"
                                                    data-saved="{{ $isSaved ? '1' : '0' }}"
                                                    title="{{ $isSaved ? 'Remove from saved services' : 'Save this service' }}"
                                                    >

                                                    <i class="{{ $isSaved ? 'fas text-danger' : 'far' }} fa-heart"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <p class="text-muted mb-3">
                            {{ Str::limit($service->description, 100) }}
                        </p>

                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Provider Info -->
                            <div class="d-flex align-items-center">
                                @if($service->user->image)
                                    <img src="{{ asset(str_contains($service->user->image, 'profile') ? 'storage/'.$service->user->image : $service->user->image) }}"
                                         class="rounded-circle me-2" width="32" height="32" alt="{{ $service->user->name }}">
                                @else
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center me-2"
                                         style="width: 32px; height: 32px;">
                                        <span class="small">{{ substr($service->user->username, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold small">{{ $service->user->username }}</div>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning small">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $service->averageRating() ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="text-muted small ms-1">({{ $service->reviewsCount() }})</span>
                                    </div>
                                </div>
                            </div>

                            <!-- View Button -->
                            <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $services->links() }}

        </div>
    @endif
</div>
