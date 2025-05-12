<div>

    <div class="d-flex justify-content-center align-items-center mb-3">

        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search for category..." class="search-input" wire:model.live="search" id="userSearch">
            <button
                type="button"
                wire:click="clearSearch"
                class="search-clear">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="grid">
        @foreach ($categories as $category)
            <x-category-box-mini img="{{ $category->image }}" :category="$category">
                <x-slot:title>{{ $category->name }}</x-slot:title>
            </x-category-box-mini>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
