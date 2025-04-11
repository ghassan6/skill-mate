@props(['url', 'color' => 'primary'])
<a href="{{ route($url)}}"  {{$attributes->merge(["class" => "btn btn-$color" ])}} >
    {{ $slot }}
</a>
