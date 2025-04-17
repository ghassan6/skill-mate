<x-layout>
    <x-slot:title>My Notifications</x-slot>
    <x-user-sidebar>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">
                            <i class="fas fa-bell text-primary me-2"></i> My Notifications
                        </h1>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-2"></i> {{ request('filter') ? Str::ucfirst(request('filter')) : "All"}}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?filter=all">All Notifications</a></li>
                                <li><a class="dropdown-item" href="?filter=unread">Unread Only</a></li>
                                <li><a class="dropdown-item" href="?filter=responses">Responses</a></li>
                            </ul>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Notification List -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            @if($notifications->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-bell-slash text-muted fa-3x mb-3"></i>
                                    <h4 class="text-muted">No notifications yet</h4>
                                    <p class="text-muted">When you receive notifications, they'll appear here</p>
                                </div>
                            @else
                                <div class="list-group list-group-flush">
                                    <!-- Inside your notification loop -->
@foreach($notifications as $notification)
<div class="list-group-item border-0 py-3 px-4 {{ $notification->unread() ? 'unread-notification' : '' }}">
    <div class="d-flex align-items-start">
        <!-- Notification Icon - Dynamic based on type -->
        <div class="flex-shrink-0 me-3">
            @if(isset($notification->data['response']))
                <!-- Response Notification Icon -->
                <div class="bg-{{ $notification->data['response'] === 'accept' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $notification->data['response'] === 'accept' ? 'success' : 'danger' }} rounded-circle p-3">
                    <i class="fas fa-{{ $notification->data['response'] === 'accept' ? 'check-circle' : 'times-circle' }} fa-lg"></i>
                </div>
            @elseif(isset($notification->data['status']) && $notification->data['status'] === 'completed')
                <!-- Completion Notification Icon -->
                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3">
                    <i class="fas fa-check-double fa-lg"></i>
                </div>
            @else
                <!-- Default Notification Icon -->
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                    <i class="fas fa-envelope fa-lg"></i>
                </div>
            @endif
        </div>

        <!-- Notification Content -->
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h6 class="fw-bold mb-0">
                    @if(isset($notification->data['response']))
                        <!-- Response Notification Title -->
                        <span class="text-{{ $notification->data['response'] === 'accept' ? 'success' : 'danger' }}">
                            Inquiry {{ $notification->data['response'] === 'accept' ? 'Accepted' : 'Rejected' }}
                        </span>
                    @elseif(isset($notification->data['status']) && $notification->data['status'] === 'completed')
                        <!-- Completion Notification Title -->
                        <span class="text-info">
                            Service Completed
                        </span>
                    @else
                        <!-- Default Notification Title -->
                        <span class="text-dark">
                            New Notification
                        </span>
                    @endif
                </h6>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </div>

            <!-- Notification Message -->
            <p class="mb-2">
                @if(isset($notification->data['response']))
                    <span class="text-{{ $notification->data['response'] === 'accept' ? 'success' : 'danger' }}">
                        <i class="fas fa-{{ $notification->data['response'] === 'accept' ? 'check' : 'times' }} me-1"></i>
                        {{ $notification->data['message'] }} for <span class="fw-bold">{{$notification->data['service_title']}}</span>
                    </span>
                @elseif(isset($notification->data['status']) && $notification->data['status'] === 'completed')
                    <span class="text-info">
                        <i class="fas fa-check-double me-1"></i>
                        {{ $notification->data['message'] }}: <span class="fw-bold">{{$notification->data['service_title']}}</span>
                    </span>
                @else
                    {{ $notification->data['message'] ?? 'No message content' }}
                @endif
            </p>

            <!-- Action Buttons -->
            @if($notification->unread())
                <div class="d-flex gap-2 mt-3">
                    <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-check-circle me-1"></i> Mark as Read
                        </button>
                    </form>

                    <!-- View Service Button for both response and completion notifications -->
                    @if(isset($notification->data['inquiry_id']))
                        @php
                            $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                            $service = $inquiry ? $inquiry->service : null;
                        @endphp
                        @if($service)
                            <a href="{{ route('services.show', $service->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> View Service
                            </a>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        <!-- Unread Indicator -->
        @if($notification->unread())
            <div class="flex-shrink-0 ms-3">
                <span class="badge bg-danger rounded-circle" style="width: 10px; height: 10px;"></span>
            </div>
        @endif
    </div>
</div>
@endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="d-flex justify-content-between mt-3">
                        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-check-circle me-2"></i> Mark All as Read
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-user-sidebar>
</x-layout>


