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
                                <li><a class="dropdown-item" href="?filter=inquiries">Inquiries</a></li>
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
                                                    @else
                                                        <!-- Inquiry Notification Icon -->
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
                                                            @else
                                                                <!-- Inquiry Notification Title -->
                                                                <a href="{{ $notification->data['inquiry_id'] ? route('inquiries.show', $notification->data['inquiry_id']) : '#' }}"
                                                                   class="text-decoration-none text-dark">
                                                                    New Inquiry: {{ $notification->data['service_title'] }}
                                                                </a>
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>

                                                    <!-- Notification Message -->
                                                    <p class="mb-2">
                                                        @if(isset($notification->data['response']))
                                                            <span class="text-{{ $notification->data['response'] === 'accept' ? 'success' : 'danger' }}">
                                                                <i class="fas fa-{{ $notification->data['response'] === 'accept' ? 'check' : 'times' }} me-1"></i>
                                                                {{ $notification->data['message'] }}
                                                            </span>
                                                        @else
                                                            {{ $notification->data['message'] }}
                                                        @endif
                                                    </p>

                                                    <!-- Preferred Date/Time (for inquiries) -->
                                                    @if(isset($notification->data['preferred_datetime']) && !isset($notification->data['response']))
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                            <small class="text-muted">
                                                                Preferred: {{ \Carbon\Carbon::parse($notification->data['preferred_datetime'])->format('M j, Y g:i A') }}
                                                            </small>
                                                        </div>
                                                    @endif

                                                    <!-- Status Badge (for inquiries) -->
                                                    @if(isset($notification->data['inquiry_id']) && !isset($notification->data['response']))
                                                        @php
                                                            $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                                                        @endphp
                                                        @if($inquiry)
                                                            <span class="badge
                                                                @if($inquiry->status == 'pending') bg-warning text-dark
                                                                @elseif($inquiry->status == 'accepted') bg-success
                                                                @elseif($inquiry->status == 'rejected') bg-danger
                                                                @else bg-secondary @endif">
                                                                {{ ucfirst($inquiry->status) }}
                                                            </span>
                                                        @endif
                                                    @endif

                                                    <!-- Action Buttons -->
                                                    @if($notification->unread())
                                                        <div class="d-flex gap-2 mt-3">
                                                            <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                                    <i class="fas fa-check-circle me-1"></i> Mark as Read
                                                                </button>
                                                            </form>

                                                            @if(isset($notification->data['inquiry_id']) && !isset($notification->data['response']))
                                                                @php
                                                                    $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                                                                @endphp
                                                                @if($inquiry && $inquiry->status == 'pending')
                                                                    <!-- Accept/Reject Buttons (only for pending inquiries) -->
                                                                    <form method="POST" action="{{ route('inquiries.update', $inquiry->id) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="action" value="accept">
                                                                        <button type="submit" class="btn btn-sm btn-success">
                                                                            <i class="fas fa-check me-1"></i> Accept
                                                                        </button>
                                                                    </form>

                                                                    <form method="POST" action="{{ route('inquiries.update', $inquiry->id) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="action" value="reject">
                                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                                            <i class="fas fa-times me-1"></i> Reject
                                                                        </button>
                                                                    </form>
                                                                @endif

                                                            @endif
                                                        </div>
                                                    @endif
                                                        <!-- Add this new button for response notifications -->

                                                    @if(isset($notification->data['response']))
                                                    @php
                                                        $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                                                        $service = $inquiry ? $inquiry->service : null;
                                                    @endphp
                                                        <a href="{{ route('services.show', $service->id ?? '#') }}"
                                                        class="btn btn-sm btn-primary mt-3">
                                                            <i class="fas fa-eye me-1"></i> View Service
                                                        </a>
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


