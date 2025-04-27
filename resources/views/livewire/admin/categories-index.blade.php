<div class="admin-categories-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h2><i class="fas fa-tags me-2"></i> Categories Management</h2>
        <div class="admin-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="divider">/</span>
            <span class="active">Categories</span>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="admin-card">
        <!-- Card Header with Search and Actions -->
        <div class="card-header">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="categorySearch" placeholder="Search categories..." class="search-input" wire:model.live='search'>
                <button class="search-clear" id="clearSearch">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Add Category
                </a>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Slug</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>
                            <div class="category-info">
                                <span class="category-name">{{ $category->name }}</span>
                                @if($category->description)
                                <div class="category-description text-muted">{{ Str::limit($category->description, 60) }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($category->image)
                            <div class="category-image">
                                <img src="{{ asset( $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail">
                            </div>
                            @else
                            <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" onclick="confirmDeleteCategory(`{{$category->id}}`)">
                                        <i class="fas fa-trash"></i>
                                    </button>


                                <a href="{{ route('category.services', $category->slug) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" data-bs-title="View Public Page" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5 px-5">
            {{ $categories->links() }}
        </div>
    </div>
</div>
