<x-layout>
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
    <x-slot:title>Categories</x-slot>

    {{-- show the categories in a grid --}}
    <section class=" py-5 categories-list">
        <h2>Service in Jordan</h2>
        <x-breadcrumb></x-breadcrumb>

        <livewire:categories-list />

    </section>

    {{-- <section class="container mt-4">
        <h3 class="text-center">Services By Category</h3>
        @foreach ($allCategories->take(4) as $category )
            <x-category-section :category="$category"></x-category-section>
        @endforeach --}}
    </section>
</x-layout>
