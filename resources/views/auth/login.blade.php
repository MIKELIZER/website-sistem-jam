<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Watch Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * { font-family: 'Outfit', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1a2e 45%, #0f3460 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        /* Decorative background blobs */
        body::before {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15), transparent 70%);
            top: -100px; right: -100px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(236,72,153,0.1), transparent 70%);
            bottom: -80px; left: -80px;
            pointer-events: none;
        }
        .auth-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }
        .brand-logo {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem;
        }
        .auth-title { font-size: 1.9rem; font-weight: 800; color: white; }
        .auth-subtitle { color: rgba(255,255,255,0.55); font-size: 0.9rem; }
        .form-label { color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; }
        .form-control {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: white;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.25s;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1);
            border-color: rgba(99,102,241,0.7);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            color: white;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: 0.8rem; }
        .input-icon-wrap { position: relative; }
        .input-icon {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 1rem;
            pointer-events: none;
        }
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99,102,241,0.55);
            color: white;
        }
        .divider {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.25); font-size: 0.82rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: rgba(255,255,255,0.1);
        }
        .auth-link { color: #a78bfa; text-decoration: none; font-weight: 600; }
        .auth-link:hover { color: #c4b5fd; }
        .check-label { color: rgba(255,255,255,0.65); font-size: 0.88rem; }
        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .alert-auth {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5; border-radius: 10px;
            font-size: 0.88rem; padding: 10px 14px;
        }
        .demo-box {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
        }
        .demo-box strong { color: rgba(255,255,255,0.9); }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="auth-card">

        <a href="{{ route('home') }}" class="brand-logo">
            <i class="bi bi-watch me-1"></i> Watch Store
        </a>

        <h1 class="auth-title mb-1">Welcome back</h1>
        <p class="auth-subtitle mb-4">Sign in to your account to continue shopping</p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert-auth mb-3">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <div class="input-icon-wrap">
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus
                           placeholder="you@email.com">
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block" style="color:#fca5a5;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required placeholder="••••••••">
                    <i class="bi bi-lock input-icon"></i>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block" style="color:#fca5a5;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label check-label" for="remember_me">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.85rem;">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-login mb-4">
                Sign In <i class="bi bi-arrow-right ms-1"></i>
            </button>

            <div class="divider mb-4">or</div>

            <p class="text-center mb-4" style="color: rgba(255,255,255,0.55); font-size:0.9rem;">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">Create one free</a>
            </p>

            {{-- Demo Credentials --}}
            <div class="demo-box">
                <div class="mb-1"><strong>Demo – Customer:</strong><br>customer@watchstore.com / password</div>
                <div><strong>Demo – Admin:</strong><br>admin@watchstore.com / password</div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
