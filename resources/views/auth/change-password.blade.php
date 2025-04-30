<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clothes-Shop - Change Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Add Font Awesome for eye icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add these after your other styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease-out forwards;
        }

        .login-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .login-header p {
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

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me label {
            font-size: 0.875rem;
            color: var(--text-medium);
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .login-btn {
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

        .login-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        }

        .login-btn:active {
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

        .register-link {
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .register-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
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

        /* Button styles */
        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        }

        .btn-secondary {
            background-color: var(--bg-white);
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--bg-light);
            color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <x-alert />
    <div class="image-panel">
        <div class="image-content">
            <h2 class="floating text-light">Ready to Do Your Best Work?</h2>
            <img src="{{ asset('assets/images/login.png') }}" alt="Tipe Logo" style="width: 200%; max-width: 120%; margin-bottom: 1rem; margin-left: -20%; animation: floating 6s ease-in-out infinite;">
            <p>Access your personalized dashboard and continue where you left off. Our platform helps professionals like you stay productive and organized.</p>
        </div>
    </div>

    <div class="form-panel">
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome back</h1>
                <p>Change your password here</p>
            </div>

            <form action="{{ route('user.update.password') }}" method="POST" class="login-form">
                @csrf
                @method('PUT')

                @error('email')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="yourname@example.com" required autocomplete="email">
                </div>

                @error('current_password')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="current_password">Old Password</label>
                    <div class="input-group">
                        <input type="password" id="current_password" name="current_password" placeholder="••••••••" required>
                        <span class="toggle-password" data-target="current_password">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                @error('new_password')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="input-group">
                        <input type="password" id="new_password" name="new_password" placeholder="••••••••" required>
                        <span class="toggle-password" data-target="new_password">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                @error('new_password_confirmation')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••••" required>
                        <span class="toggle-password" data-target="new_password_confirmation">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="btn-container">
                    <a href="{{ route('home.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
