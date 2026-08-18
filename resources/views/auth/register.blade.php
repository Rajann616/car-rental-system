@extends('layouts.app')

@section('title', 'Create Account — AutoLux')

@section('content')
<div class="simple-auth-page">
    
    <!-- Minimal Top Bar (No Header Clutter) -->
    <div class="simple-auth-topbar">
        <a href="{{ route('home') }}" class="simple-brand-logo">
            <i class="fas fa-car-side" style="color: #FF7A00;"></i> Auto<span style="color: #FF7A00;">Lux</span>
        </a>
        <a href="{{ route('login') }}" class="text-dark fw-bold small text-decoration-none">
            Already registered? <span class="text-primary">Sign In →</span>
        </a>
    </div>

    <div class="simple-auth-container">
        <div class="simple-auth-card" data-aos="fade-up" data-aos-duration="500">
            <!-- Clean Form Area -->
            <div class="simple-form-area">

                <div class="mb-4">
                    <h2 class="simple-form-title">Create account ✨</h2>
                    <p class="simple-form-subtitle">Get started in less than 2 minutes.</p>
                </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Full Name Input -->
                        <div class="simple-field-group">
                            <label for="name" class="simple-field-label">Full Name</label>
                            <div class="simple-input-box">
                                <i class="fas fa-user simple-input-icon"></i>
                                <input type="text" class="simple-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Rai Rajan">
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address Input -->
                        <div class="simple-field-group">
                            <label for="email" class="simple-field-label">Email</label>
                            <div class="simple-input-box">
                                <i class="fas fa-envelope simple-input-icon"></i>
                                <input type="email" class="simple-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number Input -->
                        <div class="simple-field-group">
                            <label for="phone" class="simple-field-label">Phone Number</label>
                            <div class="simple-input-box">
                                <i class="fas fa-phone simple-input-icon"></i>
                                <input type="text" class="simple-input @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="9876543210">
                            </div>
                            @error('phone')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="simple-field-group">
                            <label for="password" class="simple-field-label">Password</label>
                            <div class="simple-input-box">
                                <i class="fas fa-lock simple-input-icon"></i>
                                <input type="password" class="simple-input @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Min. 8 characters">
                                <button type="button" class="simple-eye-btn toggle-password-btn" data-target="password" title="Toggle Password" aria-label="Toggle password visibility">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1.5 fw-semibold d-flex align-items-center"><i class="fas fa-circle-exclamation me-1.5"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="simple-field-group mb-4">
                            <label for="password_confirmation" class="simple-field-label">Confirm Password</label>
                            <div class="simple-input-box">
                                <i class="fas fa-lock simple-input-icon"></i>
                                <input type="password" class="simple-input" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter password">
                                <button type="button" class="simple-eye-btn toggle-password-btn" data-target="password_confirmation" title="Toggle Password" aria-label="Toggle confirm password visibility">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-simple-orange">
                            <span>Create Account</span>
                            <i class="fas fa-user-plus"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none ms-1">Sign In</a>
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
    const toggleBtns = document.querySelectorAll('.toggle-password-btn');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>
@endpush
@endsection
