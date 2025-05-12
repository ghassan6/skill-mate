@props(['table' => ''])

<?php use Illuminate\Support\Facades\Auth; ?>
@php
if($table == 'reviews') {
    $servicesIDs = Auth::user()->services()->pluck('id');
    $data = \App\Models\Review::whereIn('service_id', $servicesIDs)->count('rating');
}
    elseif ($table == 'remaining listing') {
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
                @if($table == 'remaining listing')
                    <button class="btn btn-primary btn-lg px-4 py-2 fw-bold mt-3" data-bs-toggle="modal" data-bs-target="#increaseLimitModal">
                        <i class="fas fa-plus-circle me-2"></i> Increase Listing Limit
                    </button>
                @endif
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


<div class="modal fade" id="increaseLimitModal" tabindex="-1" aria-labelledby="increaseLimitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="increaseLimitModalLabel">
                    <i class="fas fa-chart-line me-2"></i> Increase Your Listing Limit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Get more visibility by increasing your active service listings. Choose your package:</p>

                <div class="row g-3">
                    <!-- 1 Service Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">+1 Service</h5>
                                <h3 class="text-primary">1.5 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> 1 Additional slot</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Permanent upgrade</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Immediate activation</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-primary w-100" onclick="selectLimitPackage(1, 1.5)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 5 Services Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-primary bg-primary bg-opacity-10">
                            <div class="card-body text-center">
                                <h5 class="card-title">+5 Services</h5>
                                <h3 class="text-primary">6 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> 5 Additional slots</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Permanent upgrade</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Immediate activation</li>
                                    <li class="text-primary fw-bold"><i class="fas fa-star me-2"></i>Best value (20% off)</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-primary w-100" onclick="selectLimitPackage(5, 6)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 10 Services Option -->
                    <div class="col-md-4">
                        <div class="card pricing-card h-100 border-2 border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">+10 Services</h5>
                                <h3 class="text-primary">10 JOD</h3>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <li><i class="fas fa-check text-success me-2"></i> 10 Additional slots</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Permanent upgrade</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Immediate activation</li>
                                    <li><i class="fas fa-check text-success me-2"></i> Priority support</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <button class="btn btn-outline-primary w-100" onclick="selectLimitPackage(10, 10)">
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="limitIncreaseForm" action="{{ route('listing-limit.increase', Auth::user()) }}">
                    @csrf
                    <input type="hidden" name="additional_slots" id="additionalSlots">
                    <input type="hidden" name="amount" id="limitIncreaseAmount">
                    <button type="submit" class="btn btn-success" id="proceedToLimitPayment" disabled>
                        <i class="fas fa-credit-card me-2"></i> Proceed to Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
