<x-layout>
    <x-slot:title>{{ Str::ucfirst($user->username)}}'s Profile</x-slot:title>

    <x-user-sidebar>

        <h3>My account</h3>
        <div class="profile">
            <div class="image-container">
                <img src="{{asset($user->image)}}" alt="" class="profile-image">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="file-upload" class="edit-pic">
                        <i class='bx bx-edit-alt'></i> 
                    </label>
                    <input id="file-upload" type="file" name="image" accept="image/*" onchange="this.form.submit()" hidden>
                </form>

            </div>
            <div class="profile-info d-flex flex-column">
                <div>
                    <h4><strong>{{ $user->username }}</strong></h4>

                </div>
                <div class="d-flex gap-3">
                    <p><i class='bx bxs-envelope'> Email: {{ $user->email }} </i> </p>
                    <p><i class='bx bxs-phone'>Phone: {{ $user->phone_number }}</i></p>
                    @if($user->city)
                    <p><i class='bx bxs-home'>{{$user->city->name}}</i></p>
                    @endif
                    <p><i class='bx bxs-user'>Member since: {{date('d-m-Y', strtotime($user->created_at));}}</i></p>
                </div>
            </div>

        </div>

        <div class="tabs container-fluid nav-bar bg-light mb-3">
            <div class="navbar-nav d-flex gap-3 flex-row">
                <x-nav-link id="summary-tab" class="active">Summary</x-nav-link>
                <x-nav-link id="edit-profile-tab">Edit Profile</x-nav-link>
            </div>
        </div>

        <div class="summary" id="summary-section">
            <h4 class="mb-3">Summary</h4>
            <?php $totalRating = $user->reviews->where('user_id', $user->id)->count(); ?>
            <?php $services = $user->services->where('user_id', $user->id)->count(); ?>
            <p>Total Ratings: {{$totalRating > 0 ? $totalRating : "No ratings yet"  }}</p>
            <p>Services: {{$services > 0 ? $services : "No services yet"}} </p>
            <p>Proposals: {{$user->proposals->where('user_id', $user->id)->count() > 0 ? $user->proposals->where('user_id', $user->id)->count() : "No proposals yet"}}</p>

        </div>

        <div class="edit-profile" id="edit-profile-section" style="display: none;">
            <h4>Edit Profile</h4>
            <!-- edit profile form -->
            <form action="" method="POST" id="register-form">
                @csrf
                @method('PUT')

                <!-- Username -->
                <div class="mb-3">
                    <x-input-label for="username">Username </x-input-label>
                    <x-text-input type="text" name="username" id="username" value="{{ $user->username}}" placeholder="e.g. Jondoe132" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" id="usernameError" />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email">Email </x-input-label>
                    <x-text-input type="email" name="email" id="email" value="{{ $user->email}}" placeholder="e.g. Email@example.com" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password">Password </x-input-label>
                    <x-text-input type="password" name="password" id="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <div class="form-text">
                        Your password must be 6-18 characters long, contain capital and small letter, and must not contain spaces, or emoji.
                    </div>


                </div>

                <div class="mb-3">
                    <x-input-label for="password_confirmation">Confirm Password </x-input-label>
                    <x-text-input type="password" name="password_confirmation" id="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                </div>
                <!-- Phone Number -->
                <div class="mb-3">
                    <x-input-label for="phone">Phone Number </x-input-label>
                    <x-text-input type="tel" name="phone" id="phone" value="{{$user->phone_number }}" placeholder="e.g. 07XXXXXXXX" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- City Dropdown -->
                <div class="mb-3">
                    <x-input-label for="city">City</x-input-label>
                    <select name="city_id" id="city_id" class="form-select">
                        @if($user->city)
                        <option value='$user->city->id' selected>{{$user->city->name}}</option>
                        @else
                        <option value='0' selected disabled>Please select a city</option>
                        @endif
                        @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{Str::ucfirst( $city->name )}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" id="register-btn" class="btn btn-primary" disabled>Save and update</button>
                </div>

            </form>

        </div>
    </x-user-sidebar>


    <script src="{{asset('js/profile.js')}}"></script>

</x-layout>