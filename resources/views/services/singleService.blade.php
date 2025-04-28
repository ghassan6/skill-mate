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
                @if($service->user_id == Auth::id() && $service->status == 'inactive')
                <div class="alert alert-warning border-warning bg-warning bg-opacity-10 mb-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4 text-warning"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Important Notice</h5>
                        <p class="mb-0">This serivice is currently <span class="fw-bold fs-5">Inactive</span> and is Not accessable By others</p>
                    </div>
                </div>

                @endif
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
                                <img src="{{ asset(Str::contains($image->image, 'service-images') ? 'storage/' . $image->image : $image->image) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $service->title }}">
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
                                        {{ $service->hourly_rate }} JOD <small class="text-muted fw-normal">/ hour</small>
                                </h4>
                                <p class="mb-0 text-muted">
                                        Hourly Rate
                                </p>
                            </div>
                            @auth
                            <div class="d-flex gap-2 align-items-center">
                                <!-- Add to Favorites Button -->
                                    @if(Auth::user()->role != 'admin')
                                        @if($service->user_id != Auth::id())
                                            <form action="{{ route('services.save', $service->slug) }}" method="POST" class="d-inline">
                                                @csrf
                                                @php
                                                    $isSaved = Auth::check() && auth()->user()->isServiceSaved($service->id);
                                                @endphp

                                                <button type="submit"
                                                    class="btn btn-lg px-3 py-2 save-service-btn"
                                                    data-saved="{{ $isSaved ? '1' : '0' }}"
                                                    title="{{ $isSaved ? 'Remove from saved services' : 'Save this service' }}"
                                                    >

                                                    <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i>
                                                </button>

                                            </form>

                                            <!-- Report Button -->
                                                <button class="btn btn-lg px-3 py-2 text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reportServiceModal"
                                                    title="Report this service"
                                                    {{$service->canReport(Auth::user()) ? '' : 'disabled'}}>
                                                <i class="fas fa-flag"></i>
                                                <small>{{$service->canReport(Auth::user()) ? '' : 'You already reported this service'}}</small>
                                                </button>
                                        @endif
                                    @endif
                                </div>
                            @endauth
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
                        @auth
                            @if(Auth::user()->role != 'admin')
                                @if($service->user_id !== Auth::id())
                                    @if($service->canReview(Auth::user()))
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                            <i class="fas fa-plus me-1"></i> Add Review
                                        </button>
                                    @elseif(!$service->hasReviewed(Auth::user()))
                                        <button class="btn btn-primary" disabled>
                                            <i class="fas fa-times me-1"></i> You can add a review once the Service is completed
                                        </button>
                                    @endif
                                @endif
                            @endif
                        @endauth
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
                                            <a class="mb-0 fw-bold d-block" href="{{route('users.show', $review->user )}}">

                                                <img src="{{ $review->user->image ? asset(str_contains($review->user->image, 'profile') ? 'storage/'.$review->user->image : $review->user->image) : asset('images/main/defaultUser.jpg') }}"
                                                    class="rounded-circle me-3" width="50" height="50" alt="{{ $review->user->name }}"> </a>
                                                <div class="review-profile">
                                                    <a class="mb-0 fw-bold d-block" href="{{route('users.show', $review->user )}}">
                                                        {{ $review->user->username }}</a>
                                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                    <small>{{$review->updated_at != $review->created_at ? ' Edited' : ''}}</small>
                                                </div>
                                            </div>
                                            <div class="text-warning d-flex flex-column">
                                                <div>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                                                    @endfor

                                                </div>
                                                @if($review->user_id === Auth::id())
                                                    <div class="review-actions d-flex gap-2 mt-2">
                                                        <!-- Edit Button -->
                                                        <button data-review='@json($review)'
                                                                type="button"
                                                                class="edit-review-btn btn btn-sm btn-outline-primary"
                                                                title="Edit review">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Delete Button -->
                                                        <form action="{{route('reviews.destroy', $review)}}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    title="Delete review"
                                                                    onclick="return confirm('Are you sure you want to delete this review?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        {{-- <div class="mt-3">
                            {{ $reviews->links() }}
                        </div> --}}

                    @endif
                </section>

                <!-- Review Modal -->
                @if(Auth::check())
                    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Write a Review</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="reviewForm" action="{{route('reviews.store')}}" data-default-action="{{ route('reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                    <input type="hidden" id="reviewId" name="review_id">
                                    <input type="hidden" id="ratingInput" name="rating" value="0">
                                    <input type="hidden" id="methodField" name="_method" value="POST">

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <div class="star-rating" id="starRating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star star" data-value="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                            <div id="ratingError" class="text-danger small mt-1"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Your Review</label>
                                            <textarea id="comment" name="comment" class="form-control" rows="5"></textarea>
                                            <div id="commentError" class="text-danger small mt-1"></div>
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


                <!-- Report Service Modal -->
                @if(Auth::check())
                    <div class="modal fade" id="reportServiceModal" tabindex="-1" aria-labelledby="reportServiceModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reportServiceModalLabel">Report Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('services.report', $service->slug) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p>You are reporting: <strong>{{ $service->title }}</strong></p>

                                        <div class="mb-3">
                                            <label for="reportReason" class="form-label">Reason for reporting</label>
                                            <select class="form-select" id="reportReason" name="reason" required>
                                                <option value="" selected disabled>Select a reason</option>
                                                <option value="spam">Spam or misleading</option>
                                                <option value="inappropriate">Inappropriate content</option>
                                                <option value="fraud">Fraud or scam</option>
                                                <option value="duplicate">Duplicate service</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="reportDetails" class="form-label">Additional details (optional)</label>
                                            <textarea class="form-control" id="reportDetails" name="details" rows="3" placeholder="Please provide more details about your report..."></textarea>
                                            <div class="form-text text-muted">Max 200 characters</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Report</button>
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
                <x-owner-card :service="$service" :hasAccepted="$hasAccepted" :acceptedInquiryId="$acceptedInquiryId"></x-owner-card>



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
