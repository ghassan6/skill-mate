<div class="admin-services-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h2><i class="fas fa-briefcase me-2"></i> Services Management</h2>
        <div class="admin-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="divider">/</span>
            <span class="active">Services</span>
        </div>
    </div>

    <!-- Services Card -->
    <div class="admin-card">
        <!-- Card Header with Search and Actions -->
        <div class="card-header">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="serviceSearch" placeholder="Search services..." class="search-input" wire:model.live='search'>
                <button
                type="button"
                wire:click="clearSearch"
                class="search-clear">

                <i class="fas fa-times"></i>
            </button>
            </div>
            <div class="card-actions">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i> Filter: {{ ucfirst($filter) }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" wire:click='setFilter("all")'>All Services</a></li>
                        <li><a class="dropdown-item " href="#" wire:click='setFilter("active")'>Active Services</a></li>
                        <li><a class="dropdown-item" href="#" wire:click="setFilter('inactive')">Inactive services </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" wire:click="setFilter('featured')">Featured Services</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="table-responsive">
        @if($services->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Average Rating</th>
                        <th>Category</th>
                        <th>Rate</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                    <tr>
                        <td>
                            <div class="service-info">
                                <div class="service-title">{{ $service->title }}</div>
                                <div class="service-owner text-muted">By
                                    <a href="{{route('users.show', $service->user)}}" class="owner-link">
                                        {{$service->user->username}}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="rating-info">
                                <div class="rating-details">
                                    @if($service->reviews->avg('rating') > 0)
                                        <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        <span>{{number_format($service->reviews->avg('rating'), 1)  }}</span>
                                    @else
                                        <i class="fa-solid fa-star"></i>
                                        <span>No reviews</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $service->category->name ?? 'N/A' }}</td>
                        <td>{{ number_format($service->hourly_rate, 2) }} JOD/hr</td>
                        <td>{{ $service->city->name ?? 'N/A' }}</td>
                        <td>
                            @if($service->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($service->status == 'inactive')
                                <span class="badge bg-danger">Inactive</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($service->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($service->is_featured && (!$service->featured_until || $service->featured_until > now()))
                                <span class="badge bg-featured">Featured</span>
                                @if($service->featured_until)
                                    <div class="text-muted small">Until {{ $service->featured_until->format('M d, Y') }}</div>
                                @endif
                            @else
                                <span class="badge bg-secondary">Regular</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($service->status == 'active')
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-title="Deactivate" onclick="toggleStatus(`{{ $service->slug }}`, 'inactive')">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-title="Activate" onclick="toggleStatus(`{{ $service->slug }}`, 'active')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif

                                {{-- <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE') --}}
                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="confirmDelete(`{{$service->slug}}`)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                {{-- </form> --}}

                                <button class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#featureServiceModal"
                                    onclick="featureService({{ $service->id }})"
                                    data-bs-title="Feature">
                                <i class="fas fa-star"></i>
                            </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} entries
            </div>
            <div class="pagination">
                {{ $services->links() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="featureServiceModal" tabindex="-1" aria-labelledby="featureServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureServiceModalLabel">Feature Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="featureServiceForm" method="POST" action="{{route('admin.services.promote')}}">
                        @csrf
                        <input type="hidden" id="featureServiceId" name="service_id">

                        <div class="mb-3">
                            <label for="featureDuration" class="form-label">Feature Duration</label>
                            <select class="form-select" id="featureDuration" name="duration_type">
                                <option value="7">1 Week</option>
                                <option value="14">2 Weeks</option>
                                <option value="30" selected>1 Month</option>
                                <option value="90">3 Months</option>
                                <option value="custom">Custom Date</option>
                                <option value="permanent">Permanent</option>
                            </select>
                        </div>

                        <div class="mb-3" id="customDateContainer" style="display: none;">
                            <label for="featureUntil" class="form-label">Feature Until</label>
                            <input type="text" class="form-control flatpickr-datetime" id="featureUntil" name="feature_until" placeholder="Select end date for featuring" autocomplete="off">
                        </div>

                        {{-- <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notifyUser" name="notify_user" checked>
                            <label class="form-check-label" for="notifyUser">
                                Notify service provider
                            </label>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmFeatureBtn">Confirm Feature</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


