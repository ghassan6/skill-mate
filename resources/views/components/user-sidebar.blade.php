
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div class="d-flex">

    <div class="sidebar">
        <ul>
            <li><a href="{{ route('user.profile') }}">👤 Profile</a></li>
            <li><a href="{{ route('user.notifications') }}">🔔 Notifications</a></li>
            <li><a href="{{ route('user.services') }}">🛠️ Services</a></li>
        </ul>
    </div>
    
    <div class="content">
        {{ $slot }}
    </div>
</div>

