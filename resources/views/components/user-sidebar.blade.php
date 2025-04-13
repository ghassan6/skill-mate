<link rel="stylesheet" href="{{asset('css/user-profile.css')}}">


<div class="d-flex">
    <div class="sidebar">
        <div class="sidebar-header p-3 text-center">
            <h5 class="mb-0">User Dashboard</h5>
        </div>

        <ul>
            <li>
                <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class='bx bx-user'></i> Profile
                </a>
            </li>
            <li>
                <a href="{{ route('user.notifications') }}" class="{{ request()->routeIs('user.notifications') ? 'active' : '' }}">
                    <i class='bx bx-bell'></i> Notifications
                    <span class="badge bg-danger ms-auto">3</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.services') }}" class="{{ request()->routeIs('user.services') ? 'active' : '' }}">
                    <i class='bx bx-briefcase'></i> My Services
                </a>
            </li>
            <li>
                <a href="{{route('saved-services.index')}}" class="{{ request()->routeIs('user.favorites') ? 'active' : '' }}">
                    <i class='bx bx-heart'></i> Favorites
                    <span class="badge bg-primary ms-auto">{{ auth()->user()->savedServices()->count() }} </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message-square-dots'></i> Messages
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog'></i> Settings
                </a>
            </li>
        </ul>

        <!-- Favorites Quick View -->
        <div class="sidebar-footer p-3">
            <h6 class="sidebar-title">Quick Links</h6>
            <ul class="quick-links">
                <li><a href="#"><i class='bx bx-bookmark'></i> Saved Items</a></li>
                <li><a href="#"><i class='bx bx-history'></i> Recent Views</a></li>
                <li><a href="#"><i class='bx bx-star'></i> Top Rated</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        {{ $slot }}
    </div>
</div>

<style>

</style>
