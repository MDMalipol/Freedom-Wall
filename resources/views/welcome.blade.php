<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --royal-blue: #1e3a8a;
            --royal-blue-light: #3b82f6;
            --royal-blue-dark: #1e40af;
            --golden-yellow: #fbbf24;
            --golden-yellow-light: #fcd34d;
            --pure-white: #ffffff;
            --off-white: #fefefe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            overflow-x: hidden;
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--royal-blue) 0%, var(--royal-blue-light) 50%, var(--royal-blue-dark) 100%);
            position: relative;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(251, 191, 36, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--golden-yellow), var(--golden-yellow-light));
            top: 20%;
            left: 10%;
            animation-delay: 0s;
            opacity: 0.7;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2));
            top: 60%;
            right: 15%;
            animation-delay: -2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, var(--golden-yellow-light), var(--golden-yellow));
            bottom: 30%;
            left: 20%;
            animation-delay: -4s;
            opacity: 0.8;
        }

        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.15));
            top: 40%;
            left: 70%;
            animation-delay: -1s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        .nav-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .nav-btn:hover::before {
            left: 100%;
        }

        .primary-btn {
            background: linear-gradient(135deg, var(--golden-yellow) 0%, var(--golden-yellow-light) 100%);
            color: var(--royal-blue);
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
            background: linear-gradient(135deg, var(--golden-yellow-light) 0%, var(--golden-yellow) 100%);
        }

        .secondary-btn {
            background: rgba(255, 255, 255, 0.1);
            color: var(--pure-white);
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
        }

        .hero-section {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--pure-white);
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4rem);
            font-weight: 700;
            background: linear-gradient(135deg, var(--pure-white) 0%, var(--golden-yellow-light) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            animation: slideInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .logo-animation {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--golden-yellow), var(--golden-yellow-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--golden-yellow), var(--golden-yellow-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: var(--royal-blue);
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex flex-col">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <header class="w-full relative z-10 p-6 lg:p-8">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="logo-animation">
                    <h1 class="text-2xl font-bold text-white">
                        <span class="text-yellow-300">National</span> University
                    </h1>
                </div>
                
                <div class="flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="nav-btn primary-btn px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="nav-btn secondary-btn px-6 py-3 rounded-full text-sm font-medium transition-all duration-300">
                            Admin Login
                        </a>
                    @endauth
                </div>
            </nav>
        @endif
    </header>

    <main class="flex-1 flex items-center justify-center p-6 lg:p-8 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="glass-card p-8 lg:p-12 mb-8">
                <div class="hero-section">
                    <h2 class="hero-title">Welcome to NU FREEDOM WALL</h2>
                    <p class="hero-subtitle">
                        Share Your Experiences, Thoughts, and Ideas with the National University Community.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('wall') }}" class="primary-btn px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Connet With Your Fellow Nationalians</h3>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Share Your NU Journey</h3>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Be Active in Sharing and Giving NU Ideas</h3>
                </div>
            </div>
        </div>
    </main>

    <footer class="relative z-10 p-6 text-center">
        <p class="text-white opacity-60 text-sm">
            &copy; {{ date('Y') }} Laravel. Crafted with ❤️ for developers.
        </p>
    </footer>
</body>

</html>