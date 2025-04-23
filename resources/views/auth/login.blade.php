<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clothes-Shop - Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
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
    </style>
</head>
<body>
    <x-alert/>
    <div class="image-panel">
        <div class="image-content">
            <h2 class="floating text-light">Ready to Do Your Best Work?</h2>
            <img src="assets/images/login.png" alt="Tipe Logo" style="width: 200%; max-width: 120%; margin-bottom: 1rem; margin-left: -20%; animation: floating 6s ease-in-out infinite;">
            <p>Access your personalized dashboard and continue where you left off. Our platform helps professionals like you stay productive and organized.</p>
        </div>
    </div>

    <div class="form-panel">
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome back</h1>
                <p>Sign in to continue using Tipe</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                @error('email')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="yourname@example.com" required>
                </div>
                @error('password')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>

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
                    {{-- <a href="#" class="social-btn">
                        <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="GitHub">
                        Continue with GitHub
                    </a> --}}
                </div>

                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

