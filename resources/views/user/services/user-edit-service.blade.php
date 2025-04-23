<x-layout>
    <x-slot:title>Edit Service - {{ $service->title }}</x-slot>
    <script src="{{asset('js/service-managing.js')}}" defer></script>
    <x-user-sidebar>

        <div class="col-lg-10 edit-container">
            <div class="container py-4">
                <!-- Warning Notice -->
                <div class="alert alert-warning border-warning bg-warning bg-opacity-10 mb-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4 text-warning"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Important Notice</h5>
                        <p class="mb-0">Changing your title, Category or description will be considered as adding a new service</p>
                    </div>
                </div>

                <!-- Header with Back Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 mb-1">
                            <a href="{{ route('user.services' , Auth::user()) }}" class="text-decoration-none text-dark">
                                <i class="fas fa-arrow-left me-2"></i>
                            </a>
                            Edit Service
                        </h2>
                        <p class="text-muted mb-0">Update your service details carefully</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-eye me-1"></i> Preview
                        </a>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="card border-0 shadow-sm mb-4" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div class="mb-5">
                                <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </span>
                                    Basic Information
                                </h5>

                                <div class="row g-3">
                                    <!-- Service Title -->
                                    <div class="col-md-8">
                                        <label for="title" class="form-label fw-medium">Service Title <span class="text-danger fs-4">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $service->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Clear, specific titles perform better</small>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-4">
                                        <label for="category_id" class="form-label fw-medium">Category <span class="text-danger fs-4">*</span></label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12">
                                        <label for="description" class="form-label fw-medium">Description <span class="text-danger fs-4">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Detailed descriptions convert better</small>
                                            <small class="text-warning fw-medium">
                                                <i class="fas fa-exclamation-circle me-1"></i> Changes affect visibility
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Section -->
                            <div class="mb-5">
                                <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-tag text-primary"></i>
                                    </span>
                                    Pricing
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-4" id="hourlyRateField">
                                        <label for="hourly_rate" class="form-label fw-medium">Hourly Rate (JOD) <span class="text-danger fs-4">*</span></label>
                                        <div class="input-group">
                                            <input type="number" min="1"
                                                class="form-control @error('hourly_rate') is-invalid @enderror"
                                                id="hourly_rate" name="hourly_rate"
                                                value="{{ old('hourly_rate', $service->hourly_rate) }}">
                                            <span class="input-group-text">JOD/hour</span>
                                        </div>
                                        @error('hourly_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Location Section -->
                            <div class="mb-5">
                                <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </span>
                                    Location
                                </h5>

                                <div class="row g-3">
                                    <!-- City -->
                                    <div class="col-md-6">
                                        <label for="city_id" class="form-label fw-medium">City <span class="text-danger fs-4">*</span></label>
                                        <select class="form-select @error('city_id') is-invalid @enderror"
                                                id="city_id" name="city_id">
                                            <option value="">Select City (or choose Remote)</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id', $service->city_id) == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-md-6">
                                        <label for="address" class="form-label fw-medium">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address"
                                            value="{{ old('address', $service->address) }}"
                                            placeholder="Street, Building, etc.">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div class="mb-5">
                                <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-images text-primary"></i>
                                    </span>
                                    Media
                                </h5>

                                <!-- Current Images -->
                                @if($service->images->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Current Images</label>
                                    <div class="row g-3">
                                        @foreach($service->images as $image)
                                        <div class="col-6 col-md-3">
                                            <div class="position-relative border rounded p-2 bg-white">
                                                <img src="{{ asset(Str::contains($image->image, 'service-images') ? 'storage/' . $image->image : $image->image) }}"
                                                    class="img-fluid rounded"
                                                    style="height: 120px; width: 100%; object-fit: cover;">
                                                <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                                                        onclick="confirmDeleteImage({{ $image->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- New Images Upload -->
                                <div>
                                    <label for="images" class="form-label fw-medium">Add More Images</label>
                                    <input type="file" class="form-control @error('images') is-invalid @enderror"
                                        id="images" name="images[]" multiple accept="image/*">
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Upload high-quality images (Max 5MB each, JPG/PNG)</small>

                                    <!-- Image Preview Container -->
                                    <div id="imagePreview" class="row g-3 mt-3"></div>
                                </div>
                            </div>

                            <!-- Status Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="fas fa-toggle-on text-primary"></i>
                                    </span>
                                    Status
                                </h5>

                                <div class="form-check form-switch ps-0">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input ms-0 me-3" type="checkbox"
                                            id="status" name="status" value="active" role="switch" disabled
                                            {{ old('status', $service->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="status">
                                            {{$service->status == 'active' ? 'Service is Active (visible to clients)' : 'Service is Inactive (hidden for clients)'}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between pt-4 border-top">
                                <button type="button" class="btn btn-outline-danger"
                                        onclick="deleteService(`{{$service->slug}}`, `{{Auth::id()}}`)">
                                    <i class="fas fa-trash me-1"></i> Delete Service
                                </button>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.services', Auth::user()) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Delete Form (hidden) -->
                        <form id="deleteForm" action="{{ route('services.destroy', $service) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <style>

        </style>

        <script>

            // Image preview functionality
            document.getElementById('images').addEventListener('change', function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = '';

                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    if (!file.type.match('image.*')) continue;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-3 preview-item';

                        col.innerHTML = `
                            <img src="${e.target.result}" class="img-fluid w-100 border" alt="Preview">
                            <button type="button" class="remove-btn" onclick="removeImagePreview(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        `;

                        preview.appendChild(col);
                    }
                    reader.readAsDataURL(file);
                }
            });

            function removeImagePreview(button) {
                button.parentElement.remove();
            }

            function confirmDelete() {
                if (confirm('Are you sure you want to permanently delete this service? This cannot be undone.')) {
                    document.getElementById('deleteForm').submit();
                }
            }

            function confirmDeleteImage(imageId) {
                if (confirm('Are you sure you want to delete this image? It will be removed immediately.')) {
                    fetch(`/service-images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Error deleting image');
                        }
                    });
                }
            }
        </script>
    </x-user-sidebar>
</x-layout>
