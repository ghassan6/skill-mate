<div>
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
