<x-layout>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <x-slot:title>Services</x-slot>

    {{-- show the categories in a grid --}}
    <section class=" py-5 services-list">
        <h2>Service in Jordan</h2>
        <x-breadcrumb></x-breadcrumb>

        <livewire:categories-list />

    </section>

    <section class="container mt-4">
        <h3 class="text-center">Services By Category</h3>
        @foreach ($allCategories->take(4) as $category )
            <x-service-section :category="$category"></x-service-section>
        @endforeach
    </section>
</x-layout>
