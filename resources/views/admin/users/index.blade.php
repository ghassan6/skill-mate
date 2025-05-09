<x-admin.layout>
    <x-slot name="title">All Users</x-slot>
    <script src="{{asset('js/admin/user-managment.js')}}" defer></script>
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">
    <x-admin.sidebar>


        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <livewire:admin.users-index />

    </x-admin.sidebar>
</x-admin.layout>
