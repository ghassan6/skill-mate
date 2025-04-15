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
                                        <a href="{{ $notification->data['inquiry_id'] ? route('inquiries.show', $notification->data['inquiry_id']) : '#' }}"
                                        class="list-group-item list-group-item-action border-0 py-3 px-4 {{ $notification->unread() ? 'unread-notification' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <!-- Notification Icon -->
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                                                        <i class="fas fa-envelope fa-lg"></i>
                                                    </div>
                                                </div>

                                                <!-- Notification Content -->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="fw-bold mb-0">
                                                            New Inquiry: {{ $notification->data['service_title'] }}
                                                        </h6>
                                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-1 text-truncate">{{ $notification->data['message'] }}</p>

                                                    <!-- Status Badge -->
                                                    @if(isset($notification->data['inquiry_id']))
                                                        @php
                                                            $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                                                        @endphp
                                                        @if($inquiry)
                                                            <span class="badge
                                                                @if($inquiry->status == 'pending') bg-warning text-dark
                                                                @elseif($inquiry->status == 'accepted') bg-success
                                                                @else bg-secondary @endif">
                                                                {{ ucfirst($inquiry->status) }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>

                                                <!-- Unread Indicator -->
                                                @if($notification->unread())
                                                    <div class="flex-shrink-0 ms-3">
                                                        <span class="badge bg-danger rounded-circle" style="width: 10px; height: 10px;"></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        {{-- @if(auth()->user()->notifications->hasPages())
                        <div class="card-footer bg-white">
                            {{ auth()->user()->notifications->links() }}
                        </div>
                        @endif --}}
                    </div>

                    <!-- Bulk Actions -->
                    <div class="d-flex justify-content-between mt-3">
                        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-check-circle me-2"></i> Mark All as Read
                            </button>
                        </form>
                        {{-- <form method="POST" action="{{ route('notifications.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-2"></i> Clear All
                            </button>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </x-user-sidebar>
</x-layout>
