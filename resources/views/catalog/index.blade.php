@extends('layouts.store')

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="hero-section position-relative overflow-hidden">
    <div class="hero-bg"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="container position-relative z-2 py-6">
        <div class="row align-items-center min-vh-section">
            <div class="col-lg-7 text-white">
                <div class="hero-badge mb-4 d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill">
                    <span class="badge-dot"></span>
                    <span class="small fw-semibold text-uppercase letter-spacing">Premium Collection 2025</span>
                </div>
                <h1 class="hero-headline fw-black mb-4">
                    Discover<br>
                    <span class="text-gradient">Timeless</span><br>
                    Elegance
                </h1>
                <p class="hero-sub mb-5 text-white-70" style="max-width:500px;">
                    From legendary Swiss manufactures to cutting-edge smartwatches — curated for the connoisseur in you.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#catalog" class="btn btn-hero-primary px-5 py-3 fw-bold fs-6">
                        Shop Now <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="#categories" class="btn btn-hero-outline px-5 py-3 fw-bold fs-6">
                        Browse Collections
                    </a>
                </div>

                <div class="hero-stats d-flex gap-5 mt-5 pt-3 border-top border-white-20">
                    <div>
                        <div class="stat-number fw-black">{{ \App\Models\Product::where('is_active',true)->count() }}+</div>
                        <div class="stat-label text-white-60 small">Products</div>
                    </div>
                    <div>
                        <div class="stat-number fw-black">{{ \App\Models\Category::where('is_active',true)->count() }}</div>
                        <div class="stat-label text-white-60 small">Categories</div>
                    </div>
                    <div>
                        <div class="stat-number fw-black">100%</div>
                        <div class="stat-label text-white-60 small">Authentic</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <div class="hero-watch-wrap position-relative">
                    <div class="hero-glow-ring"></div>
                    <div class="hero-watch-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-watch text-white" style="font-size: 8rem; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="container position-relative z-2 pb-5">
        <div class="hero-search-wrap mx-auto">
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group hero-search-group shadow-xl">
                    <span class="input-group-text bg-white border-0 ps-4">
                        <i class="bi bi-search text-muted fs-5"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 py-3 fs-6"
                        placeholder="Search by brand, model, or keyword..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-dark px-4 fw-semibold rounded-end-3">Search</button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ========== CATEGORY TABS ========== --}}
<section id="categories" class="bg-white py-5 border-bottom">
    <div class="container">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="text-muted fw-semibold me-2 small text-uppercase letter-spacing">Filter:</span>
            <a href="{{ route('home') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">
                All Watches
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug, 'search' => request('search')]) }}"
               class="category-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== FEATURED PRODUCTS ========== --}}
@if(!request('search') && !request('category') && $featuredProducts->count())
<section class="featured-section py-6 bg-light">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-eyebrow">Hand-Picked</span>
                <h2 class="section-title fw-black mb-0">Featured <span class="text-gradient-dark">Timepieces</span></h2>
            </div>
            <a href="#catalog" class="btn btn-outline-dark rounded-pill px-4 d-none d-md-inline-flex align-items-center gap-2">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $fp)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('product.show', $fp->slug) }}" class="text-decoration-none">
                    <div class="featured-card h-100">
                        <div class="featured-card-img">
                            @if($fp->primaryImage)
                                <img src="{{ $fp->primaryImage->url }}" alt="{{ $fp->name }}" class="featured-img">
                            @else
                                <div class="no-img-placeholder">
                                    <i class="bi bi-watch"></i>
                                </div>
                            @endif
                            <div class="featured-card-overlay">
                                <span class="btn btn-light btn-sm rounded-pill px-3 fw-semibold">Quick View</span>
                            </div>
                        </div>
                        <div class="featured-card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ $fp->name }}</h6>
                                    <small class="text-muted">{{ $fp->brand }}</small>
                                </div>
                                <span class="price-tag">Rp {{ number_format($fp->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ========== PRODUCT CATALOG ========== --}}
<section id="catalog" class="py-6">
    <div class="container">
        <div class="section-header mb-5">
            <span class="section-eyebrow">Our Collection</span>
            <h2 class="section-title fw-black mb-1">
                @if(request('search'))
                    Results for "{{ request('search') }}"
                @elseif(request('category') && $categories->where('slug', request('category'))->first())
                    {{ $categories->where('slug', request('category'))->first()->name }}
                @else
                    All Watches
                @endif
            </h2>
            <p class="text-muted small">{{ $products->total() }} product(s) found</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @forelse($products as $product)
            <div class="col">
                <div class="product-card h-100">
                    <div class="product-card-img-wrap">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->url }}"
                                 class="product-card-img" alt="{{ $product->name }}">
                        @else
                            <div class="product-no-img">
                                <i class="bi bi-watch"></i>
                            </div>
                        @endif
                        <div class="product-card-badge-wrap">
                            @if($product->stock === 0)
                                <span class="product-badge badge-sold-out">Sold Out</span>
                            @elseif($product->stock <= 5)
                                <span class="product-badge badge-low-stock">Only {{ $product->stock }} left</span>
                            @endif
                        </div>
                        <div class="product-card-hover-overlay">
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-light fw-semibold rounded-pill px-4">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    <div class="product-card-body">
                        <div class="product-meta mb-1">
                            <span class="product-brand">{{ $product->brand }}</span>
                            <span class="product-category">{{ optional($product->category)->name }}</span>
                        </div>
                        <h6 class="product-name fw-bold">{{ $product->name }}</h6>
                        <div class="product-card-footer">
                            <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-product-cta rounded-pill">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state text-center py-6">
                    <div class="empty-icon mb-4">
                        <i class="bi bi-search"></i>
                    </div>
                    <h4 class="fw-bold text-dark">No Products Found</h4>
                    <p class="text-muted">Try adjusting your search or browse a different category.</p>
                    <a href="{{ route('home') }}" class="btn btn-dark rounded-pill px-5 mt-2">View All Products</a>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</section>

{{-- ========== WHY CHOOSE US ========== --}}
<section class="trust-section py-6 bg-dark text-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-eyebrow text-white-50">Why Watch Store</span>
            <h2 class="fw-black">Trusted by Collectors</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3 text-center">
                <div class="trust-icon mb-3"><i class="bi bi-shield-check-fill"></i></div>
                <h6 class="fw-bold">100% Authentic</h6>
                <p class="text-white-50 small">Every watch is guaranteed authentic with original certificates.</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="trust-icon mb-3"><i class="bi bi-box-seam-fill"></i></div>
                <h6 class="fw-bold">Secure Packaging</h6>
                <p class="text-white-50 small">Premium packaging to ensure your watch arrives in perfect condition.</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="trust-icon mb-3"><i class="bi bi-headset"></i></div>
                <h6 class="fw-bold">Expert Support</h6>
                <p class="text-white-50 small">Our watch specialists are ready to help you find the perfect timepiece.</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="trust-icon mb-3"><i class="bi bi-arrow-repeat"></i></div>
                <h6 class="fw-bold">Easy Returns</h6>
                <p class="text-white-50 small">Hassle-free return policy within 7 days of purchase.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ===========================
   HERO SECTION
=========================== */
.hero-section {
    background: linear-gradient(135deg, #0d0d0d 0%, #1a1a2e 40%, #16213e 70%, #0f3460 100%);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 70% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 70%),
        radial-gradient(ellipse at 10% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 60%);
    z-index: 0;
}
.py-6 { padding-top: 5rem !important; padding-bottom: 5rem !important; }
.min-vh-section { min-height: 70vh; }
.z-2 { z-index: 2; }

.hero-badge {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    color: white;
}
.badge-dot {
    width: 8px; height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(1.3); }
}
.letter-spacing { letter-spacing: 1.5px; }
.hero-headline {
    font-size: clamp(2.8rem, 6vw, 5.5rem);
    line-height: 1.05;
    color: white;
}
.text-gradient {
    background: linear-gradient(90deg, #a78bfa, #ec4899, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.text-gradient-dark {
    background: linear-gradient(90deg, #6366f1, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-sub { opacity: 0.75; font-size: 1.1rem; line-height: 1.7; }
.btn-hero-primary {
    background: linear-gradient(135deg, #6366f1, #a78bfa);
    color: white;
    border: none;
    border-radius: 50px;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(99,102,241,0.4);
}
.btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(99,102,241,0.5);
    color: white;
}
.btn-hero-outline {
    background: transparent;
    color: white;
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 50px;
    transition: all 0.3s;
}
.btn-hero-outline:hover {
    background: rgba(255,255,255,0.1);
    color: white;
    border-color: rgba(255,255,255,0.6);
    transform: translateY(-2px);
}
.border-white-20 { border-color: rgba(255,255,255,0.2) !important; }
.text-white-60 { color: rgba(255,255,255,0.6); }
.text-white-70 { color: rgba(255,255,255,0.7); }
.stat-number { font-size: 2rem; color: white; }

/* Hero Watch Visual */
.hero-watch-wrap {
    width: 380px; height: 380px;
}
.hero-glow-ring {
    position: absolute;
    inset: -20px;
    border-radius: 50%;
    border: 1px solid rgba(167,139,250,0.3);
    animation: spin-ring 20s linear infinite;
}
.hero-watch-circle {
    width: 100%; height: 100%;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,0.2), rgba(15,52,96,0.6));
    border: 1px solid rgba(167,139,250,0.2);
}
@keyframes spin-ring {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

/* Hero Search */
.hero-search-wrap { max-width: 640px; }
.hero-search-group {
    border-radius: 50px;
    overflow: hidden;
    background: white;
}
.hero-search-group .form-control:focus { box-shadow: none; }
.shadow-xl { box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important; }

/* ===========================
   CATEGORY PILLS
=========================== */
.category-pill {
    display: inline-flex;
    align-items: center;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    background: #f1f3f5;
    color: #495057;
    text-decoration: none;
    border: 1.5px solid transparent;
    transition: all 0.2s;
}
.category-pill:hover {
    background: #e9ecef;
    color: #212529;
}
.category-pill.active {
    background: #212529;
    color: white;
    border-color: #212529;
}

/* ===========================
   SECTION COMMON
=========================== */
.section-eyebrow {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #6366f1;
    margin-bottom: 0.5rem;
}
.section-title { font-size: clamp(1.8rem, 3vw, 2.5rem); }

/* ===========================
   FEATURED CARDS
=========================== */
.featured-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    transition: all 0.3s;
}
.featured-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}
.featured-card-img {
    position: relative;
    height: 220px;
    background: #f8f9fa;
    overflow: hidden;
}
.featured-img {
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 1rem;
    transition: transform 0.4s;
}
.featured-card:hover .featured-img { transform: scale(1.05); }
.no-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: #adb5bd; font-size: 3rem;
}
.featured-card-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.35);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s;
}
.featured-card:hover .featured-card-overlay { opacity: 1; }
.featured-card-body { border-top: 1px solid #f1f3f5; }
.price-tag {
    font-size: 0.78rem;
    font-weight: 700;
    color: #6366f1;
    white-space: nowrap;
}

/* ===========================
   PRODUCT CARDS
=========================== */
.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}
.product-card-img-wrap {
    position: relative;
    height: 240px;
    background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    overflow: hidden;
}
.product-card-img {
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 1.2rem;
    transition: transform 0.4s;
}
.product-card:hover .product-card-img { transform: scale(1.06); }
.product-no-img {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 4rem; color: #ced4da;
}
.product-card-badge-wrap {
    position: absolute;
    top: 12px; left: 12px;
}
.product-badge {
    font-size: 0.72rem; font-weight: 700;
    padding: 4px 10px; border-radius: 20px;
}
.badge-sold-out  { background: #dc3545; color: white; }
.badge-low-stock { background: #fd7e14; color: white; }
.product-card-hover-overlay {
    position: absolute; inset: 0;
    background: rgba(13,13,13,0.45);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s;
}
.product-card:hover .product-card-hover-overlay { opacity: 1; }

.product-card-body {
    padding: 1rem 1.2rem 1.2rem;
}
.product-meta {
    display: flex; gap: 8px; align-items: center;
}
.product-brand {
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: #6366f1;
}
.product-category {
    font-size: 0.72rem; color: #adb5bd;
}
.product-name {
    font-size: 0.95rem;
    color: #212529;
    margin-bottom: 0.8rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f1f3f5;
    padding-top: 0.8rem;
}
.product-price {
    font-size: 0.9rem;
    font-weight: 800;
    color: #212529;
}
.btn-product-cta {
    font-size: 0.78rem;
    font-weight: 700;
    padding: 5px 14px;
    background: #212529;
    color: white;
    border: none;
    transition: all 0.2s;
}
.btn-product-cta:hover {
    background: #6366f1;
    color: white;
    transform: scale(1.05);
}

/* ===========================
   EMPTY STATE
=========================== */
.empty-state { max-width: 400px; margin: 0 auto; }
.empty-icon {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: #f1f3f5;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: #adb5bd;
}
.py-6 { padding-top: 5rem !important; padding-bottom: 5rem !important; }

/* ===========================
   TRUST SECTION
=========================== */
.trust-section { background: linear-gradient(135deg, #0d0d0d, #1a1a2e); }
.trust-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: rgba(99,102,241,0.15);
    border: 1px solid rgba(99,102,241,0.25);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1.6rem; color: #a78bfa;
}
</style>
@endpush
