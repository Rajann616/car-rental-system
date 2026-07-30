@extends('layouts.app')

@section('title', 'Set New Password — AutoLux')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-card" data-aos="zoom-in">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text fs-4 fw-bold">Auto<span class="brand-accent">Lux</span></span>
                </a>
                <h1 class="auth-title">Set New Password</h1>
                <p class="auth-subtitle">Please enter your new password below</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group password-input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter new password">
                        <button class="btn toggle-password-btn-inside" type="button" data-target="password" title="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-group password-input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" required placeholder="Confirm new password">
                        <button class="btn toggle-password-btn-inside" type="button" data-target="password_confirmation" title="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-auth">
                    Reset Password <i class="fas fa-key ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
