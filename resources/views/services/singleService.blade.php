<x-layout>
    <x-slot:title>{{$service->title}}</x-slot>
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
    <script src="{{ asset('js/singleService.js')}}" defer></script>
<div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <x-owner-box :service="$service"></x-owner-box>
            </div>
            <section class="col service-content">
                <h4 class="text-start">{{$service->title}}</h4>
                {{-- images section --}}
                <div id="serviceGallary" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($service->images as $image)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img src="{{ asset($image->image)}}" class="d-block w-100" alt="{{$service->title}}">
                            </div>
                        @endforeach
                    </div>
                    <span class="image-indicator" id="carousel-counter"> / {{ $service->images->count() }}</span>

                    <button class="carousel-control-prev" type="button" data-bs-target="#serviceGallary" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#serviceGallary" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>

                {{-- show basic information in a box --}}
                <div class="information">
                    <h4 class="text-left">Information</h4>
                    <div class="information-box border-5 border">

                        <div class="row">
                            <div class="col-6 d-flex justify-content-between me-auto">
                                <strong>Category</strong>
                                <p>{{$service->category->name}}</p>
                            </div>
                            <div class="col-6 d-flex justify-content-between">
                                <strong>Price</strong>
                                <p>{{$service->type == 'offer' ? $service->hourly_rate . ' JOD' : $service->min_price . " - " . $service->max_price . " JOD"}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 d-flex justify-content-between me-auto">
                                <strong>City</strong>
                                <p>{{$service->city->name}}</p>
                            </div>
                            <div class="col-6 d-flex justify-content-between">
                                <strong>Owner</strong>
                                <p>{{$service->user->username}}</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- show the service description --}}
                <section class="description mt-4">
                    <h4 class="text-left">Description</h4>
                    <hr>
                    {{$service->description}}
                </section>


            </section>

        </div>
    </div>
</div>


</x-layout>
