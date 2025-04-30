<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clothes-Shop - Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Add Font Awesome for eye icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --text-dark: #1a1a1a;
            --text-medium: #4a4a4a;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --success: #10b981;
            --error: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-light);
        }

        .image-panel {
            flex: 1;
            background:
                linear-gradient(135deg, rgba(67, 97, 238, 0.85), rgba(109, 67, 238, 0.85)),
                url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=1064&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .image-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, transparent 100%);
            z-index: 0;
        }

        .image-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 0 auto;
        }

        .image-content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .image-content p {
            font-size: 1.125rem;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .form-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: var(--bg-white);
            position: relative;
        }

        .register-container {
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease-out forwards;
        }

        .register-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .register-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .register-header p {
            font-size: 1rem;
            color: var(--text-light);
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-medium);
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--bg-light);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            background-color: var(--bg-white);
        }

        .form-group input::placeholder {
            color: var(--text-light);
            opacity: 0.6;
        }

        /* Password toggle specific styles */
        .input-group {
            position: relative;
        }

        .input-group input {
            padding-right: 40px !important;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none !important;
            border: none !important;
            color: var(--text-light);
            cursor: pointer;
            z-index: 2;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .register-btn {
            width: 100%;
            padding: 0.875rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            margin-bottom: 1.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .register-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .divider {
            position: relative;
            margin: 1.75rem 0;
            text-align: center;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: var(--border-color);
            z-index: 1;
        }

        .divider span {
            position: relative;
            display: inline-block;
            padding: 0 1rem;
            background-color: var(--bg-white);
            color: var(--text-light);
            font-size: 0.8125rem;
            z-index: 2;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            margin-bottom: 1.75rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-medium);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social-btn:hover {
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .social-btn img {
            width: 1.125rem;
            height: 1.125rem;
            margin-right: 0.75rem;
            transition: transform 0.2s ease;
        }

        .social-btn:hover img {
            transform: scale(1.1);
        }

        .login-link {
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .login-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .terms-text {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .image-panel {
                display: none;
            }

            .form-panel {
                padding: 2rem 1.5rem;
            }
        }

        /* Floating animation for decorative elements */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        .error-message {
            color: var(--error);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
</head>
<body>
    <div class="image-panel">
        <div class="image-content">
            <h2 class="floating">Join Our Community</h2>
            <img src="assets/images/login.png" alt="Tipe Logo" style="width: 200%; max-width: 120%; margin-bottom: 0.5rem; margin-left: -20%; animation: floating 6s ease-in-out infinite;">
            <p>Create your account to get started. Our platform helps professionals like you stay productive and organized.</p>
        </div>
    </div>

    <div class="form-panel">
        <div class="register-container">
            <div class="register-header">
                <h1>Create your account</h1>
                <p>Get started with Tipe in just a few steps</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="yourname@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" placeholder="+1 (123) 456-7890" value="{{ old('mobile') }}" required>
                    @error('mobile')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <span class="toggle-password" data-target="password">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" id="password-confirm" name="password_confirmation" placeholder="••••••••" required>
                        <span class="toggle-password" data-target="password-confirm">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="register-btn">Create Account</button>

                <div class="divider">
                    <span>OR</span>
                </div>

                <div class="social-login">
                    <a href="{{ route('auth.google') }}" class="social-btn">
                        <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png"
                             alt="Google"
                             width="20"
                             height="20">
                        Continue with Google
                    </a>
                </div>

                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all toggle password buttons
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the target input field
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the eye icon
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });
        });
    </script>
</body>
</html>
