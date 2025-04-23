@props(['service' , 'hasAccepted', 'acceptedInquiryId'])
<!-- Owner Card -->
<script src="{{asset('js/service-managing.js')}}"></script>
<div class="card border-0 shadow-sm sticky-top">
    <div class="card-header bg-primary text-white py-3">
        <h4 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i> Service Provider</h4>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <!-- User Image -->
            <div class="flex-shrink-0 me-3">
                @if($service->user->image)
                    <img src="{{ asset(str_contains($service->user->image, 'profile') ? 'storage/' . $service->user->image : $service->user->image) }}"
                            alt="User Profile"
                            class="rounded-circle border border-3 border-warning"
                            style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center"
                            style="width: 80px; height: 80px; background-color: #1E60AA;">
                        <span class="text-white fs-4 fw-bold">{{ substr($service->user->username, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <!-- User Info -->
            <div>
                <a href="{{route('users.show' , $service->user->id)}}" class="text-decoration-none">

                    <h5 class="mb-1 fw-bold">
                        {{ Str::ucfirst($service->user->first_name) }} {{ Str::ucfirst($service->user->last_name) }}
                    </h5>
                </a>
                <small class="text-muted">
                    <i class="fas fa-star text-warning"></i> {{ number_format($service->user->averageRating(), 2) }}

                </small>
            </div>
        </div>

        <!-- contact Buttons -->
        <div class="d-grid gap-2 mt-3">
            @if(Auth::check() && $service->user->id != Auth::id())
                @php
                    $existingInquiry = $service->inquiries()
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->first();
                @endphp

                @if($existingInquiry)
                    @if($existingInquiry->status === 'pending')
                        <button class="btn btn-secondary btn-lg px-4 py-2 fw-bold" disabled>
                            <i class="fas fa-clock me-2"></i> Request Pending
                        </button>
                        @elseif($existingInquiry->status === 'accepted' )
                        <div class="contact-details">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-phone me-3 fs-4 text-success"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Phone Number</h6>
                                    <a href="tel:{{ $service->user->phone_number }}" class="text-decoration-none">
                                        {{ $service->user->phone_number }}
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope me-3 fs-4 text-primary"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Email Address</h6>
                                    <a href="mailto:{{ $service->user->email }}" class="text-decoration-none">
                                        {{ $service->user->email }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @elseif($existingInquiry->status === 'rejected')
                        <div class="alert alert-warning border-warning border-2  fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading mb-2">Request Declined</h5>
                                    <p class="mb-3">The service provider has declined your previous request. Consider adjusting your preferred time or message.</p>

                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning btn-lg px-4 py-2 fw-bold contact-btn" href="{{route(Auth::check() ? 'home' : 'login')}}"
                                        data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                                            <i class="fas fa-paper-plane me-2"></i> Send New Inquiry
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($existingInquiry->status === 'completed')
                        <div class="alert alert-success border-success border-2  fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-exclamation-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading mb-2">Service completed</h5>
                                    <p class="mb-3">The service has already been completed</p>

                                    <div class="d-flex gap-2">
                                        <a class="btn btn-warning btn-lg px-4 py-2 fw-bold contact-btn" href="{{route(Auth::check() ? 'home' : 'login')}}"
                                        data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                                            <i class="fas fa-paper-plane me-2"></i> Send Another Inquiry
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <a class="btn btn-warning btn-lg px-4 py-2 fw-bold contact-btn" href="{{route(Auth::check() ? 'home' : 'login')}}"
                    data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                        <i class="fas fa-paper-plane me-2"></i> Request Contact
                    </a>
                @endif

            @elseif(!Auth::check())
                <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 py-2 fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Contact
                </a>
                {{-- for the owner (manage, managing , edit, propmote) --}}
            @else
                <a href="{{ route('services.edit', $service) }}" class="btn btn-primary btn-lg px-4 py-2 fw-bold">
                    <i class="fas fa-gear me-2"></i> Manage
                </a>
                <button class="btn btn-warning btn-lg px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#promoteModal" {{$service->is_featured ? 'disabled' : ''}}>
                    <i class="fas fa-bullhorn me-2"></i> {{$service->is_featured ? 'This service is alrady promoted' : 'Promote This Service'}}
                </button>
                @if($service->status == 'active')
                    <button class="btn btn-danger btn-lg px-4 py-2 fw-bold" onclick="toggleActivity(`{{ $service->slug   }}`, `{{$service->status}}`)">
                        <i class="fas fa-pause me-2"></i> Deactivate This service
                    </button>
                @elseif($service->status == 'inactive')
                    <button  class="btn btn-success btn-lg px-4 py-2 fw-bold" id="activate-btn" onclick="toggleActivity(`{{ $service->slug   }}`, `{{$service->status}}`)">
                        <i class="fas fa-play me-2"></i> Activate This service
                    </button>
                @endif
            @endif

            <!-- Mark as Completed Button (only shows for accepted inquiries) -->
            @if($hasAccepted)
            <div class="card border-0 shadow-sm mt-0">
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
        </div>
    </div>
</div>

{{-- modal for inquiry --}}
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="inquiryModalLabel">
                    <i class="fas fa-envelope me-2" style="color: #fff"></i> Contact {{ $service->user->username }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="inquiryForm" action="{{ route('inquiries.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <!-- Message Field -->
                    <div class="mb-4">
                        <label for="message" class="form-label fw-bold">Your Message</label>
                        <textarea class="form-control  @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                                  placeholder="Hi {{ $service->user->first_name }}, I'm interested in your '{{ $service->title }}' service. Please provide more details about..."></textarea>
                        @error('message')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Quick Interest Buttons -->
                    <div class="d-flex gap-2 mb-4">
                        <button type="button" class="btn btn-outline-primary btn-sm quick-message" data-template="I'm interested in this service">
                            I'm Interested
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm quick-message" data-template="Can we discuss pricing and timeline?">
                            Discuss Pricing
                        </button>
                    </div>

                    <!-- Preferred Date and Time Selection -->
                    <div class="mb-4">
                        <label for="preferred_datetime" class="form-label fw-bold">Preferred Date & Time</label>
                        <input type="text" class="form-control flatpickr-datetime" id="preferred_datetime" name="preferred_datetime"
                               placeholder="Select date and time" autocomplete="off">
                    </div>

                    <!-- Estimated Hours Field -->
                    <div class="mb-4">
                        <label for="estimated_hours" class="form-label fw-bold">Estimated Hours</label>
                        <input type="number" class="form-control" id="estimated_hours" name="estimated_hours"
                               placeholder="Enter estimated hours for a single day" min="1">
                    </div>

                    <!-- Terms Agreement -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                        <label class="form-check-label small" for="agreeTerms">
                            I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-primary">Terms of Service</a> and understand my contact info may be shared upon acceptance.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold contact-btns">
                            <i class="fas fa-paper-plane me-2"></i> Send Inquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="promoteModal" tabindex="-1" aria-labelledby="promoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="promoteModalLabel">
                    <i class="fas fa-bullhorn me-2"></i> Promote Your Service
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Boost your service visibility by featuring it at the top of search results. Select a promotion period:</p>

                <div class="row g-3">
                    <!-- 1 Day Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-warning">
                            <div class="card-body text-center">
                                <h5 class="card-title">1 Day</h5>
                                <h3 class="text-warning">2 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> Top placement</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Featured badge</li>
                                    <li><i class="fas fa-check text-success me-2"></i> 24 hours</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-warning w-100" onclick="selectPromotion(1, 2)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 1 Week Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-warning bg-warning bg-opacity-10">
                            <div class="card-body text-center">
                                <h5 class="card-title">1 Week</h5>
                                <h3 class="text-warning">10 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> Top placement</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Featured badge</li>
                                    <li><i class="fas fa-check text-success me-2"></i> 7 days</li>
                                    <li class="text-warning fw-bold"><i class="fas fa-star me-2"></i>Best value</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-warning w-100" onclick="selectPromotion(7, 10)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 1 Month Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-warning">
                            <div class="card-body text-center">
                                <h5 class="card-title">1 Month</h5>
                                <h3 class="text-warning">50 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> Top placement</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Featured badge</li>
                                    <li><i class="fas fa-check text-success me-2"></i> 30 days</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-warning w-100" onclick="selectPromotion(30, 50)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="promotionForm"  action="{{ route('services.promote.payment', $service->slug) }}">
                    @csrf
                    <input type="hidden" name="days" id="promotionDays">
                    <input type="hidden" name="amount" id="promotionAmount">
                    <button type="submit" class="btn btn-success" id="proceedToPayment" disabled>
                        <i class="fas fa-credit-card me-2"></i> Proceed to Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
