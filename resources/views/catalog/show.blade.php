@extends('layouts.store')

@section('content')
<div class="container py-5 min-vh-100">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home', ['search' => optional($product->category)->name]) }}" class="text-decoration-none text-muted">{{ optional($product->category)->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-center bg-white p-4 p-md-5 rounded-4 shadow-sm">
        <div class="col-md-6 text-center">
            @if($product->primaryImage)
                <img src="{{ $product->primaryImage->url }}" class="img-fluid rounded-4" alt="{{ $product->name }}" style="max-height: 500px; object-fit: contain;">
            @else
                <div class="bg-light d-flex justify-content-center align-items-center rounded-4 w-100" style="height: 400px;">
                    <span class="text-muted fs-4"><i class="bi bi-image display-1"></i></span>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <span class="badge bg-dark text-uppercase mb-3 px-3 py-2 rounded-pill shadow-sm">{{ $product->brand }}</span>
            <h1 class="display-5 fw-bold mb-3 text-dark">{{ $product->name }}</h1>
            <h3 class="fw-bold text-primary mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
            <p class="lead text-secondary mb-4">{{ $product->description }}</p>
            
            <div class="mb-4 bg-light p-3 rounded-3 border">
                @if($product->stock > 0)
                    <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-2"></i>In Stock ({{ $product->stock }} available)</span>
                @else
                    <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-2"></i>Out of Stock</span>
                @endif
            </div>

            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center bg-light p-3 rounded-4 shadow-sm border">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label for="quantity" class="fw-bold me-3">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control form-control-lg me-3 text-center border-0 shadow-sm" style="width: 100px; border-radius: 12px;">
                    <button type="submit" class="btn btn-premium btn-lg w-100 shadow-sm"><i class="bi bi-cart-plus me-2"></i>Add to Cart</button>
                </form>
            @else
                <button class="btn btn-secondary btn-lg w-100 rounded-pill py-3" disabled><i class="bi bi-cart-x me-2"></i>Out of Stock</button>
            @endif
        </div>
    </div>
</div>
@endsection
