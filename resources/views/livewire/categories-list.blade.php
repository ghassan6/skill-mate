<div>
    <div class="grid">
        @foreach ($categories as $category)
            <x-service-box-mini img="{{ $category->image }}">
                <x-slot:title>{{ $category->name }}</x-slot:title>
            </x-service-box-mini>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
