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
        <div class="d-grid gap-2">
            
            <a class="btn btn-warning btn-lg px-4 py-2 fw-bold contact-btn" href="{{route(Auth::check() ? 'home' : 'login')}}"
            data-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
                <i class="fas fa-paper-plane me-2"></i> Request Contact
            </a>
        </div>
    </div>
</div>


<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="inquiryModalLabel">
                    <i class="fas fa-envelope me-2"></i> Contact {{$service->user->username}}
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
                        <textarea class="form-control" id="message" name="message" rows="5" 
                                  placeholder="Hi {{ $service->user->first_name }}, I'm interested in your '{{ $service->title }}' service. Please provide more details about..."></textarea>
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
                    
                    <!-- Terms Agreement -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required>
                        <label class="form-check-label small" for="agreeTerms">
                            I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-primary">Terms of Service</a> and understand my contact info will be shared upon acceptance.
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold contact-btns"
                        >
                            <i class="fas fa-paper-plane me-2"></i> Send Inquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    // Initialize modal and quick message buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Contact button trigger

    });
</script>
