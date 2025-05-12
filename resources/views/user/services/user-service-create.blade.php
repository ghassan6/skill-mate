<x-layout>
    <x-slot:title>Create New Service</x-slot>
    <x-user-sidebar>
        <script src="{{asset('js/user-service-create.js')}}" defer></script>


        <div class="position-relative">
            @if(Auth::user()->listing_limit == 0) {{-- Replace with your actual condition --}}
            <div class="blur-overlay d-flex justify-content-center align-items-center">
                {{-- the user has the maximum lisintg --}}
                <div class="text-center">
                    <h2 class="text-danger">Service Limit Reached</h2>
                    <p class="text-muted">You have reached the maximum number of services you can create.</p>
                    <p class="text-muted">Please buy new slots for services</p>
                    <a href="{{ route('user.profile') }}" class="btn btn-primary">Exceed Service limit</a>
                </div>

            </div>
            @endif
            <div class="service-creation-container {{ (Auth::user()->listing_limit == 0 ) ? 'blurred' : '' }}" >
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <!-- Service Creation Card -->
                            <div class="card border-0 shadow-lg overflow-hidden">
                                <!-- Card Header with Progress Steps -->
                                <div class="card-header bg-white py-4 border-0">
                                    <div class="text-center">
                                        <h2 class="fw-bold mb-1">Create Your Service</h2>
                                        <p class="text-muted">Fill in the details to showcase your skills</p>
                                    </div>
                                    <div class="creation-steps mt-4">
                                        <div class="steps-progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <div class="steps-nav">
                                            <div class="step active" data-step="1">
                                                <div class="step-number">1</div>
                                                <div class="step-label">Basic Info</div>
                                            </div>
                                            <div class="step" data-step="2">
                                                <div class="step-number">2</div>
                                                <div class="step-label">Details</div>
                                            </div>
                                            <div class="step" data-step="3">
                                                <div class="step-number">3</div>
                                                <div class="step-label">Location</div>
                                            </div>
                                            <div class="step" data-step="4">
                                                <div class="step-number">4</div>
                                                <div class="step-label">Review</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body p-4 p-md-5">
                                    <form action="{{ route('services.store') }}" method="POST" id="service-form" enctype="multipart/form-data" >
                                        @csrf

                                        <!-- Step 1: Basic Information -->
                                        <div class="creation-step active " data-step="1">
                                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                                <span class="icon-circle bg-primary-light text-primary me-3">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                Basic Information
                                            </h5>

                                            <!-- Service Title -->
                                            <div class="mb-4">
                                                <label for="title" class="form-label fw-bold">Service Title <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control form-control-lg @error('title') is-invalid @enderror"
                                                    id="title"
                                                    name="title"
                                                    value="{{ old('title') }}"
                                                    placeholder="e.g. Professional Home Cleaning"
                                                    required>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="text-danger err" id="title-error"></p>
                                                <small class="text-muted">Make it descriptive and appealing</small>
                                            </div>

                                            <!-- Category Selection -->
                                            <div class="mb-4">
                                                <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                                        id="category_id"
                                                        name="category_id"
                                                        required>
                                                    <option value="" disabled selected>Select a category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="text-danger err" id="category-error"></p>
                                            </div>

                                            <!-- Description -->
                                            <div class="mb-4">
                                                <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('description') is-invalid @enderror"
                                                        id="description"
                                                        name="description"
                                                        rows="5"
                                                        placeholder="Describe your service in detail..."
                                                        required>{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="d-flex justify-content-between mt-1">
                                                    <small class="text-muted">Be detailed about what you offer</small>
                                                    <small class="text-muted"><span id="desc-char-count">0</span>/500 characters</small>

                                                </div>
                                                <p class="text-danger err" id="description-error"></p>
                                            </div>

                                            <div class="d-flex justify-content-between mt-5">
                                                <button type="button" class="btn btn-outline-secondary btn-lg disabled">Previous</button>
                                                <button type="button" class="btn btn-primary btn-lg next-step">Next: Service Details</button>
                                            </div>
                                        </div>

                                        <!-- Step 2: Service Details -->
                                        <div class="creation-step" data-step="2">
                                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                                <span class="icon-circle bg-primary-light text-primary me-3">
                                                    <i class="fas fa-tags"></i>
                                                </span>
                                                Service Details
                                            </h5>

                                            <!-- Hourly Rate -->
                                            <div class="mb-4">
                                                <label for="hourly_rate" class="form-label fw-bold">Hourly Rate (JOD) <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">JOD</span>
                                                    <input type="number"
                                                        class="form-control form-control-lg @error('hourly_rate') is-invalid @enderror"
                                                        id="hourly_rate"
                                                        name="hourly_rate"
                                                        value="{{ old('hourly_rate') }}"
                                                        min="1"
                                                        max="500"
                                                        placeholder="e.g. 25"
                                                        required>
                                                </div>
                                                @error('hourly_rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Make it reasonable</small>

                                            </div>
                                            <p class="text-danger err" id="hourlyRate-error"></p>
                                            <!-- Service Images -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Service Images</label>
                                                <div class="image-upload-container">
                                                    <div class="dropzone" id="service-images-dropzone" data-store-url={{route('services.upload')}}>
                                                        <div class="dz-message">
                                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                            <h5>Drag & drop images here</h5>
                                                            <p class="text-muted">or click to browse (max 5 images)</p>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Showcase your work with high-quality images</small>
                                                </div>
                                                <p class="text-danger err" id="image-error"></p>

                                            </div>

                                            <div class="d-flex justify-content-between mt-5">
                                                <button type="button" class="btn btn-outline-secondary btn-lg prev-step">Previous</button>
                                                <button type="button" class="btn btn-primary btn-lg next-step">Next: Location</button>
                                            </div>
                                        </div>

                                        <!-- Step 3: Location -->
                                        <div class="creation-step" data-step="3">
                                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                                <span class="icon-circle bg-primary-light text-primary me-3">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                Service Location
                                            </h5>

                                            <!-- City -->
                                            <div class="mb-4">
                                                <label for="city_id" class="form-label fw-bold">City <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-lg @error('city_id') is-invalid @enderror"
                                                        id="city_id"
                                                        name="city_id"
                                                        required>
                                                    <option value="" disabled selected>Select your city</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" @if(old('city_id') == $city->id) selected @endif>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <p class="text-danger err" id="city-error"></p>

                                            </div>

                                            <!-- Address -->
                                            <div class="mb-4">
                                                <label for="address" class="form-label fw-bold">Service Address (Optional)</label>
                                                <input type="text"
                                                    class="form-control form-control-lg @error('address') is-invalid @enderror"
                                                    id="address"
                                                    name="address"
                                                    value="{{ old('address') }}"
                                                    placeholder="e.g. 123 Main St, Apt 4B">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Leave blank if you travel to clients</small>
                                                <p class="text-danger err" id="address-error"></p>

                                            </div>

                                            <!-- Service Area -->
                                            {{-- <div class="mb-4">
                                                <label class="form-label fw-bold">Service Area Radius</label>
                                                <div class="range-slider-container">
                                                    <input type="range"
                                                        class="form-range"
                                                        id="service_radius"
                                                        name="service_radius"
                                                        min="0"
                                                        max="50"
                                                        step="5"
                                                        value="10">
                                                    <div class="range-labels">
                                                        <span>0 miles</span>
                                                        <span id="radius-value">10 miles</span>
                                                        <span>50+ miles</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted">How far you're willing to travel for this service</small>
                                            </div> --}}

                                            <div class="d-flex justify-content-between mt-5">
                                                <button type="button" class="btn btn-outline-secondary btn-lg prev-step">Previous</button>
                                                <button type="button" class="btn btn-primary btn-lg next-step">Next: Review</button>
                                            </div>
                                        </div>

                                        <!-- Step 4: Review & Submit -->
                                        <div class="creation-step" data-step="4">
                                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                                <span class="icon-circle bg-primary-light text-primary me-3">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                                Review Your Service
                                            </h5>

                                            <div class="review-summary">
                                                <div class="review-section">
                                                    <h6 class="review-title">Basic Information</h6>
                                                    <div class="review-content">
                                                        <p><strong>Title:</strong> <span id="review-title"></span></p>
                                                        <p><strong>Category:</strong> <span id="review-category"></span></p>
                                                        <p><strong>Description:</strong> <span id="review-description"></span></p>
                                                    </div>
                                                </div>

                                                <div class="review-section">
                                                    <h6 class="review-title">Service Details</h6>
                                                    <div class="review-content">
                                                        <p><strong>Hourly Rate:</strong> $<span id="review-rate"></span></p>
                                                        <p><strong>Featured Service:</strong> <span id="review-featured"></span></p>
                                                    </div>
                                                </div>

                                                <div class="review-section">
                                                    <h6 class="review-title">Location</h6>
                                                    <div class="review-content">
                                                        <p><strong>City:</strong> <span id="review-city"></span></p>
                                                        <p><strong>Address:</strong> <span id="review-address"></span></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-check mb-4">
                                                <input class="form-check-input @error('terms') is-invalid @enderror"
                                                    type="checkbox"
                                                    id="terms"
                                                    name="terms"
                                                    required>
                                                <label class="form-check-label" for="terms">
                                                    I agree to the <a href="{{route('terms')}}" class="text-primary" target="_blank">Terms of Service</a>
                                                </label>
                                                @error('terms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="d-flex justify-content-between mt-5">
                                                <button type="button" class="btn btn-outline-secondary btn-lg prev-step">Previous</button>
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-check-circle me-2"></i> Publish Service
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-user-sidebar>

</x-layout>
