@props(['active' => false])

<a class="{{ $active ? 'active' : '' }} nav-item nav-link {{ $attributes->get('class') }} "
aria-current="{{ $active ? 'page' : 'false' }}"
{{ $attributes}}
> 
{{ $slot }}
</a>