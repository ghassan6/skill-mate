<x-layout>
    <x-slot:title>My Services</x-slot>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <x-user-sidebar>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="fas fa-briefcase me-2"></i> My Services
            </h3>
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add New Service
            </a>
        </div>

        <!-- Services List -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>
                    {{ auth()->user()->services()->count() }} Services
                </h5>
            </div>

            <div class="card-body p-0">
                @if($services->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">No services yet</h4>
                        <p class="text-muted">Create your first service to start getting inquiries</p>
                        <a href="{{ route('services.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i> Create Service
                        </a>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($services as $service)
                        <div class="list-group-item border-0 py-3 px-4 my-2" style="background-color: #f8f9fa">
                            <div class="row align-items-center">
                                <!-- Service Image -->
                                <div class="col-md-2">
                                    <img src="{{ $service->images->first() ? asset($service->images->first()->image) : asset('images/services/service-default.png') }}"
                                         class="img-fluid rounded"
                                         style="height: 100px; width: 100%; object-fit: cover;"
                                         alt="{{ $service->title }}">
                                </div>

                                <!-- Service Info -->
                                <div class="col-md-5">
                                    <h5 class="mb-1">
                                        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none">
                                            {{ $service->title }}
                                            @if($service->is_featured)
                                            <span class="badge bg-warning text-dark ms-2">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                            @endif
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-2">{{ Str::limit($service->description, 100) }}</p>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <span class="badge bg-primary">{{ $service->category->name }}</span>
                                        @if($service->city)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            {{ $service->city->name }}
                                        </small>
                                        @endif
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i> {{ $service->views }} views
                                        </small>
                                        <span class="badge {{ $service->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Price & Status -->
                                <div class="col-md-2">
                                    <h5 class="mb-0" style="color: #1E60AA;">
                                            {{ $service->hourly_rate }} JOD <small class="text-muted">/ hour</small>

                                    </h5>
                                    @if($service->is_featured && $service->featured_until)
                                    <small class="text-muted">
                                        Featured until: {{ $service->featured_until->format('M d, Y') }}
                                    </small>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="col-md-3 text-end">
                                    <div class="d-flex flex-wrap justify-content-end gap-2">
                                        <!-- View Button -->
                                        <a href="{{ route('services.show', $service->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('services.edit', $service->id) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Status Toggle -->
                                        <form action="{{ route('services.toggle-status', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm {{ $service->status == 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                    title="{{ $service->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas {{ $service->status == 'active' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Promote Button -->
                                        <a href="{{ route('services.promote', $service->id) }}"
                                           class="btn btn-sm {{ $service->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                                           title="Promote">
                                            <i class="fas fa-bullhorn"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this service?')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($services->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>

    <style>
        .list-group-item:hover {
            background-color: #e9ecef !important;
            transition: background-color 0.2s ease;
        }
        .btn-sm {
            min-width: 36px;
        }
        .badge {
            font-weight: 500;
        }
    </style>
    </x-user-sidebar>
</x-layout>
