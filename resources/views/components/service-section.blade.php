@props(['category'])

<div class="service-section">
    <div class="d-flex justify-content-between">
        <span>{{$category->name}}</span>
        <x-index-button url="home" >More <i class='bx bx-right-arrow-alt'></i></x-index-button>
    </div>
</div>
