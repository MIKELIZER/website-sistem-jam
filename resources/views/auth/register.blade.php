<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account – Watch Store</title>
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
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(167,139,250,0.12), transparent 70%);
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
            max-width: 480px;
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
            margin-bottom: 1.8rem;
        }
        .auth-title { font-size: 1.9rem; font-weight: 800; color: white; }
        .auth-subtitle { color: rgba(255,255,255,0.55); font-size: 0.9rem; }
        .form-label { color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; }
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
        .input-icon-wrap { position: relative; }
        .input-icon {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 1rem;
            pointer-events: none;
        }
        .btn-register {
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            color: white; border: none;
            border-radius: 12px; padding: 13px;
            font-weight: 700; font-size: 1rem;
            width: 100%; transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99,102,241,0.55);
            color: white;
        }
        .auth-link { color: #a78bfa; text-decoration: none; font-weight: 600; }
        .auth-link:hover { color: #c4b5fd; }
        .password-hint { color: rgba(255,255,255,0.35); font-size: 0.78rem; margin-top: 4px; }
        .divider {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.25); font-size: 0.82rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: rgba(255,255,255,0.1);
        }
        .terms-text { color: rgba(255,255,255,0.45); font-size: 0.8rem; text-align: center; line-height: 1.5; }
        .terms-text a { color: #a78bfa; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="auth-card">

        <a href="{{ route('home') }}" class="brand-logo">
            <i class="bi bi-watch me-1"></i> Watch Store
        </a>

        <h1 class="auth-title mb-1">Create account</h1>
        <p class="auth-subtitle mb-4">Join thousands of watch enthusiasts</p>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <div class="input-icon-wrap">
                    <input id="name" type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus
                           placeholder="John Doe">
                    <i class="bi bi-person input-icon"></i>
                </div>
                @error('name')
                    <div style="color:#fca5a5; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <div class="input-icon-wrap">
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required
                           placeholder="you@email.com">
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div style="color:#fca5a5; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required placeholder="Min. 8 characters">
                    <i class="bi bi-lock input-icon"></i>
                </div>
                @error('password')
                    <div style="color:#fca5a5; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                @enderror
                <div class="password-hint">Use at least 8 characters with a mix of letters and numbers.</div>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-icon-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control" required placeholder="Repeat your password">
                    <i class="bi bi-shield-check input-icon"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-register mb-4">
                Create Account <i class="bi bi-arrow-right ms-1"></i>
            </button>

            <div class="divider mb-4">or</div>

            <p class="text-center mb-4" style="color: rgba(255,255,255,0.55); font-size:0.9rem;">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </p>

            <p class="terms-text">
                By creating an account, you agree to our
                <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </p>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
