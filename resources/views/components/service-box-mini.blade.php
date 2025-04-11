@props(['img' => ""])
<a class="service-box-mini d-flex align-items-center" href="/">
    <span> {{ $title }}</span>

    <img src="{{asset('images/services-icons/'.  $img . '.png')}}" alt="{{$title}}" class="service-icon">
</a>
