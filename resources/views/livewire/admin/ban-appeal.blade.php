<div class="admin-users-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h2><i class="fas fa-users me-2"></i> User Management</h2>
        <div class="admin-breadcrumb">
            <span>Dashboard</span>
            <span class="divider">/</span>
            <span class="active">Ban Appeals</span>
        </div>
    </div>

    <!-- Users Card -->
    <div class="admin-card">
        <!-- Card Header with Search and Actions -->
        <div class="card-header">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search users..." class="search-input" wire:model.live="search" id="userSearch">
                <button
                    type="button"
                    wire:click="clearSearch"
                    class="search-clear">

                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Banned at</th>
                        <th>Actions</th>
                        <th>Delete Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                    @php
                        $user = \App\Models\User::where('email' , $contact->email)->first();
                    @endphp
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    @if($user)
                                    <img src="{{ asset(Str::contains($user->image, 'user-profile') ? 'storage/' . $user->image : $user->image) }}" alt="{{ $user->username }}">

                                    @else
                                    <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode($contact->name).'&background=random' }}" alt="{{ $contact->name }}">
                                    @endif
                                </div>
                                <div class="user-details">
                                    <span class="username">{{  $contact->name }}</span>
                                    <span class="user-role">{{ $user->role ?? '' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user ? $user->email : $contact->email}}</td>
                        <td>{{ $user ? $user->created_at->format('M d, Y') : 'N\A' }}</td>
                        <td>
                            @if($user)
                                @if(is_null($user->banned_at))
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">{{$user->banned_at}}</span>
                                @endif

                            @else
                                <span>No Account found for the provided Email</span>
                            @endif

                        </td>
                        <td>
                            <div class="table-actions">
                                @if($user)
                                    @if(!is_null($user->banned_at))
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#userDetailsModal-{{$user->id}}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif

                                    @if(is_null($user->banned_at))
                                        <span>The user Is not banned</span>
                                    @else
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-title="Unban user" onclick="toggle_ban(`{{ $user->id }}`, `{{ $user->banned_at }}`)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                @else
                                    <span>No Account found for the provided Email</span>
                                @endif

                            </div>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="deleteContact(`{{$contact->id}}`)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    @if($user)
                        <div class="modal fade" id="userDetailsModal-{{$user->id}}" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Left Column - User Profile -->
                                            <div class="col-md-4">
                                                <div class="user-profile-card text-center">
                                                    <div class="user-avatar-lg mb-3">
                                                        <img src="{{ asset(Str::contains($user->image, 'user-profile') ? 'storage/' . $user->image : $user->image) }}" src="" class="img-thumbnail rounded-circle" alt="User Avatar">
                                                    </div>
                                                    <h4 class="mb-1"></h4>
                                                    <span class="badge bg-primary" >{{ $user->username }}</span>

                                                    <div class="user-status mt-3">
                                                        <span class="badge {{is_null($user->banned_at) ? '' : 'bg-danger' }}">{{ is_null($user->banned_at) ? 'Active' : 'Banned' }}</span>
                                                    </div>

                                                    <hr>

                                                    <div class="user-meta">
                                                        <p><i class="fas fa-calendar-alt me-2"></i> Joined: {{ $user->created_at->format('M d, Y') }}</p>
                                                        <p><i class="fas fa-clock me-2"></i> Last Updated: {{ $user->updated_at->format('M d, Y') }}</p>
                                                        @if($user->deleted_at)
                                                        <p id="detailDeletedDateContainer-{{ $user->id }}">
                                                            <i class="fas fa-trash me-2"></i> Deleted: {{ $user->deleted_at->format('M d, Y') }}
                                                        </p>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column - User Details -->
                                            <div class="col-md-8">
                                                <div class="user-details-section">
                                                    <h5 class="section-title">Personal Information</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>First Name:</strong> <span >{{$user->first_name}}</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Last Name:</strong> <span >{{$user->last_name}}</span></p>
                                                        </div>
                                                    </div>

                                                    <h5 class="section-title mt-4">Contact Information</h5>
                                                    <p><strong>Email:</strong> <span >{{$user->email}}</span></p>
                                                    <p><strong>Email Verified:</strong> <span >{{ $user->email_verified_at ? 'Yes' : 'No' }}</span></p>
                                                    <p><strong>Phone:</strong> <span >{{ $user->phone_number }}</span></p>
                                                    <p><strong>City:</strong> <span >{{ $user->city->name }}</span></p>

                                                    <h5 class="section-title mt-4">Account Information</h5>
                                                    <p><strong>User ID:</strong> <span> {{$user->id}}</span></p>
                                                    <p><strong>Listing Limit:</strong> <span >{{$user->listing_limit}}</span></p>
                                                    <p><strong>Banned At:</strong> <span >{{$user->banned_at ?? 'Not banned'}}</span></p>

                                                    <h5 class="section-title mt-4">Bio</h5>
                                                    <div class="user-bio p-3 bg-light rounded">
                                                    {{$user->bio ?? " No bio available" }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->

            <div >
                {{ $contacts->links() }}
            </div>

    </div>




</div>
