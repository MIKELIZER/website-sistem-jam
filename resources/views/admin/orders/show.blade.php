@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order Details: {{ $order->order_number }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Items Ordered</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->product_name_snapshot }}
                                @if(!$item->product) <span class="badge bg-danger ms-2">Deleted</span> @endif
                            </td>
                            <td>Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($order->status === 'pending_shipping_cost')
        <div class="card shadow-sm border-0 mb-4 border-warning">
            <div class="card-header bg-warning text-dark fw-bold">Action Required: Set Shipping Cost</div>
            <div class="card-body">
                <p>The customer has placed the order. Please determine the shipping cost so they can proceed to payment.</p>
                <form action="{{ route('admin.orders.update-shipping', $order->id) }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <div class="input-group me-3" style="max-width: 300px;">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="shipping_cost" class="form-control" required min="0" placeholder="Enter shipping cost">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Shipping Cost</button>
                </form>
            </div>
        </div>
        @endif

        @if($order->status === 'pending_verification' && $order->payment)
        <div class="card shadow-sm border-0 mb-4 border-info">
            <div class="card-header bg-info text-white fw-bold">Action Required: Verify Payment</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Method:</strong> {{ $order->payment->payment_method }}</p>
                        <p class="mb-1"><strong>Amount:</strong> Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        <p class="mb-3"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->payment->payment_date)->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ Storage::url($order->payment->proof_of_payment) }}" target="_blank">
                            <img src="{{ Storage::url($order->payment->proof_of_payment) }}" alt="Proof" class="img-thumbnail" style="max-height: 150px;">
                        </a>
                    </div>
                </div>
                <hr>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Approve payment?')">Approve Payment</button>
                    </form>
                    <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Reject payment?')">Reject Payment</button>
                    </form>
                </div>
            </div>
        </div>
        @elseif($order->payment)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Payment Info</div>
            <div class="card-body">
                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-secondary">{{ $order->payment->status }}</span></p>
                <p class="mb-1"><strong>Method:</strong> {{ $order->payment->payment_method }}</p>
                <p class="mb-0"><strong>Proof:</strong> <a href="{{ Storage::url($order->payment->proof_of_payment) }}" target="_blank">View Image</a></p>
            </div>
        </div>
        @endif

        @if(in_array($order->status, ['processing', 'shipped']))
        <div class="card shadow-sm border-0 mb-4 border-primary">
            <div class="card-header bg-primary text-white fw-bold">Update Status</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <select name="status" class="form-select me-3" style="max-width: 250px;" required>
                        <option value="">Select Status</option>
                        @if($order->status === 'processing')
                            <option value="shipped">Shipped</option>
                        @endif
                        @if($order->status === 'shipped')
                            <option value="completed">Completed</option>
                        @endif
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Tracking Logs</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($order->trackingLogs->sortByDesc('created_at') as $log)
                    <li class="list-group-item p-3">
                        <strong>{{ $log->title }}</strong> <span class="badge bg-secondary ms-2">{{ $log->status }}</span><br>
                        <small class="text-muted">{{ $log->created_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 mt-1">{{ $log->description }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">Order Summary</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status</span>
                    <span class="fw-bold text-uppercase">{{ $order->status }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Order Date</span>
                    <span class="fw-bold">{{ $order->created_at->format('d M Y') }}</span>
                </div>
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
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">Shipping Details</div>
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
@endsection
