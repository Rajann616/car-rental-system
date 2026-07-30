@extends('layouts.app')

@section('title', 'Sign In — AutoLux')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-card" data-aos="zoom-in">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text fs-4 fw-bold">Auto<span class="brand-accent">Lux</span></span>
                </a>
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to manage your bookings and rentals</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter email address">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                        <a href="{{ route('password.request') }}" class="text-primary small">Forgot password?</a>
                    </div>
                    <div class="input-group password-input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
                        <button class="btn toggle-password-btn-inside" type="button" data-target="password" title="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Remember me on this device</label>
                </div>

                <button type="submit" class="btn btn-auth">
                    Sign In <i class="fas fa-arrow-right ms-2"></i>
                </button>

                <div class="auth-divider">
                    <span>Demo Accounts</span>
                </div>

                <div class="p-3 bg-light rounded-3 small">
                    <div class="mb-1"><strong>Customer:</strong> rajesh.patel@gmail.com / password123</div>
                    <div><strong>Admin:</strong> admin@AutoLux.in / admin123</div>
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-semibold">Create Account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
