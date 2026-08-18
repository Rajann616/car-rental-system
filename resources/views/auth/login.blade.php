@extends('layouts.app')

@section('title', 'Sign In — AutoLux')

@section('content')
<div class="simple-auth-page">
    
    <!-- Minimal Top Bar (No Header Clutter) -->
    <div class="simple-auth-topbar">
        <a href="{{ route('home') }}" class="simple-brand-logo">
            <i class="fas fa-car-side" style="color: #FF7A00;"></i> Auto<span style="color: #FF7A00;">Lux</span>
        </a>
        <a href="{{ route('register') }}" class="text-dark fw-bold small text-decoration-none">
            New here? <span class="text-primary">Get Started →</span>
        </a>
    </div>

    <div class="simple-auth-container">
        <div class="simple-auth-card" data-aos="fade-up" data-aos-duration="500">
            <!-- Clean Form Area -->
            <div class="simple-form-area">
                
                <div class="mb-4">
                    <h2 class="simple-form-title">Welcome back 👋</h2>
                    <p class="simple-form-subtitle">Good to see you again.</p>
                </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="simple-field-group">
                            <label for="email" class="simple-field-label">Email</label>
                            <div class="simple-input-box">
                                <i class="fas fa-envelope simple-input-icon"></i>
                                <input type="email" class="simple-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="simple-field-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="simple-field-label mb-0">Password</label>
                                <a href="{{ route('password.request') }}" class="text-primary small text-decoration-none fw-semibold">Forgot?</a>
                            </div>
                            <div class="simple-input-box">
                                <i class="fas fa-lock simple-input-icon"></i>
                                <input type="password" class="simple-input @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••••••">
                                <button type="button" class="simple-eye-btn toggle-password-btn" data-target="password" title="Toggle Password" aria-label="Toggle password visibility">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small text-muted fw-medium" for="remember">Remember me</label>
                            </div>
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit" class="btn-simple-orange">
                            <span>Sign In</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">
                                New to AutoLux? 
                                <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none ms-1">Create an account</a>
                            </p>
                        </div>
                </div>
        </div>
    </div>

    <!-- Minimal Page Footer -->
    <div class="text-center text-muted small mt-4" style="font-size: 0.8rem;">
        © {{ date('Y') }} AutoLux Car Rental. All rights reserved.
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.toggle-password-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
});
</script>
@endpush
@endsection
