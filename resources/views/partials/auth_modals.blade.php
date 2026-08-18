<!-- AutoLux Interactive Home Page Auth Modal Popup -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered auth-modal-dialog">
        <div class="modal-content auth-modal-content position-relative">
            
            <!-- Close Button -->
            <button type="button" class="auth-modal-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>

            <!-- Brand Icon -->
            <div class="text-center mb-3">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                    <span class="fs-4 fw-bold text-dark"><i class="fas fa-car-side" style="color: #FF7A00;"></i> Auto<span style="color: #FF7A00;">Lux</span></span>
                </a>
            </div>

            <!-- Tab Switcher Navigation -->
            <div class="auth-tab-nav">
                <button type="button" class="auth-tab-btn active" id="tabBtnLogin" onclick="switchAuthTab('login')">
                    Sign In
                </button>
                <button type="button" class="auth-tab-btn" id="tabBtnRegister" onclick="switchAuthTab('register')">
                    Create Account
                </button>
            </div>

            <!-- ================= LOGIN FORM TAB ================= -->
            <div id="authTabLogin">
                <div class="mb-4">
                    <h3 class="fw-extrabold text-dark mb-1" style="font-size: 1.5rem;">Welcome back 👋</h3>
                    <p class="text-muted small mb-0">Please sign in to continue booking vehicles</p>
                </div>

                <form method="POST" action="{{ route('login') }}" id="modalLoginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="simple-field-group">
                        <label for="modal_login_email" class="simple-field-label">Email Address</label>
                        <div class="simple-input-box">
                            <i class="fas fa-envelope simple-input-icon"></i>
                            <input type="email" class="simple-input @error('email') is-invalid @enderror" id="modal_login_email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="simple-field-group mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="modal_login_password" class="simple-field-label mb-0">Password</label>
                            <a href="{{ route('password.request') }}" class="text-primary small text-decoration-none fw-semibold">Forgot Password?</a>
                        </div>
                        <div class="simple-input-box">
                            <i class="fas fa-lock simple-input-icon"></i>
                            <input type="password" class="simple-input @error('password') is-invalid @enderror" id="modal_login_password" name="password" required placeholder="••••••••••••">
                            <button type="button" class="simple-eye-btn modal-eye-btn" data-target="modal_login_password" title="Toggle Password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="modal_remember" name="remember">
                            <label class="form-check-label small text-muted fw-medium" for="modal_remember">Remember this device</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-simple-orange">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right ms-1"></i>
                    </button>

                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">
                            Don't have an account? 
                            <a href="javascript:void(0)" onclick="switchAuthTab('register')" class="text-primary fw-bold text-decoration-none">Sign Up</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- ================= REGISTER FORM TAB ================= -->
            <div id="authTabRegister" style="display: none;">
                <div class="mb-4">
                    <h3 class="fw-extrabold text-dark mb-1" style="font-size: 1.5rem;">Create Account ✨</h3>
                    <p class="text-muted small mb-0">Join AutoLux in less than 2 minutes</p>
                </div>

                <form method="POST" action="{{ route('register') }}" id="modalRegisterForm">
                    @csrf

                    <!-- Full Name -->
                    <div class="simple-field-group">
                        <label for="modal_reg_name" class="simple-field-label">Full Name</label>
                        <div class="simple-input-box">
                            <i class="fas fa-user simple-input-icon"></i>
                            <input type="text" class="simple-input @error('name') is-invalid @enderror" id="modal_reg_name" name="name" value="{{ old('name') }}" required placeholder="Rai Rajan">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="simple-field-group">
                        <label for="modal_reg_email" class="simple-field-label">Email Address</label>
                        <div class="simple-input-box">
                            <i class="fas fa-envelope simple-input-icon"></i>
                            <input type="email" class="simple-input @error('email') is-invalid @enderror" id="modal_reg_email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="simple-field-group">
                        <label for="modal_reg_phone" class="simple-field-label">Phone Number</label>
                        <div class="simple-input-box">
                            <i class="fas fa-phone simple-input-icon"></i>
                            <input type="text" class="simple-input @error('phone') is-invalid @enderror" id="modal_reg_phone" name="phone" value="{{ old('phone') }}" required placeholder="9876543210">
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="simple-field-group">
                        <label for="modal_reg_password" class="simple-field-label">Password</label>
                        <div class="simple-input-box">
                            <i class="fas fa-lock simple-input-icon"></i>
                            <input type="password" class="simple-input @error('password') is-invalid @enderror" id="modal_reg_password" name="password" required placeholder="Min. 8 characters">
                            <button type="button" class="simple-eye-btn modal-eye-btn" data-target="modal_reg_password" title="Toggle Password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1.5 fw-semibold">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="simple-field-group mb-4">
                        <label for="modal_reg_password_conf" class="simple-field-label">Confirm Password</label>
                        <div class="simple-input-box">
                            <i class="fas fa-lock simple-input-icon"></i>
                            <input type="password" class="simple-input" id="modal_reg_password_conf" name="password_confirmation" required placeholder="Re-enter password">
                            <button type="button" class="simple-eye-btn modal-eye-btn" data-target="modal_reg_password_conf" title="Toggle Password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-simple-orange">
                        <span>Create Account</span>
                        <i class="fas fa-user-plus ms-1"></i>
                    </button>

                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">
                            Already have an account? 
                            <a href="javascript:void(0)" onclick="switchAuthTab('login')" class="text-primary fw-bold text-decoration-none">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
function switchAuthTab(mode) {
    const tabLogin = document.getElementById('authTabLogin');
    const tabRegister = document.getElementById('authTabRegister');
    const btnLogin = document.getElementById('tabBtnLogin');
    const btnRegister = document.getElementById('tabBtnRegister');

    if (mode === 'register') {
        tabLogin.style.display = 'none';
        tabRegister.style.display = 'block';
        btnLogin.classList.remove('active');
        btnRegister.classList.add('active');
    } else {
        tabRegister.style.display = 'none';
        tabLogin.style.display = 'block';
        btnRegister.classList.remove('active');
        btnLogin.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Password toggle buttons inside modal
    document.querySelectorAll('.modal-eye-btn').forEach(btn => {
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

    // Auto-open modal if validation errors exist
    @if($errors->any())
        const modalElement = document.getElementById('authModal');
        if (modalElement) {
            const authModal = new bootstrap.Modal(modalElement);
            @if($errors->has('name') || $errors->has('phone'))
                switchAuthTab('register');
            @else
                switchAuthTab('login');
            @endif
            authModal.show();
        }
    @endif
});
</script>
