@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm border-0 rounded-4 w-100" style="max-width: 600px;">
        <div class="card-header bg-white p-4 border-bottom text-center">
            <h4 class="fw-bold mb-0">Upload Payment Proof</h4>
            <p class="text-muted small mt-1 mb-0">Order: {{ $order->order_number }}</p>
        </div>
        <div class="card-body p-4 p-md-5">
            <div class="alert alert-info border-0 rounded-3 mb-4">
                <i class="bi bi-info-circle-fill me-2"></i> Please transfer <strong>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong> to our bank account before uploading the proof.
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('customer.payments.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="payment_method" class="form-label fw-bold">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select form-select-lg @error('payment_method') is-invalid @enderror" required>
                        <option value="">Select Payment Method</option>
                        <option value="BCA Transfer" {{ old('payment_method') == 'BCA Transfer' ? 'selected' : '' }}>BCA Transfer (Rek: 123456789)</option>
                        <option value="Mandiri Transfer" {{ old('payment_method') == 'Mandiri Transfer' ? 'selected' : '' }}>Mandiri Transfer (Rek: 987654321)</option>
                        <option value="Gopay" {{ old('payment_method') == 'Gopay' ? 'selected' : '' }}>Gopay (08123456789)</option>
                    </select>
                    @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="proof_of_payment" class="form-label fw-bold">Upload Image (JPG/PNG, Max 2MB)</label>
                    <input type="file" name="proof_of_payment" id="proof_of_payment" class="form-control form-control-lg @error('proof_of_payment') is-invalid @enderror" accept="image/jpeg,image/png" required>
                    @error('proof_of_payment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-premium btn-lg rounded-pill shadow-sm">Submit Payment</button>
                    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-light btn-lg rounded-pill">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
