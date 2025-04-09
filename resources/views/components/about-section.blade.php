@props(['class' => ''])

<div class="row mb-5 mt-3">
    <div class="col-md-7 {{ $class }}">
        <h3 class="mb-3">{{ $title }}</h3>
        <p> {{ $text }} </p>
    </div>

    {{ $slot }}
</div>
