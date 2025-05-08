<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Your App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #36b9cc;
            --text-dark: #5a5c69;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Nunito', sans-serif;
            padding: 3rem 0;
        }
        
        .auth-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .auth-card .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            padding: 1.5rem;
            border: none;
            text-align: center;
        }
        
        .auth-card .card-body {
            padding: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: #224abe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .input-group-text {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .form-floating > .form-control {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        
        .input-icon {
            position: absolute;
            top: 1.1rem;
            right: 1rem;
            color: var(--text-dark);
        }
        
        .password-toggle {
            cursor: pointer;
        }
        
        .invalid-feedback {
            font-size: 80%;
            font-weight: 500;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider span {
            padding: 0 10px;
            color: #777;
            font-size: 0.9rem;
        }
        
        .login-link {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .required-field::after {
            content: "*";
            color: #dc3545;
            margin-left: 4px;
        }
        
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="auth-card card animate-fade">
                    <div class="card-header">
                        <h1 class="h4 mb-0">Create Your Account</h1>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="section-title">Personal Information</div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating position-relative">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                                        <label for="name" class="required-field">Full Name</label>
                                        <i class="fas fa-user input-icon"></i>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating position-relative">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        <label for="email" class="required-field">Email Address</label>
                                        <i class="fas fa-envelope input-icon"></i>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating position-relative">
                                        <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel">
                                        <label for="phone_number">Phone Number</label>
                                        <i class="fas fa-phone input-icon"></i>
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-4">
                                <div class="form-floating position-relative">
                                    <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" style="height: 100px" autocomplete="address">{{ old('address') }}</textarea>
                                    <label for="address">Address</label>
                                    <i class="fas fa-home input-icon"></i>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Role Selection Field -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating position-relative">
                                    <select id="role_id" class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Player</option>
                                        <option value="3" {{ old('role_id') == 3 ? 'selected' : '' }}>Field Manager</option>
                                        <option value="4" {{ old('role_id') == 4 ? 'selected' : '' }}>Vendor</option>
                                    </select>
                                    <label for="role_id" class="required-field">Account Type</label>
                                    <i class="fas fa-user-tag input-icon"></i>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="section-title mt-4">Security Information</div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating position-relative">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <label for="password" class="required-field">Password</label>
                                        <i class="fas fa-eye password-toggle input-icon" id="toggle-password"></i>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-text">Password must be at least 8 characters long.</div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating position-relative">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <label for="password-confirm" class="required-field">Confirm Password</label>
                                        <i class="fas fa-eye password-toggle input-icon" id="toggle-password-confirm"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </button>
                            </div>
                            
                            <div class="login-link">
                                Already have an account? <a href="{{ route('login') }}">Log In</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-3 text-muted">
                    &copy; 2025 YourApp. All rights reserved.
                </div>
            </div>
        </div>
    </div>
  

    <!-- Bootstrap and custom JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle functionality
        document.querySelectorAll('.password-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const passwordField = this.closest('.position-relative').querySelector('input[type="password"]');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>