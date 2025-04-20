<x-layout>
    <x-slot:title>{{auth()->user()->username}} Inquires Requests</x-slot>
    <script src="{{asset('js/inquireiesRequest.js')}}" defer></script>
    <x-user-sidebar>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">
                            <i class="fas fa-bell text-primary me-2"></i> My Inquires Requests
                        </h1>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                    <!-- Notification List -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            @if($notifications->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-bell-slash text-muted fa-3x mb-3"></i>
                                    <h4 class="text-muted">No Requests yet</h4>
                                    <p class="text-muted">When you receive requests, they'll appear here</p>
                                </div>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($notifications as $notification)
                                        @php
                                            $inquiryId  = $notification->data['inquiry_id'];
                                            $inquiry    = \App\Models\Inquiry::find($inquiryId);
                                            $hasConflict = $conflictFlags[$inquiryId] ?? false;
                                        @endphp
                                        <div class="list-group-item border-0 py-3 px-4 {{ $notification->unread() ? 'unread-notification' : '' }}">
                                            <div class="d-flex align-items-start">
                                                <!-- Notification Icon - Dynamic based on type -->
                                                <div class="flex-shrink-0 me-3">
                                                        <!-- Inquiry Notification Icon -->
                                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                                                            <i class="fas fa-envelope fa-lg"></i>
                                                        </div>
                                                </div>

                                                <!-- Notification Content -->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="fw-bold mb-0">
                                                                <!-- Inquiry Notification Title -->
                                                                <a href="{{ $notification->data['inquiry_id'] ? route('inquiries.show', $notification->data['inquiry_id']) : '#' }}"
                                                                   class="text-decoration-none text-dark">
                                                                    New Inquiry: {{ $notification->data['service_title'] }}
                                                                </a>
                                                        </h6>
                                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>

                                                    <!-- Notification Message -->
                                                    <p class="mb-2">
                                                            {{ $notification->data['message'] }}
                                                    </p>

                                                    <!-- Preferred Date/Time (for inquiries) -->
                                                    @if(isset($notification->data['preferred_datetime']))
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                            <small class="text-muted">
                                                                Preferred: {{ \Carbon\Carbon::parse($notification->data['preferred_datetime'])->format('M j, Y g:i A') }}
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <strong>
                                                                Estimated Time: {{$notification->data['estimated_hours']}} hours
                                                            </strong>

                                                        </div>
                                                    @endif

                                                    <!-- Status Badge (for inquiries) -->
                                                    @if(isset($notification->data['inquiry_id']))
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

                                                            @if(isset($notification->data['inquiry_id']))
                                                                @php
                                                                    $inquiry = App\Models\Inquiry::find($notification->data['inquiry_id']);
                                                                @endphp
                                                                @if($hasConflict && $inquiry && $inquiry->status == 'pending')
                                                                <button type="submit" class="btn btn-sm btn-warning text-white conflict-button " data-bs-toggle="modal" data-bs-target="#conflictModal">
                                                                    <i class="fas fa-exclamation me-1"></i> SOLVE CONFLICT
                                                                </button>
                                                                @elseif($inquiry && $inquiry->status == 'pending')
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



        {{-- conflict modal --}}

        <div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0 overflow-hidden">
                    <!-- Animated Gradient Header -->
                    <div class="modal-header position-relative p-4 bg-gradient-animate text-white">
                        <div class="position-absolute w-100 h-100 top-0 start-0 bg-gradient"></div>
                        <div class="position-relative z-index-1 w-100 d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="modal-title fw-bold fs-3 mb-1" id="conflictModalLabel">
                                    <i class="fas fa-calendar-times me-2 fade-in-left"></i>Resolve Booking Conflict
                                </h5>
                                <p class="mb-0 opacity-75 small pulse">Select one booking to accept - others will be automatically declined</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white btn-close-animate" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>

                    <!-- Modal Body with Floating Elements -->
                    <div class="modal-body p-0 position-relative">
                        <!-- Warning Alert with Icon Animation -->
                        <div class="alert alert-warning border-0 rounded-0 mb-0 py-3 px-4 d-flex align-items-center shadow-sm">
                            <div class="icon-animate me-3">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Time Slot Conflict Detected!</h6>
                                <p class="mb-0 small">You can only accept one booking for this time period. Your selection will automatically decline other requests.</p>
                            </div>
                        </div>

                        <!-- Floating Particles Background (CSS-based) -->
                        <div class="particles-container position-absolute w-100 h-100 top-0 start-0"></div>

                        <!-- Main Content -->
                        <div class="conflict-list-container position-relative z-index-1">
                            <form id="conflictForm" method="POST" action="{{ route('inquiries.resolve') }}">
                                @csrf
                                @method('PUT')

                                <!-- Animated Table Container -->
                                <div class="table-responsive-lg">
                                    <table class="table table-hover align-middle mb-0 table-animate">
                                        <thead class="table-dark">
                                            <tr>
                                                <th width="50px" class="ps-4"></th>
                                                <th class="fw-bold">Client</th>
                                                <th class="fw-bold">Date & Time</th>
                                                <th class="fw-bold">Duration</th>
                                                <th class="fw-bold">Request Details</th>
                                                <th class="fw-bold pe-4">Requested</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($notifications as $notification)
                                                @php
                                                    $inquiryId = $notification->data['inquiry_id'];
                                                    $inquiry = \App\Models\Inquiry::find($inquiryId);
                                                    $hasConflict = $conflictFlags[$inquiryId] ?? false;
                                                @endphp
                                                @if($hasConflict)
                                                    <tr class="conflict-row hover-scale" data-inquiry-id="{{ $inquiryId }}">
                                                        <td class="ps-4">
                                                            <div class="form-check form-check-lg @error('accept_id') is-invalid @enderror">
                                                                <input class="form-check-input conflict-radio pulse-on-hover"
                                                                       type="radio"
                                                                       name="accept_id"
                                                                       id="inquiry_{{ $inquiryId }}"
                                                                       value="{{ $inquiryId }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if($inquiry->user->image)
                                                                    <div class="avatar-container me-3">
                                                                        <img src="{{ asset(str_contains($inquiry->user->image, 'profile') ? 'storage/'.$inquiry->user->image : $inquiry->user->image) }}"
                                                                             class=" avatar-img shadow-sm" alt="{{ $inquiry->user->name }}">
                                                                    </div>
                                                                @else
                                                                    <div class="avatar-placeholder rounded-circle bg-gradient-secondary shadow-sm me-3">
                                                                        <span>{{ substr($inquiry->user->name, 0, 1) }}</span>
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <div class="fw-bold text-dark">{{ $inquiry->user->username }}</div>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="rating-stars small">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                <i class="fas fa-star {{ $i <= floor($inquiry->user->averageRating()) ? 'text-warning' : 'text-muted' }}"></i>
                                                                            @endfor
                                                                        </div>
                                                                        <small class="ms-1 text-muted">{{ number_format($inquiry->user->averageRating(), 2) }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bold text-primary">
                                                                    {{ \Carbon\Carbon::parse($notification->data['preferred_datetime'])->format('D, M j') }}
                                                                </span>
                                                                <span class="badge bg-primary bg-opacity-10 text-primary mt-1">
                                                                    {{ \Carbon\Carbon::parse($notification->data['preferred_datetime'])->format('g:i A') }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 bg-opacity-15 text-success py-2 px-3 rounded-pill">
                                                                <i class="far fa-clock me-1"></i>
                                                                {{ $notification->data['estimated_hours'] }} hours
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="message-preview" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $notification->data['message'] }}">
                                                                <div class="text-truncate">
                                                                    {{ Str::limit($notification->data['message'], 60) }}
                                                                </div>
                                                                @if(strlen($notification->data['message']) > 60)
                                                                    <a href="#" class="text-primary small read-more">Read more</a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="pe-4">
                                                            <div class="time-indicator" data-time="{{ $inquiry->created_at->toIso8601String() }}">
                                                                <i class="far fa-clock me-1 text-muted"></i>
                                                                <span class="time-text">{{ $inquiry->created_at->diffForHumans() }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Footer with Floating Action Buttons -->
                                <div class="p-4 border-top bg-light bg-opacity-50 position-relative">
                                    <div class="row g-3">
                                        <div class="col-lg-8">
                                            <div class="form-floating floating-label-animate">
                                                <textarea class="form-control border-0 shadow-sm"
                                                          id="conflictMessage"
                                                          name="message"
                                                          placeholder=" "
                                                          style="height: 100px"></textarea>
                                                <label for="conflictMessage">
                                                    <i class="fas fa-pen-fancy me-2"></i>Add a personal note (optional)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 d-flex align-items-end justify-content-end">
                                            <div class="d-flex gap-3 w-100">
                                                <button type="button"
                                                        class="btn btn-outline-danger btn-lg flex-grow-1 shadow-sm hover-scale"
                                                        data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Cancel
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-primary btn-lg flex-grow-1 shadow-sm hover-scale submit-btn">
                                                    <i class="fas fa-check-circle me-2"></i>Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </x-user-sidebar>
</x-layout>
