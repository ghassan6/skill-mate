<x-layout>
    <x-slot:title>{{ Str::ucfirst($user->first_name) }}'s Profile</x-slot>
    <link rel="stylesheet" href="{{ asset('css/public-profile.css') }}">
    <div class="container py-4">

        <!-- Profile Header -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="profile-header-bg"></div>
            <div class="card-body px-4 pb-4 pt-0">
                <div class="row align-items-end">
                    <!-- Profile Image -->
                    <div class="col-md-2 text-center mb-3 mb-md-0" style="margin-top: -75px;">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset(str_contains($user->image, 'profile') ? 'storage/' . $user->image : $user->image) }}"
                                 class="rounded-circle img-thumbnail border-4 border-white shadow"
                                 alt="{{ $user->username }}">
                            @if($user->is_verified)
                                <span class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white">
                                    <i class="fas fa-check text-white" style="font-size: 0.8rem;"></i>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="col-md-7 mt-3 fs-4">
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="h3 fw-bold mb-0 me-2">{{ Str::ucfirst($user->first_name) }} {{ Str::ucfirst($user->last_name) }}</h1>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($user->city)
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ $user->city->name }}
                                </span>
                            @endif

                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                Joined {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="col-md-3">
                        <div class="d-flex justify-content-center bg-light rounded-3 p-3">
                            <div class="text-center px-2">
                                <div class="h4 fw-bold mb-1 text-primary">{{ $user->services->count() }}</div>
                                <small class="text-muted">Services</small>
                            </div>

                            {{-- <div class="text-center px-2">
                                <div class="h4 fw-bold mb-1 text-primary">{{ $user->followers_count }}</div>
                                <small class="text-muted">Followers</small>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- About Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="h5 fw-bold mb-0 d-flex align-items-center">
                            <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-2">
                                <i class="fas fa-user fs-6"></i>
                            </span>
                            About
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($user->bio)
                            <p class="text-muted">{{ $user->bio }}</p>
                        @else
                            <p class="text-muted">No bio provided</p>
                        @endif
                    </div>
                </div>

                <!-- Services Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h3 class="h5 fw-bold mb-0 d-flex align-items-center">
                            <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-2">
                                <i class="fas fa-briefcase fs-6"></i>
                            </span>
                            Services ({{ $user->services->count() }})
                        </h3>
                        <a href="{{ route('services.index', ['user' => $user->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if($user->services->count() > 0)
                            <div class="row g-3">
                                @foreach($user->services->take(4) as $service)
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm-hover transition-all">
                                        <div class="position-relative">
                                            <img src="{{ Str::contains($service->images->first(), 'service-images') ? asset('storage/' . $service->images->first()->image) : asset('images/services/service-default.png') }}"
                                                 class="card-img-top"
                                                 alt="{{ $service->title }}">
                                                 @if($service->is_featured)
                                                 <div class="position-absolute end-0 top-0 bg-warning text-dark px-3 py-1 small fw-bold" style="z-index: 999">
                                                     <i class="fas fa-crown me-1" ></i> Featured
                                                 </div>
                                                 @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title mb-2">
                                                <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none text-dark hover-primary">
                                                    {{ Str::limit($service->title, 40) }}
                                                </a>
                                            </h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-primary fw-bold">
                                                        {{ $service->hourly_rate }} <small class="text-muted">JOD/Hour</small>
                                                </span>
                                                @if($service->type == 'offer')
                                                <span class="text-warning small">
                                                    <i class="fas fa-star"></i>
                                                    {{ number_format($service->reviews->avg('rating') ?? 0, 1) }}
                                                    <small class="text-muted">({{ $service->reviews->count() }})</small>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-briefcase text-muted mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="text-muted">No services offered yet</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Statistics -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="h5 fw-bold mb-0 d-flex align-items-center">
                            <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-2">
                                <i class="fas fa-chart-line fs-6"></i>
                            </span>
                            Statistics
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">

                            <!-- Rating -->
                            <li class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 flex-shrink-0">
                                    <i class="fas fa-star fs-6"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Rating</small>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold me-2">{{ number_format($user->averageRating(), 1) }}</span>
                                        <div class="text-warning small">
                                            <i class="fas fa-star text-warning me-1"></i>
                                        </div>
                                        <small class="text-muted ms-2">({{ $user->totalReviews() }} reviews)</small>
                                    </div>
                                </div>
                            </li>

                            <!-- Member Since -->
                            <li class="d-flex align-items-center">
                                <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3 flex-shrink-0">
                                    <i class="fas fa-calendar-alt fs-6"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Member Since</small>
                                    <span class="fw-bold">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Button -->
                @auth
                {{-- <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <button class="btn btn-primary w-100 mb-3 rounded-pill py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-paper-plane me-2"></i> Contact {{ $user->username }}
                        </button>
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.follow', $user->id) }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                                    <i class="fas fa-user{{ auth()->user()->isFollowing($user) ? '-check' : '-plus' }} me-2"></i>
                                    {{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div> --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <button class="btn btn-primary w-100 mb-3 rounded-pill py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-paper-plane me-2"></i> Contact {{ $user->username }}
                        </button>
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign in to contact
                        </a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Contact {{ $user->username }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('conversations.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                        {{-- <div class="mb-3">
                            <label class="form-label fw-bold">Subject</label>
                            <input type="text" name="subject" class="form-control rounded-pill" required>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Message</label>
                            <textarea name="message" rows="5" class="form-control rounded-3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
