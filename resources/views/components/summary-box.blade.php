@props(['table' => ''])

<?php use Illuminate\Support\Facades\Auth; ?>
{{-- @php $data = Auth::user()->{$table}->where('user_id', Auth::user()->id)->count(); @endphp --}}
@php 
if($table == 'reviews') {
    $servicesIDs = Auth::user()->services()->pluck('id');

    $data = \App\Models\Review::whereIn('service_id', $servicesIDs)->count('rating');

}
else $data = Auth::user()->{$table}->where('user_id', Auth::user()->id)->count(); 

@endphp


<div class="box border border-1 border-dark rounded-3 p-3 d-flex flex-column justify-content-center align-items-center">
    <p>{{$data}}</p>
    <p>Total {{Str::ucfirst($table == 'reviews'? 'Ratings' : $table) }}</p>
</div>
