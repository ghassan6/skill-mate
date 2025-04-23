<x-layout>
    <x-slot:title>Payment - Promote Your Service</x-slot>
    <link rel="stylesheet" href="{{asset('css/payment.css')}}">
    <script src="{{asset('js/payment.js')}}" defer></script>
    <x-user-sidebar>
        <div class="container py-5" style="max-width: 800px;">
            <!-- Payment Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">
                    <i class="fas fa-credit-card text-primary me-2"></i> Payment Details
                </h2>
                <p class="text-muted">Complete your service promotion payment</p>

                <!-- Promotion Summary -->
                <div class="card border-0 bg-light shadow-sm mb-4">
                    <div class="card-body text-center py-3">
                        <h4 class="mb-2">Promoting: <strong>{{ $service->title }}</strong></h4>
                        <div class="d-flex justify-content-center gap-4">
                            <div>
                                <small class="text-muted">Duration</small>
                                <h5 class="mb-0 text-warning">{{ $days }} Days</h5>
                            </div>
                            <div>
                                <small class="text-muted">Total</small>
                                <h5 class="mb-0 text-success">{{ $amount }} JOD</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form id="paymentForm" method="POST" action="{{ route('services.promote', $service->slug) }}">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="days" value="{{ $days }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">

                        <!-- Card Details -->
                        <div class="mb-4">
                            <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                    <i class="fas fa-credit-card text-primary"></i>
                                </span>
                                Card Information
                            </h5>

                            <div class="row g-3">
                                <!-- Card Number -->
                                <div class="col-12">
                                    <label for="cardNumber" class="form-label fw-medium">Card Number*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               id="cardNumber" name="card_number"
                                               placeholder="1234 5678 9012 3456" required>
                                        <span class="input-group-text">
                                            <div class="card-icons">
                                                <i class="fab fa-cc-visa mx-1 text-primary"></i>
                                                <i class="fab fa-cc-mastercard mx-1 text-danger"></i>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Holder -->
                                <div class="col-md-6">
                                    <label for="cardName" class="form-label fw-medium">Card Holder Name*</label>
                                    <input type="text" class="form-control"
                                           id="cardName" name="card_name"
                                           placeholder="John Smith" required>
                                </div>

                                <!-- Expiry & CVV -->
                                <div class="col-md-3">
                                    <label for="cardExpiry" class="form-label fw-medium">Expiry Date*</label>
                                    <input type="text" class="form-control"
                                           id="cardExpiry" name="card_expiry"
                                           placeholder="MM/YY" required>
                                           <p class="text-danger err" id="expiry-error"></p>
                                </div>

                                <div class="col-md-3">
                                    <label for="cardCvv" class="form-label fw-medium">CVV*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               id="cardCvv" name="card_cvv"
                                               placeholder="123" required>
                                        <span class="input-group-text">
                                            <i class="fas fa-question-circle"
                                               data-bs-toggle="tooltip"
                                               title="3-digit code on back of card"></i>
                                        </span>
                                    </div>
                                    <p class="text-danger err" id="cvv-error"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="mb-4">
                            <h5 class="mb-3 pb-2 border-bottom d-flex align-items-center">
                                <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </span>
                                Billing Address
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="billingAddress" class="form-label fw-medium">Address*</label>
                                    <input type="text" class="form-control"
                                           id="billingAddress" name="billing_address" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="billingCity" class="form-label fw-medium">City*</label>
                                    <input type="text" class="form-control"
                                           id="billingCity" name="billing_city" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="billingZip" class="form-label fw-medium">ZIP Code*</label>
                                    <input type="text" class="form-control"
                                           id="billingZip" name="billing_zip" required>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                <i class="fas fa-lock me-2"></i> Pay {{ $amount }} JOD
                            </button>
                        </div>

                        <!-- Security Info -->
                        <div class="text-center mt-4">
                            <p class="small text-muted">
                                <i class="fas fa-lock text-success me-2"></i>
                                Your payment is secured with 256-bit SSL encryption
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <img src="{{ asset('images/main/visa.jpg') }}" alt="Visa" style="height: 25px;">
                                <img src="{{ asset('images/main/master.jpg') }}" alt="Mastercard" style="height: 25px;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </x-user-sidebar>
</x-layout>
