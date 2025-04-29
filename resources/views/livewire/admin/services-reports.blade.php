<div class="admin-reports-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h2><i class="fas fa-flag me-2"></i> Service Reports Management</h2>
        <div class="admin-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="divider">/</span>
            <span class="active">Service Reports</span>
        </div>
    </div>

    <!-- Reports Card -->
    <div class="admin-card">
        <!-- Card Header with Filters -->
        <div class="card-header">
            <div class="report-filters">
                <div class="filter-group">
                    <label for="reportStatus">Status:</label>
                    <select id="reportStatus" class="form-select" wire:change="setStatus(event.target.value)">
                        <option value="all">All Reports</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="dismissed">Dismissed</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="reportType">Report Type:</label>
                    <select id="reportType" class="form-select" wire:change='setType(event.target.value)'>
                        <option value="all">All Types</option>
                        <option value="spam">Spam</option>
                        <option value="fraud">Fraud</option>
                        <option value="inappropriate">Inappropriate</option>
                        <option value="duplicate">Duplicate</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="dateRange">Date Range:</label>
                    <select id="dateRange" class="form-select" wire:change='setDate(event.target.value)'>
                        <option value="all">All Time</option>
                        <option value="1">Today</option>
                        <option value="7">This Week</option>
                        <option value="30">This Month</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Report Details</th>
                        <th>Reported Service</th>
                        <th>Reporter</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td>
                            <div class="report-details">
                                <div class="report-title">
                                    <strong>{{ ucfirst($report->reason) }} Report</strong>
                                </div>
                                <div class="report-description">{{ Str::limit($report->description, 80) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="service-info">
                                <div class="service-name">{{ $report->service->title ?? 'Deleted Service' }}</div>
                                <div class="service-owner text-muted small">
                                    by {{ $report->service->user->username ?? 'Unknown' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <img src="{{ asset(Str::contains($report->reporter->image , 'user-profile') ? 'storage/' . $report->reporter->image : $report->reporter->image) }}"
                                         alt="{{ $report->reporter->username }}" class="avatar-sm">
                                </div>
                                <div class="user-details">
                                    <span class="username">{{ $report->reporter->username }}</span>
                                    <span class="user-email text-muted small">{{ $report->reporter->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $report->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="badge status-badge bg-{{ $report->status == 'pending' ? 'warning' : ($report->status == 'resolved' ? 'success' : ($report->status == 'dismissed' ? 'secondary' : 'info')) }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <button class="btn btn-sm btn-outline-primary view-report"
                                        data-report-id="{{ $report->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target='#reportDetailsModal-{{$report->id}}'
                                        data-bs-title="View Details"
                                        title='View'
                                        >
                                    <i class="fas fa-eye"></i>
                                </button>

                                @if($report->status == 'pending' || $report->status == 'dismissed')
                                    <button class="btn btn-sm btn-outline-success resolve-report"
                                            data-report-id="{{ $report->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Mark as Resolved"
                                            onclick="reportResolve({{$report->id}}, 'resolve')">
                                        <i class="fas fa-check"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-secondary dismiss-report"
                                            data-report-id="{{ $report->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Dismiss Report"
                                            onclick="reportResolve({{$report->id}}, 'dismiss')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @if($report->service->status == 'active')
                                        <button class="btn btn-sm btn-outline-warning deactivate-service"
                                                data-service-id="{{ $report->service_id }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Deactivate Service"
                                                onclick="deactivateService(`{{$report->service->slug}}`)">
                                            <i class="fas fa-pause"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-warning deactivate-service"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Service deacivated"
                                            onclick="showError('The service already Inactive')">
                                        <i class="fas fa-pause"></i>
                                        </button>
                                    @endif
                                    @if(is_null($report->reportedUser->banned_at))
                                        <button class="btn btn-sm btn-outline-danger message-reporter"
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Ban user"
                                                onclick="banUser({{$report->reportedUser->id}})">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger message-reporter"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Ban user"
                                            onclick="showError('The User already Banned')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                            <!-- Report Details Modal -->
                            <div class="modal fade" id="reportDetailsModal-{{$report->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="d-flex align-items-center">
                                                <div class="report-icon me-3">
                                                    <i class="fas fa-flag fa-2x text-danger"></i>
                                                </div>
                                                <div>
                                                    <h5 class="modal-title mb-0">Report #{{$report->id}}</h5>
                                                    <div class="text-muted small">Service Report Details</div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Left Column - Report Info -->
                                                <div class="col-md-6">
                                                    <div class="report-card mb-4">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Report Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Reason:</span>
                                                                <span class="detail-value badge bg-danger">{{ucfirst($report->reason)}}</span>
                                                            </div>

                                                            <div class="detail-item">
                                                                <span class="detail-label">Status:</span>
                                                                <span class="detail-value badge bg-{{$report->status == 'pending' ? 'warning' : ($report->status == 'resolved' ? 'success' : 'secondary')}}">
                                                                    {{ucfirst($report->status)}}
                                                                </span>
                                                            </div>

                                                            <div class="detail-item">
                                                                <span class="detail-label">Reported On:</span>
                                                                <span class="detail-value">{{$report->created_at->format('M d, Y \a\t h:i A')}}</span>
                                                            </div>

                                                            @if($report->is_urgent)
                                                            <div class="detail-item">
                                                                <span class="detail-label">Priority:</span>
                                                                <span class="detail-value badge bg-danger">URGENT</span>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="report-card">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0"><i class="fas fa-align-left me-2"></i>Details</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            @if($report->details)
                                                                <div class="report-description p-3 bg-light rounded">
                                                                    {{$report->details}}
                                                                </div>
                                                            @else
                                                                <div class="text-muted">No additional details provided</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Column - Service & Reporter Info -->
                                                <div class="col-md-6">
                                                    <div class="report-card mb-4">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Reported Service</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            @if($report->service)
                                                                <div class="service-info">
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <div class="service-image me-3">

                                                                                <img src="{{ Str::contains($report->service->images->first(), 'service-images') ? asset('storage/' . $report->service->images->first()->image) : asset('images/services/service-default.png') }}" alt="{{$report->service->title}}" class="img-thumbnail" width="60">


                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">{{$report->service->title}}</h6>
                                                                            <div class="text-muted small">by {{$report->service->user->username}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="service-meta">
                                                                        <span class="badge bg-light text-dark me-2">
                                                                            <i class="fas fa-tag me-1"></i> {{$report->service->category->name ?? 'N/A'}}
                                                                        </span>
                                                                        <span class="badge bg-light text-dark">
                                                                            <i class="fas fa-dollar-sign me-1"></i> {{number_format($report->service->hourly_rate, 2)}}/hr
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="text-danger">
                                                                    <i class="fas fa-exclamation-triangle me-2"></i> Service has been deleted
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="report-card">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Reporter Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="reporter-info">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div class="reporter-avatar me-3">
                                                                        @if($report->reporter->image)
                                                                            <img src="{{ $report->reporter->image ? asset(str_contains($report->reporter->image, 'profile') ? 'storage/'.$report->reporter->image : $report->reporter->image) : asset('images/main/defaultUser.jpg') }}" alt="{{$report->reporter->username}}" class="rounded-circle" width="50">
                                                                        @else
                                                                            <img src="https://ui-avatars.com/api/?name={{urlencode($report->reporter->username)}}&background=random" alt="{{$report->reporter->username}}" class="rounded-circle" width="50">
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{$report->reporter->username}}</h6>
                                                                        <div class="text-muted small">{{$report->reporter->email}}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="reporter-meta">
                                                                    <div class="meta-item">
                                                                        <span class="meta-label">Member Since:</span>
                                                                        <span class="meta-value">{{$report->reporter->created_at->format('M Y')}}</span>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <span class="meta-label">Reports Submitted:</span>
                                                                        <span class="meta-value">{{$report->reporter->reports->count()}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-2"></i> Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
            <div>
                {{ $reports->links() }}
            </div>
    </div>



</div>



