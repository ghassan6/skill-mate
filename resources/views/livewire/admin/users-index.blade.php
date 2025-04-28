<div class="admin-users-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h2><i class="fas fa-users me-2"></i> User Management</h2>
        <div class="admin-breadcrumb">
            <span>Dashboard</span>
            <span class="divider">/</span>
            <span class="active">Users</span>
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
            <div class="card-actions">
                <a href="{{route('admin.users.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Add User
                </a>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                      <i class="fas fa-filter me-2"></i>
                      Filter: {{ ucfirst($filter) }}
                    </button>

                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item {{ $filter === 'all'    ? 'active' : '' }}"
                           href="#"
                           wire:click.prevent="setFilter('all')">
                          All Users
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item {{ $filter === 'active' ? 'active' : '' }}"
                           href="#"
                           wire:click.prevent="setFilter('active')">
                          Active Users
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item {{ $filter === 'banned' ? 'active' : '' }}"
                           href="#"
                           wire:click.prevent="setFilter('banned')">
                          Banned Users
                        </a>
                      </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{-- <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->username).'&background=random' }}" alt="{{ $user->username }}"> --}}
                                    <img src="{{ asset(Str::contains($user->image, 'user-profile') ? 'storage/' . $user->image : $user->image) }}" alt="{{ $user->username }}">
                                </div>
                                <div class="user-details">
                                    <span class="username">{{ $user->username }}</span>
                                    <span class="user-role">{{ $user->role }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if(is_null($user->banned_at))
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Banned</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#userDetailsModal-{{$user->id}}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-title="View profile">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>

                                @if(is_null($user->banned_at))
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Ban user" onclick="toggle_ban(`{{ $user->id }}`, `{{ $user->banned_at }}`)">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-title="Unban user" onclick="toggle_ban(`{{ $user->id }}`, `{{ $user->banned_at }}`)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger removeBtn" data-bs-toggle="tooltip" data-bs-title="Delete user">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

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
                                    <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-primary" id="detailEditBtn">Edit User</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </div>
            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>




</div>
