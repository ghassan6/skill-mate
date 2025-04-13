@props(['img' => "", 'title' => "" , 'category' => ''])

<a class="category-box-mini" href="{{route('category.services' , $category->slug)}}">
    <div class="image-wrapper">
        <img src="{{ asset("$img") }}" alt="{{ $title }}">
        <div class="overlay">
            <span class="title">{{ $title }}</span>
        </div>
    </div>
</a>
