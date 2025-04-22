@props(['table' => ''])

<?php use Illuminate\Support\Facades\Auth; ?>
@php
if($table == 'reviews') {
    $servicesIDs = Auth::user()->services()->pluck('id');
    $data = \App\Models\Review::whereIn('service_id', $servicesIDs)->count('rating');
}
    elseif ($table == 'remaining lsiting') {
        $data = Auth::user()->listing_limit;
    }
else {
    $data = Auth::user()->{$table}->where('user_id', Auth::user()->id)->count();
}

// Custom icons for each box
$icons = [
    'reviews' => 'fas fa-star',
    'services' => 'fas fa-briefcase',
    'proposals' => 'fas fa-file-contract'
];
@endphp

<div class="card summary-card h-100 border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="card-subtitle mb-2 text-muted text-uppercase small">{{Str::ucfirst($table == 'reviews'? 'Ratings' : $table) }}</h6>
                <h3 class="card-title mb-0">{{$data}}</h3>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                <i class="{{$icons[$table] ?? 'fas fa-chart-line'}} fs-5"></i>
            </div>
        </div>
        @if($table == 'services')
        <div class="mt-3 pt-3 border-top">
            <small class="text-muted">Completed: {{Auth::user()->completedServices()->count()}}</small>
        </div>
        @endif
    </div>
</div>
