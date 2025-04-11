@props(['category'])

<div class="service-section">
    <div class="d-flex justify-content-between">
        <span>{{$category->name}}</span>
        <x-index-button url="home" color="" btnTextColor="btn-text-blue" >More <i class='bx bx-right-arrow-alt'></i></x-index-button>
    </div>

    <div class="row">
        @foreach ($category->services->take(4) as $service)
            <span class="col-md-4 service-section-image">
                <div>
                    <img src="{{ asset($service->images->first()->image)}}" alt="">
                </div>
            </span>
        @endforeach
    </div>
</div>
