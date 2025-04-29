<x-admin.layout>
    <x-slot:title>Service Reports</x-slot:title>
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}">
    <script src="{{asset('js/admin/report-management.js')}}" defer></script>
    <x-admin.sidebar>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <livewire:admin.services-reports />
    </x-admin.sidebar>
</x-admin.layout>
