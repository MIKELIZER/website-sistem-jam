@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Orders</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-pill px-4">Continue Shopping</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0 table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Order ID</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4 py-3 fw-bold">{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending Payment</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info px-3 py-2 rounded-pill">Processing</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Shipped</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
                    <h4>No orders found</h4>
                    <p class="text-muted">You haven't placed any orders yet.</p>
                </div>
            @endif
        </div>
    </div>
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
