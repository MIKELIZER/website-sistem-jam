@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order Management</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Grand Total</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ optional($order->user)->name }}</td>
                    <td>
                        @if($order->status == 'pending_shipping_cost')
                            <span class="badge bg-warning text-dark">Need Shipping Cost</span>
                        @elseif($order->status == 'pending_payment')
                            <span class="badge bg-info">Awaiting Payment</span>
                        @elseif($order->status == 'pending_verification')
                            <span class="badge bg-info text-dark">Verify Payment</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-primary">Processing</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-info">Shipped</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
