@props(['service'])
<div>

    <h4 class="text-center mb-4">Post Owner</h4>
    <h5 class="owner-name">{{Str::ucfirst($service->user->first_name)}} {{Str::ucfirst($service->user->last_name)}} </h5>
    <div class="d-flex align-items-center p-3 bg-light rounded shadow-sm">
        <!-- User Image -->
        <div class="flex-shrink-0 me-3">
            @if($service->user->image)
                <img src="{{asset(str_contains($service->user->image, 'profile') ? 'storage/' . $service->user->image : $service->user->image)}}" alt="profile-picture""
                     alt="User Profile"
                     class="rounded-circle"
                     style="width: 80px; height: 80px; object-fit: cover;">
            @else
                <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center"
                     style="width: 80px; height: 80px;">
                    <span class="text-white fs-4">{{ substr($service->user->username, 0, 1) }}</span>
                </div>
            @endif
        </div>

        <!-- User Info -->
        <div class="flex-grow-1">
            <h5 class="mb-1 fw-bold">{{ $service->user->username }}</h5>

            <div class="text-muted mb-1">
                <i class="fas fa-envelope me-2"></i>
                {{ $service->user->email }}
            </div>

            @if($service->user->phone_number)
            <div class="text-muted">
                <i class="fas fa-phone me-2"></i>
                {{ $service->user->phone_number}}
            </div>
            @endif
        </div>
    </div>
</div>
