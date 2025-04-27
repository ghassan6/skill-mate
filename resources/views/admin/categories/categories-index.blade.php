<x-admin.layout>
    <x-slot:title>All Categories</x-slot:title>
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">
    <script src="{{asset('js/admin/categories-managment.js')}}" defer></script>
    <x-admin.sidebar>
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <livewire:admin.categories-index/>
    </x-admin.sidebar>
</x-admin.layout>
