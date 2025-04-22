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
            <span class="stat-item"><i class='bx bx-star'></i> {{ number_format($user->averageRating(), 2) }}
            Rating</span>
        </div>
    </div>
</div>


        <!-- Alerts Section -->
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4">
            <!-- Summary Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Summary</h4>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <x-summary-box table='reviews'></x-summary-box>
                        </div>
                        <div class="col-md-4">
                            <x-summary-box table='services'></x-summary-box>
                        </div>
                        <div class="col-md-4">
                            <x-summary-box table='remaining lsiting'></x-summary-box>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Services Section -->
            @if($completedServices = Auth::user()->completedServices()->take(5)->get())
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Recently Completed Services</h4>
                    <div class="list-group list-group-flush">
                        @foreach($completedServices as $service)
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3 text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="text-dark">
                                    <h6 class="mb-1 text-dark">{{ $service->title }}</h6>
                                    <small class="text-muted">Completed {{ $service->updated_at->diffForHumans() }}</small>
                                    @php
                                    $firstInquiry = $service->inquiries->first();
                                    @endphp

                                    @if($firstInquiry && $firstInquiry->user)
                                        <small class="d-block mt-1">For {{ $firstInquiry->user->username }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif


        </div>
    </x-user-sidebar>

    <!-- JavaScript -->
    <script src="{{asset('js/profile.js')}}"></script>
</x-layout>
