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
                <h5 class="mb-1 fw-bold">
                    {{ Str::ucfirst($service->user->first_name) }} {{ Str::ucfirst($service->user->last_name) }}
                </h5>
                <small class="text-muted">
                    <i class="fas fa-star text-warning"></i> {{$service->user->rating}}
                </small>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                <i class="fas fa-envelope me-2"></i>
                @if(Auth::check())
                    <span>{{ $service->user->email }}</span>
                @else
                    <span>login</span>
                @endif
            </div>
            @if($service->user->phone_number)
            <div class="d-flex align-items-center p-2 bg-light rounded">
                <i class="fas fa-phone me-2"></i>
                @if(Auth::check())
                    <span>{{ $service->user->phone_number }}</span>
                @else
                    <span>{{ $service->user->phone_number }}</span>
                @endif
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <button class="btn btn-outline-primary">
                <i class="fas fa-comment me-2"></i> Send Message
            </button>
        </div>
    </div>
</div>
