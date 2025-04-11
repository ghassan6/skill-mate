<x-layout>
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <x-slot:title>Services</x-slot>

    <div class=" py-5 services-list">
        <h2>Service in Jordan</h2>
        <x-breadcrumb></x-breadcrumb>
        <div class="grid">

            @foreach ($categories as $category )
                <x-service-box-mini img="{{$category->slug}}">
                    <x-slot:title> {{ $category->name}}</x-slot:title>
                </x-service-box-mini>

            @endforeach
        </div>
    </div>

    <div class="container mt-4">
        @foreach ($categories as $category )

            <x-service-section :category="$category"> </x-service-section>
        @endforeach
    </div>
</x-layout>
