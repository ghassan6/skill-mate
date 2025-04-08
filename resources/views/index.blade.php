<x-layout>
    <x-slot:title>Skill Mate</x-slot>



    <div class="container-xxl py-5">
        <h2></h2>
        <div class="container">
            <div class="row g-4">
                @foreach ($categories as $category)
                <x-service-main>
                    <x-slot:image_path>{{$category->slug}}</x-slot:image_path>
                    <x-slot:title>{{$category->name}}</x-slot:title>
                </x-service-main>
                @endforeach
            </div>
        </div>
    </div>

    <section class="service-banner d-flex gap-4 justify-content-center align-items-center">
        <div class="d-flex flex-column gap-4">
            <strong >Professional worker? a Handyman? or simply can provide a service?</strong>
            <img src="{{asset('images/main/banner-service-left.png')}}" alt="banner-service-left">
            <x-service-banner-button url="services">Search for services</x-service-banner-button>
        </div>
        <div class="d-flex flex-column">
            <x-service-banner-box>{{$services->count()}} Services</x-service-banner-box>
            <x-service-banner-box>
                <x-slot:bold>Best Prices</x-slot:bold>
                Post Your Service and Earn Money
            </x-service-banner-box>
        </div>
        <div class="d-flex flex-column gap-4">
            <strong>Need something to be done?</strong>
            <img src="{{asset('images/main/banner-service-right3.png')}}" alt="banner-service-right">
            <x-service-banner-button url="home" color="orange">List your request </x-service-banner-button>
        </div>

    </section>

    <!-- here continue browing section -->
</x-layout>

