<x-layout>
    <x-slot:title>{{ Str::ucfirst($user->username)}}'s Profile</x-slot:title>

    <x-user-sidebar>
        <!-- Profile Header Section -->
        <div class="profile-header d-flex flex-column flex-sm-row align-items-center">
            <div class="profile-image-container">
                <img src="{{asset(str_contains($user->image, 'profile') ? 'storage/' . $user->image : $user->image)}}"
                     alt="profile-picture"
                     class="profile-image"
                     onerror="this.src='{{ asset('images/main/defaultUser.jpg') }}'">
                <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="file-upload" class="edit-pic">
                        <i class='bx bx-camera'></i>
                    </label>
                    <input id="file-upload" type="file" name="image" accept="image/*" onchange="this.form.submit()" hidden>
                </form>
            </div>

            <div class="profile-info">
                <h2 class="mb-2"><strong>{{ $user->username }}</strong></h2>

                <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                    <span><i class='bx bxs-envelope'></i> {{ $user->email }}</span>
                    @if($user->phone_number)
                    <span><i class='bx bxs-phone'></i> {{ $user->phone_number }}</span>
                    @endif
                    @if($user->city)
                    <span><i class='bx bxs-map'></i> {{Str::ucfirst($user->city->name)}}</span>
                    @endif
                </div>

                <div class="profile-stats">
                    <span class="stat-item"><i class='bx bx-calendar'></i> Joined {{date('M Y', strtotime($user->created_at))}}</span>
                    <span class="stat-item"><i class='bx bx-star'></i> {{$user->rating}} Rating</span>
                </div>
            </div>
        </div>

        <!-- Alerts Section -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Navigation Tabs -->
        {{-- <ul class="nav nav-tabs" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab">Summary</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab">Edit Profile</button>
            </li>
        </ul> --}}

        <!-- Tab Content -->
        <div class="tab-content" id="profileTabsContent">
            <!-- Summary Tab -->
            {{-- class="tab-pane fade show active" id="summary" role="tabpanel" --}}
            <div >
                {{-- <h4 class="mb-4">Activity Summary</h4> --}}
                <section class="summary" id="summary-section">
                    <h4 class="mb-3">Summary</h4>
                    <div class="d-flex gap-3 flex-wrap">
                        <x-summary-box table='reviews'></x-summary-box>
                        <x-summary-box table='services'></x-summary-box>
                        <x-summary-box table='proposals'></x-summary-box>
                    </div>

                </section>

                <!-- Recent Activity Section -->
                <div class="mt-5">
                    <h4 class="mb-4">Recent Activity</h4>
                    <div class="list-group">
                        <!-- Sample activity items -->
                        <div class="list-group-item border-0 shadow-sm mb-2 rounded">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-check-circle text-success me-3' style="font-size: 1.5rem;"></i>
                                <div>
                                    <h6 class="mb-1">Service completed</h6>
                                    <small class="text-muted">Web Development project - 2 days ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 shadow-sm mb-2 rounded">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-star text-warning me-3' style="font-size: 1.5rem;"></i>
                                <div>
                                    <h6 class="mb-1">Received a 5-star review</h6>
                                    <small class="text-muted">From client123 - 5 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Tab -->
            {{-- <div class="tab-pane fade" id="edit-profile" role="tabpanel">
                <div class="edit-profile-form">
                    <h4 class="mb-4">Edit Profile Information</h4>
                    <form action="{{route('profile.update')}}" method="POST" id="update-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="username">Username</x-input-label>
                                <x-text-input type="text" name="username" id="username" value="{{ $user->username}}" placeholder="e.g. Jondoe132" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="email">Email</x-input-label>
                                <x-text-input type="email" name="email" id="email" value="{{ $user->email}}" placeholder="e.g. Email@example.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="password">New Password</x-input-label>
                                <x-text-input type="password" name="password" id="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <small class="form-text text-muted">
                                    Password must be 6-18 characters with uppercase, lowercase, and no spaces.
                                </small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="password_confirmation">Confirm Password</x-input-label>
                                <x-text-input type="password" name="password_confirmation" id="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row">
                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="phone">Phone Number</x-input-label>
                                <x-text-input type="tel" name="phone" id="phone" value="{{$user->phone_number }}" placeholder="e.g. 07XXXXXXXX" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- City Dropdown -->
                            <div class="col-md-6 mb-3">
                                <x-input-label for="city_id">City</x-input-label>
                                <select name="city_id" id="city_id" class="form-select">
                                    @if($user->city)
                                    <option value="{{ $user->city->id }}" selected>{{ $user->city->name }}</option>
                                    @else
                                    <option value="" selected disabled>Select your city</option>
                                    @endif
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ Str::ucfirst($city->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>
    </x-user-sidebar>

    <!-- JavaScript -->
    {{-- <script src="{{asset('js/profile.js')}}"></script>
    <script>
        // Initialize Bootstrap tabs
        const profileTabs = new bootstrap.Tab(document.getElementById('summary-tab'));
        profileTabs.show();
    </script> --}}
</x-layout>
