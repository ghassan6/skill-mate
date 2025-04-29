<div class="admin-container">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <!-- Logo/Branding -->
        <div class="sidebar-brand">
            <i class="fas fa-shield-alt admin-icon"></i>
            <span class="brand-text">AdminPro</span>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-title">Dashboard</div>
                <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home nav-icon"></i>
                    <span>Overview</span>
                </a>
            </div>

            <!-- Users Section -->
            <div class="nav-section">
                <div class="nav-title">User Management</div>
                <a href="{{route('admin.users.index')}}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <span>All Users</span>
                    <span class="badge">{{\App\Models\User::count() > 99 ?  '99+' : \App\Models\User::count()}}</span>
                </a>
                <a href="{{route('admin.users.create')}}" class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : ''}}">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <span>Create User</span>
                </a>
            </div>

            <!-- Categories Section -->
            <div class="nav-section">
                <div class="nav-title">Categories</div>
                <a href="{{route('admin.categories.index')}}" class="nav-link {{request()->routeIs('admin.categories.index') ? 'active' : ''}}">
                    <i class="fas fa-tags nav-icon"></i>
                    <span>All Categories</span>
                    <span class="badge">{{\App\Models\Category::count() > 99 ?  '99+' : \App\Models\Category::count()}}</span>
                </a>
                <a href="{{route('admin.categories.create')}}" class="nav-link {{request()->routeIs('admin.categories.create') ? 'active' : ''}}">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <span>Create Category</span>
                </a>
            </div>

            <!-- Services Section -->
            <div class="nav-section">
                <div class="nav-title">Services</div>
                <a href="{{route('admin.services.index')}}" class="nav-link {{request()->routeIs('admin.services.index') ? 'active' : ''}}">
                    <i class="fas fa-cogs nav-icon"></i>
                    <span>Manage Services</span>
                    <span class="badge">{{\App\Models\Service::count() > 99 ?  '99+' : \App\Models\Service::count()}}</span>
                </a>
            </div>

            <!-- Reports Section -->
            <div class="nav-section">
                <div class="nav-title">Reports</div>
                <a href="{{route('admin.service.reports')}}" class="nav-link {{request()->routeIs('admin.service.reports') ? 'active' : ''}}">
                    <i class="fas fa-flag nav-icon"></i>
                    <span>Services Reports</span>
                    <span class="badge danger">{{\App\Models\Report::where('status' ,'pending')->count() > 99 ?  '99+' : \App\Models\Report::where('status' , 'pending')->count()}}</span>
                </a>
            </div>

            <!-- System Section -->
            <div class="nav-section">
                <div class="nav-title">System</div>
                <a href="#" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <span>Settings</span>
                </a>
                <form action="{{route('logout')}}" class="nav-link" method="POST">
                    @csrf
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <button type="submit" class="btn btn-link p-0 ms-n3 text-decoration-none text-black fs-5">Logout</button>
                </form>
            </div>
        </nav>

        <!-- Collapse Button -->
        <div class="sidebar-collapse">
            <i class="fas fa-chevron-left"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        {{ $slot }}
    </div>
</div>
