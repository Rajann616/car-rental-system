@extends('layouts.app')

@section('title', 'Create Account — AutoLux')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-card" data-aos="zoom-in">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text fs-4 fw-bold">Auto<span class="brand-accent">Lux</span></span>
                </a>
                <h1 class="auth-title">Join AutoLux</h1>
                <p class="auth-subtitle">Create an account to start booking luxury vehicles</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter email address">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Enter phone number">
                    </div>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group password-input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter password (min. 8 characters)">
                        <button class="btn toggle-password-btn-inside" type="button" data-target="password" title="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group password-input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        <button class="btn toggle-password-btn-inside" type="button" data-target="password_confirmation" title="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth">
                    Create Account <i class="fas fa-user-plus ms-2"></i>
                </button>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
