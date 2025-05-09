<x-admin.layout>
    <x-slot:title>Edit user</x-slot:title>
    <script src="{{asset('js/admin/user-managment.js')}}" defer></script>

    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">

    <x-admin.sidebar>
        <div class="admin-container">
            <!-- Sidebar would be here -->
            <div class="admin-content">
                <!-- Page Header -->
                <div class="admin-page-header">
                    <h2><i class="fas fa-user-plus me-2"></i> Create New User</h2>
                    <div class="admin-breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span class="divider">/</span>
                        <a href="{{ route('admin.users.index') }}">Users</a>
                        <span class="divider">/</span>
                        <span class="active">Edit</span>
                    </div>
                </div>

                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif --}}
                <!-- User Creation Card -->
                <div class="admin-card">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <!-- Basic Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-id-card me-2"></i> Basic Information</h5>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control  @error('username') is-invalid @enderror" id="username" name="username" required value="{{$user->username ?? old('username')}}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{$user->first_name ?? old('first_name')}}">
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{$user->last_name ?? old('last_name')}}">
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label @error('email') is-invalid @enderror">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required value="{{$user->email ?? old('email')}}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label @error('password') is-invalid @enderror">Password <span class="text-danger">*</span></label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="password" name="password" >
                                                <button class="btn btn-outline-secondary" type="button" id="generatePassword">
                                                    <i class="fas fa-random"></i> Generate
                                                </button>
                                            </div>
                                            <div class="form-text">Minimum 8 characters</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label @error('password_confirmation') is-invalid @enderror">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" >
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contact Information Section -->
                                    <div class="form-section mt-4">
                                        <h5 class="section-title"><i class="fas fa-phone-alt me-2"></i> Contact Information</h5>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control  @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $user->phone_number ?? old('phone')}}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="city_id" class="form-label">City</label>
                                            <select class="form-select @error('city') is-invalid @enderror" id="city_id" name="city_id">
                                                <option value="">Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <!-- Profile Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-user-circle me-2"></i> Profile</h5>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Profile Image</label>
                                            <div class="image-upload-container">
                                                <div class="image-preview" id="imagePreview">
                                                    <img src="{{ asset(str_contains($user->image, 'profile') ? 'storage/' . $user->image : $user->image) }}" alt="Image Preview" class="image-preview__image">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3" >{{$user->bio ?? old('bio')}}</textarea>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="listing_limit" class="form-label @error('listing_limit') is-invalid @enderror">Listing Limit</label>
                                            <input type="number" class="form-control" id="listing_limit" name="listing_limit" min="0" value="{{$user->listing_limit ?? old('listing_limit') }}">
                                            @error('listing_limit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="email_verified" name="email_verified" {{is_null($user->email_verified_at) ? '' : 'checked disabled'}}>
                                            <label class="form-check-label" for="email_verified">{{is_null($user->email_verified_at) ? " Mark email as verified" : 'Email is verified'}}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-admin.sidebar>
</x-admin.layout>
