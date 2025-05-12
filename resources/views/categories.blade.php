<x-layout>
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
    <x-slot:title>Categories</x-slot>

    {{-- show the categories in a grid --}}
    <section class=" py-5 categories-list">
        <h2>Service in Jordan</h2>
        <x-breadcrumb></x-breadcrumb>

        <livewire:categories-list />

    </section>

</x-layout>
