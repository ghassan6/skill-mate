<x-layout>
    <x-slot:title>Edit Profile</x-slot>

    <x-user-sidebar>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Profile Edit Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="text-center">
                            <h2 class="fw-bold mb-1">Edit Your Profile</h2>
                            <p class="text-muted">Update your personal information</p>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <!-- Profile Picture Update -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset(str_contains($user->image, 'profile') ? 'storage/' . $user->image : $user->image) }}"
                                     class="rounded-circle shadow-sm"
                                     alt="Profile picture">
                                     <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <label for="file-upload" class="edit-pic">
                                            <i class='bx bx-camera'></i>
                                        </label>
                                        <input id="file-upload" type="file" name="image" accept="image/*" onchange="this.form.submit()" hidden>
                                    </form>
                            </div>
                        </div>
                        {{-- for successfully updated information --}}
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- for images errors --}}
                        @if($errors->has('image'))
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->get('image') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


                        <!-- Edit Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="update-form">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-2">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    Basic Information
                                </h5>

                                <div class="row g-3">
                                    <!-- Username -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   id="username"
                                                   name="username"
                                                   value="{{ old('username', $user->username) }}"
                                                   placeholder="Username">
                                            <label for="username">Username</label>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="Email">
                                            <label for="email">Email</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="phone"
                                                   name="phone"
                                                   value="{{ old('phone', $user->phone_number) }}"
                                                   placeholder="Phone Number">
                                            <label for="phone">Phone Number</label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('city_id') is-invalid @enderror"
                                                    id="city_id"
                                                    name="city_id">
                                                @if($user->city)
                                                    <option value="{{ $user->city->id }}" selected>{{ $user->city->name }}</option>
                                                @else
                                                    <option value="" selected disabled>Select your city</option>
                                                @endif
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if(old('city_id') == $city->id) selected @endif>
                                                        {{ Str::ucfirst($city->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="city_id">City</label>
                                            @error('city_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bio Textarea -->
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                                      id="bio"
                                                      name="bio"
                                                      placeholder="About me"
                                                      style="height: 120px">{{ old('bio', $user->bio) }}</textarea>
                                            <label for="bio">About Me</label>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle me-1"></i> Tell others about yourself (max 500 characters)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-2">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    Password Update
                                </h5>

                                <div class="row g-3">
                                    <!-- New Password -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password"
                                                   name="password"
                                                   placeholder="New Password">
                                            <label for="password">New Password</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle me-1"></i> 6-18 characters with uppercase, lowercase, no spaces
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password"
                                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   placeholder="Confirm Password">
                                            <label for="password_confirmation">Confirm Password</label>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-grid gap-3 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary btn-lg py-3">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

    </style>

    <script>
        // Preview profile picture before upload
        document.getElementById('profile-picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.querySelector('.rounded-circle').src = event.target.result;
                };
                reader.readAsDataURL(file);
                // Auto-submit the form if you want immediate upload
                // document.getElementById('update-form').submit();
            }
        });
    </script>
    </x-user-sidebar>
</x-layout>
