<x-layout>
    <x-slot:title>{{ $service->title }}</x-slot>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <script src="{{ asset('js/singleService.js') }}" defer></script>

    <div class="container py-4">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categories</a></li>
                <li class="breadcrumb-item"><a href="{{route('category.services', $service->category->slug)}}">{{$service->category->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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

                <!-- Price Card , contact and favorite  -->
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
                            <div class="d-flex gap-2">
                                <!-- Add to Favorites Button -->
                                <form action="{{ route('services.save', $service->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                    class="btn btn-lg px-3 py-2 save-service-btn"
                                        data-saved="{{ Auth::check() && auth()->user()->isServiceSaved($service->id) ? '1' : '0' }}"
                                        title="{{ Auth::check() && auth()->user()->isServiceSaved($service->id) ? 'Remove from saved services' : 'Save this service' }}"
                                        style="color: {{ Auth::check() && auth()->user()->isServiceSaved($service->id) ? '#dc3545' : '#6c757d' }};">
                                        <i class="{{ Auth::check() && auth()->user()->isServiceSaved($service->id) ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </form>
                            </div>
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

                <!-- Reviews Section -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold" style="color: #1E60AA;">
            <i class="fas fa-star text-warning me-2"></i> Reviews
            <span class="badge bg-primary">{{ $service->reviews->count() }}</span>
        </h3>

        @if(Auth::check() && $service->canReview(Auth::user()))
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                <i class="fas fa-plus me-1"></i> Add Review
            </button>
        @endif
    </div>

    @if($reviews->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-comment-slash text-muted fa-3x mb-3"></i>
                <h4 class="text-muted">No reviews yet</h4>
                <p class="text-muted">Be the first to review this service</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @foreach($reviews as $review)
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ $review->user->image ? asset(str_contains($review->user->image, 'profile') ? 'storage/'.$review->user->image : $review->user->image) : asset('images/main/defaultUser.jpg') }}"
                                     class="rounded-circle me-3" width="50" height="50" alt="{{ $review->user->name }}">
                                <div>
                                    <a class="mb-0 fw-bold d-block text-decoration-none text-black" href="{{route('users.show', $review->user )}}">
                                        {{ $review->user->username }}</a>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    @endif
</section>

<!-- Review Modal -->
@if(Auth::check())
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea class="form-control" id="comment" name="comment" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Owner Card -->
                <x-owner-card :service="$service"></x-owner-card>

                    <!-- Mark as Completed Button (only shows for accepted inquiries) -->
                @if($hasAccepted)
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body text-center">
                            <form action="{{ route('inquiries.complete', $acceptedInquiryId) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-lg w-100 py-3">
                                    <i class="fas fa-check-circle me-2"></i> Mark as Completed
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

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
