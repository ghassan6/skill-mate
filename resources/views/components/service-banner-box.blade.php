<div class="banner-box mt-5 mx-3">
    @isset($bold)
    <p><strong class="bold">{{ $bold }}</strong></p>
    @endisset
    {{ $slot }}
</div>