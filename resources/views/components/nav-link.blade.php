@props(['active' => false])

<a  class=" {{ $active ? 'active' : '' }} nav-item nav-link"
aria-current="{{ $active ? 'page' : 'false' }}"
{{ $attributes}}
> 
{{ $slot }}</a>

