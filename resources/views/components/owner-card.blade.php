@props(['service'])
<!-- Owner Card -->
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
                    <i class="fas fa-star text-warning"></i> {{$service->user->rating}}
                </small>
            </div>
        </div>

        <!-- contact Buttons -->
        <div class="d-grid gap-2 mt-3">
            @if(Auth::check() && $service->user->id !== Auth::id())
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
            @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 py-2 fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Contact
                </a>
            @endif
        </div>
    </div>
</div>


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


