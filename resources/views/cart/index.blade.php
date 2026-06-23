@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100">
    <h2 class="mb-4 fw-bold">Your Shopping Cart</h2>

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

    @if($items->count() > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($items as $item)
                                @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($item->product->primaryImage)
                                                <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="rounded bg-light p-1" style="width: 60px; height: 60px; object-fit: contain;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="ms-3">
                                                <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none text-dark">
                                                    <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                                </a>
                                                <small class="text-muted">{{ $item->product->brand }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm text-center me-2" style="width: 60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-clockwise"></i></button>
                                        </form>
                                    </td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-end">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove item?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Shipping (Flat Rate)</span>
                        <span class="fw-bold">Rp 20.000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-primary">Rp {{ number_format($total + 20000, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-premium w-100 btn-lg rounded-pill shadow-sm"><i class="bi bi-credit-card me-2"></i>Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5 bg-white rounded-4 shadow-sm border mt-4">
        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
        <h3>Your cart is empty</h3>
        <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('home') }}" class="btn btn-premium px-4 rounded-pill">Continue Shopping</a>
    </div>
    @endif
</div>
@endsection
