@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100">
    <h2 class="mb-4 fw-bold">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Shipping Details</h5>
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="recipient_name" class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" id="recipient_name" class="form-control" value="{{ old('recipient_name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="recipient_phone" class="form-label">Phone Number</label>
                                <input type="text" name="recipient_phone" id="recipient_phone" class="form-control" value="{{ old('recipient_phone', $user->phone) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Full Shipping Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control" required>{{ old('shipping_address', $user->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    <ul class="list-group list-group-flush mb-4">
                        @php $subtotal = 0; @endphp
                        @foreach($cart->items as $item)
                            @php $itemTotal = $item->product->price * $item->quantity; $subtotal += $itemTotal; @endphp
                            <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                                <div>
                                    <h6 class="my-0">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->quantity }}x @ Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="text-muted">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Shipping (Flat Rate)</span>
                        <span class="fw-bold">Rp 20.000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-primary">Rp {{ number_format($subtotal + 20000, 0, ',', '.') }}</span>
                    </div>
                    
                    <button type="button" class="btn btn-premium w-100 btn-lg rounded-pill shadow-sm" onclick="document.getElementById('checkout-form').submit();">
                        <i class="bi bi-check2-circle me-2"></i>Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
