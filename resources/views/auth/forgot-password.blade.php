@extends('layouts.app')

@section('title', 'Forgot Password — DriveEase')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-card" data-aos="zoom-in">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text fs-4 fw-bold">Drive<span class="brand-accent">Ease</span></span>
                </a>
                <h1 class="auth-title">Reset Password</h1>
                <p class="auth-subtitle">Enter your email and we'll send you a password reset link</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success small mb-4" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-auth">
                    Send Reset Link <i class="fas fa-paper-plane ms-2"></i>
                </button>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Remembered password? <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
