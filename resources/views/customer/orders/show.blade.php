@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Order Details: {{ $order->order_number }}</h2>
        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Orders</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-box me-2"></i> Items Ordered
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div class="d-flex align-items-center">
                                @if(optional($item->product)->primaryImage)
                                    <img src="{{ $item->product->primaryImage->url }}" alt="product" class="rounded" style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-bold">{{ $item->product_name_snapshot }}</h6>
                                    <small class="text-muted">Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }} x {{ $item->quantity }}</small>
                                </div>
                            </div>
                            <span class="fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-truck me-2"></i> Tracking History
                </div>
                <div class="card-body">
                    @if($order->trackingLogs->count() > 0)
                        <div class="timeline position-relative ps-4 border-start border-2 border-primary ms-2">
                            @foreach($order->trackingLogs->sortByDesc('created_at') as $log)
                                <div class="mb-4 position-relative">
                                    <span class="position-absolute top-0 start-0 translate-middle p-2 bg-primary border border-light rounded-circle" style="left: -17px !important;"></span>
                                    <h6 class="fw-bold mb-1">{{ $log->title }} <span class="badge bg-secondary ms-2">{{ $log->status }}</span></h6>
                                    <p class="text-muted small mb-1">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                    <p class="mb-0">{{ $log->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No tracking information available yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-receipt me-2"></i> Order Summary
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        <span class="fw-bold text-uppercase">{{ $order->status }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Order Date</span>
                        <span class="fw-bold">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="fs-5 fw-bold">Grand Total</span>
                        <span class="fs-5 fw-bold text-primary">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>

                    @if($order->status === 'pending_payment')
                        <a href="{{ route('customer.payments.create', $order->id) }}" class="btn btn-premium w-100 mt-4 rounded-pill">Upload Payment Proof</a>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 fw-bold">
                    <i class="bi bi-geo-alt me-2"></i> Shipping Info
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-1">{{ $order->recipient_name }}</h6>
                    <p class="text-muted mb-2">{{ $order->recipient_phone }}</p>
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                    @if($order->notes)
                        <hr>
                        <h6 class="fw-bold mb-1">Notes:</h6>
                        <p class="mb-0 text-muted fst-italic">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
