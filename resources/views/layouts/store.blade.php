<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Store - Premium Timepieces</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @stack('styles')
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8f9fa; color: #212529; }
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
        .premium-bg { background: linear-gradient(135deg, #1f1c2c, #928dab); color: white; }
        .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; border-radius: 12px; overflow: hidden; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .btn-premium { background-color: #212529; color: #fff; border-radius: 30px; padding: 10px 24px; transition: all 0.3s; }
        .btn-premium:hover { background-color: #343a40; color: #fff; transform: scale(1.05); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-uppercase" href="{{ route('home') }}">Watch Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('home') }}">Catalog</a>
                    </li>
                    @auth
                        <li class="nav-item ms-2">
                            <a class="nav-link fw-semibold text-primary" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3 fs-5"></i> Cart
                            </a>
                        </li>
                        @if(auth()->user()->role->slug !== 'admin')
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('customer.orders.index') }}">My Orders</a></li>
                            <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('profile.edit') }}">Profile</a></li>
                        @endif
                        <li class="nav-item ms-2">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-2"><a class="nav-link fw-semibold" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item ms-2"><a class="btn btn-dark rounded-pill px-4 fw-semibold" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Watch Store. All Rights Reserved. Crafted with passion.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
