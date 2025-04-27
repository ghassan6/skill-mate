<x-admin.layout>
    <x-slot:title>Create new category</x-slot:title>
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">
    <script src="{{asset('js/admin/categories-managment.js')}}"></script>
    <x-admin.sidebar>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="admin-container">
            <div class="admin-content">
                <!-- Page Header -->
                <div class="admin-page-header">
                    <h2><i class="fas fa-edit me-2"></i> Edit Category</h2>
                    <div class="admin-breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span class="divider">/</span>
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                        <span class="divider">/</span>
                        <span class="active">Create</span>
                    </div>
                </div>

                <!-- Edit Category Card -->
                <div class="admin-card">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Basic Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-info-circle me-2"></i> Basic Information</h5>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="slug" name="slug" disabled>
                                            </div>
                                            <div class="form-text">URL-friendly identifier</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- Image Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-image me-2"></i> Category Image</h5>

                                        <div class="mb-3">
                                            <div class="image-upload-container">
                                                <div class="image-preview" id="imagePreview">
                                                    <img src="" alt="No image" class="image-preview__image">
                                                </div>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-admin.sidebar>
</x-admin.layout>
