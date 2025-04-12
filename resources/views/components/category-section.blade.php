@props(['category'])

<div class="categories-section">
    <div class="d-flex justify-content-between mb-4">
        <span>{{$category->name}}</span>
        <x-index-button url="home" color="" btnTextColor="btn-text-blue" >More <i class='bx bx-right-arrow-alt'></i></x-index-button>
    </div>

    <div class="row">
        @foreach ($category->services->take(3) as $service)
            <a class="col-md-4" href="{{route('services.show', $service->id)}}">
                    <img src="{{ asset($service->images->first()->image)}}" alt="{{$service->title}}" class="categories-section-image" loading='lazy'>
                    <div class="d-flex justify-content-between">
                        <div class="detail-box">
                            {{Str::ucfirst($service->type)}}
                        </div>
                        <div class="detail-box">
                            {{$service->type == 'offer' ? $service->hourly_rate . ' JOD' : $service->min_price . " - " . $service->max_price . " JOD"}}
                        </div>
                    </div>
            </a>
        @endforeach
    </div>
</div>
