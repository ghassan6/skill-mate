<div>
    @php
        $fullPath = explode('/' , request()->path());
    @endphp

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb ">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          @foreach ($fullPath as $path )
            @if(request()->is($path))
            <li class="breadcrumb-item active" aria-current="page">{{$path}}</li>
            @else
            <li class="breadcrumb-item"><a href="{{route($path)}}">$path</a></li>
            @endif
          @endforeach
        </ol>
      </nav>
</div>
