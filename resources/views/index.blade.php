<x-layout>
    <x-slot:title>Skill Mate</x-slot>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="latest d-flex justify-content-between">
                    <strong><span  class="header">Latest Categories</span></strong>
                    <x-index-button url='services.index' color='orange' class="py-3 px-4">See All <i class='bx bx-right-arrow-alt '></i></x-index-button>

                </div>
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
            <x-index-button url="services.index" class="py-3 px-4">Search for services</x-index-button>
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
            <x-index-button url="home" color="orange" class="py-3 px-4">List your request </x-index-button>
        </div>

    </section>

    <!-- here continue browing section -->
</x-layout>

