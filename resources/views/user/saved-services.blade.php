<x-layout>
    <x-slot:title>My Saved Services</x-slot>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <x-user-sidebar>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i> Browse Services
            </a>
        </div>

        <!-- Saved Services List -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-heart text-danger me-2"></i>
                    {{ auth()->user()->savedServices()->count() }} Saved Services
                </h5>
            </div>

            <div class="card-body p-0">
                @if($services->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-heart text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">No saved services yet</h4>
                        <p class="text-muted">Save services you're interested in by clicking the heart icon</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-search me-2"></i> Browse Services
                        </a>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($services as $service)
                        <div class="list-group-item border-0 py-3 px-4 my-4" style="background-color: #f1f1f1">
                            <div class="row align-items-center">
                                <!-- Service Image -->
                                <div class="col-md-2">
                                    <img src="{{ $service->images->first() ? asset($service->images->first()->image) : asset('images/services/service-default.png') }}"
                                         class="img-fluid rounded"
                                         style="height: 100px; width: 100%; object-fit: cover;"
                                         alt="{{ $service->title }}">
                                </div>

                                <!-- Service Info -->
                                <div class="col-md-6">
                                    <h5 class="mb-1">
                                        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none">
                                            {{ $service->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-2">{{ Str::limit($service->description, 150) }}</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary me-2">{{ $service->category->name }}</span>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            {{ $service->city->name }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Price & Actions -->
                                <div class="col-md-4 text-md-end">
                                    <div class="d-flex flex-column">
                                        <h5 class="mb-2" style="color: #1E60AA;">
                                                {{ $service->hourly_rate }} JOD <small class="text-muted">/ hour</small>

                                        </h5>

                                        <div class="d-flex justify-content-end gap-2 mt-2">
                                            <form action="{{ route('services.save', $service->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-heart"></i> Remove
                                                </button>
                                            </form>
                                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </div>
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
                {{ $services->links() }}
            </div>
            @endif
        </div>
    </div>

    <style>

    </style>
    </x-user-sidebar>
</x-layout>
