<x-layout>
    <x-slot:title>Skill Mate</x-slot>
    
    <h2>This is the home page</h2>

    <div class="container-xxl py-5">
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
</x-layout>

