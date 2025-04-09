@props(['url', 'color' => 'primary'])
<a href="{{ route($url)}}" class="btn btn-{{ $color }} py-3 px-4 $attributes">
    {{ $slot }}
</a>
