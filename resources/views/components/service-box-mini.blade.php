@props(['img' => "", 'title' => ""])

<a class="service-box-mini" href="/">
    <div class="image-wrapper">
        <img src="{{ asset("$img") }}" alt="{{ $title }}">
        <div class="overlay">
            <span class="title">{{ $title }}</span>
        </div>
    </div>
</a>
