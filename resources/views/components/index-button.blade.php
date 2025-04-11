@props(['url', 'color' => 'primary' , 'btnTextColor' => ''])
<a href="{{ route($url)}}"  {{$attributes->merge(["class" => "btn btn-$color $btnTextColor" ])}} >
    {{ $slot }}
</a>
