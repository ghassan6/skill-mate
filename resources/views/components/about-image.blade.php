@props(['src' => '' , 'class' => ''])

<div class="col-md-5 {{ $class }}">
    <img src="{{ asset('images/main/' . $src . '.jpg') }}" alt="{{$src}}" class="img-fluid rounded shadow">
</div>
