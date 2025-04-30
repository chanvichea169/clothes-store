@extends('frontend.layouts.master')
@section('title', '- Page Not Found')
@section('content')
<style>
    .error-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        color: #111827;
        padding: 20px;
        overflow: hidden;
    }

    .error-content {
        text-align: center;
        position: relative;
        z-index: 1;
        max-width: 600px;
        padding: 40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        transform: translateY(0);
        opacity: 1;
        animation: fadeInUp 0.8s ease-out;
    }

    .error-code {
        font-size: 8rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 10px;
        background: linear-gradient(45deg, #3b82f6, #ef4444);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        position: relative;
        display: inline-block;
    }

    .error-code::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #ef4444);
        border-radius: 2px;
    }

    .message {
        font-size: 1.8rem;
        margin-bottom: 30px;
        color: #374151;
        line-height: 1.4;
    }

    .btn-home {
        display: inline-block;
        padding: 14px 32px;
        background: linear-gradient(45deg, #3b82f6, #2563eb);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        background: linear-gradient(45deg, #2563eb, #1d4ed8);
    }

    .btn-home:active {
        transform: translateY(1px);
    }

    .btn-home::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .btn-home:hover::before {
        left: 100%;
    }

    .illustration {
        max-width: 400px;
        margin: 30px auto;
        position: relative;
    }

    .illustration img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        transform: perspective(1000px) rotateY(0deg);
        transition: transform 0.5s ease;
    }

    .illustration:hover img {
        transform: perspective(1000px) rotateY(10deg);
    }

    /* Floating animation for decorative elements */
    .floating {
        position: absolute;
        animation: floating 3s ease-in-out infinite;
    }

    .floating-1 {
        top: 10%;
        left: 5%;
        width: 50px;
        opacity: 0.6;
        animation-delay: 0s;
    }

    .floating-2 {
        bottom: 15%;
        right: 8%;
        width: 40px;
        opacity: 0.4;
        animation-delay: 0.5s;
    }

    .floating-3 {
        top: 30%;
        right: 15%;
        width: 30px;
        opacity: 0.3;
        animation-delay: 1s;
    }

    /* Keyframe animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floating {
        0% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-15px) rotate(5deg);
        }
        100% {
            transform: translateY(0) rotate(0deg);
        }
    }

    /* Background particles */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        background: rgba(59, 130, 246, 0.2);
        border-radius: 50%;
        animation: float-particle linear infinite;
    }

    @keyframes float-particle {
        to {
            transform: translateY(-100vh);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .error-code {
            font-size: 6rem;
        }
        .message {
            font-size: 1.4rem;
        }
        .error-content {
            padding: 30px 20px;
        }
    }

    @media (max-width: 480px) {
        .error-code {
            font-size: 4rem;
        }
        .message {
            font-size: 1.2rem;
        }
    }
</style>

<section class="error-container">
    <!-- Background particles -->
    <div class="particles" id="particles"></div>

    <!-- Decorative floating elements -->
    <svg class="floating floating-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#3B82F6"/>
    </svg>

    <svg class="floating floating-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="#EF4444"/>
    </svg>

    <svg class="floating floating-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 4L10.59 5.41L16.17 11H4V13H16.17L10.59 18.59L12 20L20 12L12 4Z" fill="#10B981"/>
    </svg>

    <div class="error-content">
        <div class="error-code">404</div>
        <div class="message">
            Oops! The page you're looking for doesn't exist or has been moved.
        </div>
        <div class="illustration">
            <img src="{{ asset('assets/images/404.png') }}" alt="Page not found" />
        </div>
        <a href="{{ url('/') }}" class="btn-home">Go back to homepage</a>
    </div>
</section>

<script>
    // Create background particles
    document.addEventListener('DOMContentLoaded', function() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');

            // Random size between 5 and 15px
            const size = Math.random() * 10 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;

            // Random position
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;

            // Random opacity
            particle.style.opacity = Math.random() * 0.5 + 0.1;

            // Random animation duration
            const duration = Math.random() * 20 + 10;
            particle.style.animationDuration = `${duration}s`;

            // Random delay
            particle.style.animationDelay = `${Math.random() * 5}s`;

            particlesContainer.appendChild(particle);
        }
    });
</script>
@endsection
