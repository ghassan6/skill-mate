<x-layout>
    <x-slot:title>Skill Mate</x-slot>



    <div class="container-xxl py-5 border border-5">
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

    <section class="service-banner flex">
        <div class="flex-column">
            <h4>Professional worker? a Handyman? or simply can provide a service?</h4>
        </div>
        <div>
            <h4></h4>
        </div>
        <div></div>

    </section>
</x-layout>

