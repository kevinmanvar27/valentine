<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Valentine Partner Finder')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        valentine: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        },
                        pink: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'dancing': ['Dancing Script', 'cursive'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'slide-down': 'slideDown 0.4s ease-out',
                        'scale-in': 'scaleIn 0.4s ease-out',
                        'spin-slow': 'spin 8s linear infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'heartbeat': 'heartbeat 1.5s ease-in-out infinite',
                        'gradient-x': 'gradient-x 15s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(5deg)' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        },
                        glow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(244, 63, 94, 0.4)' },
                            '50%': { boxShadow: '0 0 40px rgba(244, 63, 94, 0.8)' },
                        },
                        heartbeat: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '14%': { transform: 'scale(1.15)' },
                            '28%': { transform: 'scale(1)' },
                            '42%': { transform: 'scale(1.15)' },
                            '70%': { transform: 'scale(1)' },
                        },
                        'gradient-x': {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        },
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Enhanced Gradient Backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        }
        
        .gradient-bg-animated {
            background: linear-gradient(-45deg, #f43f5e, #ec4899, #be185d, #fb7185, #f472b6);
            background-size: 400% 400%;
            animation: gradient 12s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        
        .glass-white {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .glass-dark {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(244, 63, 94, 0.25);
        }
        
        .card-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        
        .card-3d:hover {
            transform: rotateY(5deg) rotateX(5deg);
        }
        
        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #be185d 100%);
            background-size: 200% 200%;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -10px rgba(244, 63, 94, 0.5);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #ffffff 0%, #fdf2f8 100%);
            border: 2px solid transparent;
            background-clip: padding-box;
            position: relative;
        }
        
        .btn-secondary::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            margin: -2px;
            border-radius: inherit;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
        }
        
        /* Input Focus Animation */
        .input-animated {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .input-animated:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(244, 63, 94, 0.25);
            border-color: #f43f5e;
        }
        
        /* Floating Hearts Animation */
        .floating-hearts {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        
        .floating-heart {
            position: absolute;
            animation: floatHeart 20s linear infinite;
            opacity: 0;
            filter: blur(0.5px);
        }
        
        @keyframes floatHeart {
            0% {
                opacity: 0;
                transform: translateY(100vh) rotate(0deg) scale(0.5);
            }
            10% {
                opacity: 0.7;
            }
            90% {
                opacity: 0.7;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) rotate(720deg) scale(1.2);
            }
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: linear-gradient(to bottom, #fdf2f8, #fff1f2);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            border-radius: 5px;
            border: 2px solid #fdf2f8;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #e11d48, #db2777);
        }
        
        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #be185d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .text-gradient-gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Pulse Ring Animation */
        .pulse-ring {
            animation: pulseRing 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulseRing {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.5);
            }
            50% {
                box-shadow: 0 0 0 20px rgba(244, 63, 94, 0);
            }
        }
        
        /* Shimmer Effect */
        .shimmer {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Glow Effect */
        .glow-valentine {
            box-shadow: 0 0 30px rgba(244, 63, 94, 0.3);
        }
        
        .glow-valentine:hover {
            box-shadow: 0 0 50px rgba(244, 63, 94, 0.5);
        }
        
        /* Animated Border */
        .animated-border {
            position: relative;
            background: white;
            border-radius: 1.5rem;
        }
        
        .animated-border::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 1.7rem;
            background: linear-gradient(45deg, #f43f5e, #ec4899, #f472b6, #f43f5e);
            background-size: 400% 400%;
            animation: borderGradient 4s ease infinite;
            z-index: -1;
        }
        
        @keyframes borderGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Neon Text */
        .neon-text {
            text-shadow: 0 0 10px rgba(244, 63, 94, 0.8),
                         0 0 20px rgba(244, 63, 94, 0.6),
                         0 0 30px rgba(244, 63, 94, 0.4);
        }
        
        /* Particle Effect Background */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 15s infinite;
        }
        
        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }
        
        /* Ribbon Effect */
        .ribbon {
            position: absolute;
            top: 20px;
            right: -35px;
            transform: rotate(45deg);
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            padding: 5px 40px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        /* Fade animations for page elements */
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .animate-slideUp {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        /* Stagger animation delays */
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-valentine-50 min-h-screen">
    <!-- Floating Hearts Background (only on homepage) -->
    @if(request()->routeIs('home'))
    <div class="floating-hearts">
        @for($i = 0; $i < 20; $i++)
        <div class="floating-heart text-valentine-300" style="left: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.8 }}s; font-size: {{ rand(14, 28) }}px;">
            @if($i % 4 == 0) 💕 @elseif($i % 4 == 1) 💗 @elseif($i % 4 == 2) 💖 @else ❤️ @endif
        </div>
        @endfor
    </div>
    @endif

    <!-- Navigation - Enhanced Colorful Header -->
    <nav class="sticky top-0 z-50 relative overflow-hidden">
        <!-- Animated Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-r from-valentine-600 via-pink-500 to-purple-600 animate-gradient-x" style="background-size: 200% 200%;"></div>

        
        <!-- Decorative Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-1/4 w-32 h-32 bg-yellow-400/20 rounded-full blur-2xl animate-float"></div>
            <div class="absolute bottom-0 right-1/4 w-24 h-24 bg-white/10 rounded-full blur-xl animate-float-slow"></div>
            <div class="absolute top-1/2 right-10 w-16 h-16 bg-pink-300/20 rounded-full blur-lg animate-pulse-slow"></div>
        </div>
        
        <!-- Glass Effect Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent backdrop-blur-sm"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 md:h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        @php $logo = \App\Models\AdminSetting::getAppLogo(); @endphp
                        @if($logo)
                            <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-10 md:h-12 w-auto transition-transform group-hover:scale-110 drop-shadow-lg">
                        @else
                            <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-2 border border-white/20 group-hover:bg-white/20 transition-all duration-300">
                                <div class="relative mr-3">
                                    <div class="absolute inset-0 bg-yellow-400 rounded-full blur-md opacity-50 animate-pulse"></div>
                                    <i class="fas fa-heart text-yellow-300 text-2xl md:text-3xl relative animate-heartbeat drop-shadow-lg"></i>
                                </div>
                                <span class="text-white font-bold text-lg md:text-xl tracking-tight drop-shadow-md">
                                    <span class="font-dancing text-2xl md:text-3xl bg-gradient-to-r from-yellow-200 to-yellow-400 bg-clip-text text-transparent">Valentine</span>
                                    <span class="font-light text-white/90">Finder</span>
                                </span>
                            </div>
                        @endif
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="text-white p-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-300 active:scale-95 backdrop-blur-sm">
                        <i class="fas fa-bars text-xl" id="menuIcon"></i>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2 lg:space-x-3">
                    @guest
                        <a href="{{ route('couples') }}" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                            <i class="fas fa-check-circle mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> 
                            <span>Couples</span>
                        </a>
                        <a href="{{ route('login') }}" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                            <i class="fas fa-sign-in-alt mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> 
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-6 py-2.5 rounded-xl font-bold hover:from-yellow-300 hover:to-orange-300 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center group border-2 border-yellow-300/50">
                            <i class="fas fa-heart mr-2 group-hover:animate-heartbeat text-valentine-600"></i> 
                            <span>Register</span>
                            <i class="fas fa-sparkles ml-2 text-valentine-500"></i>
                        </a>
                    @else
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                                <i class="fas fa-tachometer-alt mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                                <i class="fas fa-home mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> Dashboard
                            </a>
                            <a href="{{ route('user.notifications') }}" class="text-white transition-all duration-300 relative p-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 backdrop-blur-sm">
                                <i class="fas fa-bell text-lg"></i>
                                @php $unreadCount = auth()->user()->notifications()->unread()->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-gradient-to-r from-yellow-400 to-orange-400 text-xs text-gray-900 rounded-full h-5 w-5 flex items-center justify-center font-bold animate-bounce shadow-lg border border-yellow-300">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                        @if(!auth()->user()->is_admin)
                            <a href="{{ route('user.profile') }}" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                                <i class="fas fa-user-circle mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> 
                                <span>Profile</span>
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 flex items-center font-medium backdrop-blur-sm group">
                                <i class="fas fa-sign-out-alt mr-2 text-pink-200 group-hover:text-yellow-300 transition-colors"></i> 
                                <span>Logout</span>
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden md:hidden relative">
            <div class="absolute inset-0 bg-gradient-to-b from-valentine-600/95 to-purple-600/95 backdrop-blur-xl"></div>
            <div class="relative px-4 py-4 space-y-2 border-t border-white/20">
                @guest
                    <a href="{{ route('couples') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-valentine-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        Couples
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <i class="fas fa-sign-in-alt text-white"></i>
                        </div>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-4 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg border-2 border-yellow-300/50">
                        <i class="fas fa-heart mr-2 animate-heartbeat text-valentine-600"></i> Register Now
                        <i class="fas fa-sparkles ml-2 text-valentine-500"></i>
                    </a>
                @else
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-tachometer-alt text-white"></i>
                            </div>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-valentine-400 to-pink-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            Profile
                        </a>
                        <a href="{{ route('user.notifications') }}" class="flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            Notifications
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-gradient-to-r from-yellow-400 to-orange-400 text-xs text-gray-900 px-2.5 py-1 rounded-full font-bold shadow">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center text-white px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-sign-out-alt text-white"></i>
                            </div>
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
        
        <!-- Bottom Gradient Line -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-400"></div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate-slide-down">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-2xl relative flex items-center shadow-lg" role="alert">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fas fa-check text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 transition-colors p-2 hover:bg-green-100 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate-slide-down">
            <div class="bg-gradient-to-r from-red-50 to-valentine-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-2xl relative flex items-center shadow-lg" role="alert">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-red-400 to-valentine-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fas fa-exclamation text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 transition-colors p-2 hover:bg-red-100 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer - Enhanced Colorful Design -->
    <footer class="relative overflow-hidden">
        <!-- Multi-layer Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-valentine-600 via-pink-600 to-purple-700"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent"></div>

        
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 left-10 w-40 h-40 bg-yellow-400/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-60 h-60 bg-pink-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute top-1/2 left-1/3 w-32 h-32 bg-purple-400/20 rounded-full blur-2xl animate-pulse-slow"></div>
            <div class="absolute bottom-10 left-1/4 w-24 h-24 bg-white/10 rounded-full blur-xl animate-float" style="animation-delay: 1s;"></div>
        </div>
        
        <!-- Top Wave Divider -->
        <div class="absolute top-0 left-0 right-0" style="margin-top: -59px;">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full block">
                <path d="M0 60L60 52.5C120 45 240 30 360 22.5C480 15 600 15 720 20C840 25 960 35 1080 37.5C1200 40 1320 35 1380 32.5L1440 30V0H1380C1320 0 1200 0 1080 0C960 0 840 0 720 0C600 0 480 0 360 0C240 0 120 0 60 0H0V60Z" fill="url(#footer-wave-gradient)"/>
                <defs>
                    <linearGradient id="footer-wave-gradient" x1="0" y1="0" x2="1440" y2="0">
                        <stop offset="0%" stop-color="#fdf2f8"/>
                        <stop offset="50%" stop-color="#fce7f3"/>
                        <stop offset="100%" stop-color="#f3e8ff"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 pt-24">
            <div class="grid md:grid-cols-3 gap-10 mb-12">
                <!-- Brand -->
                <div>
                    <div class="flex items-center mb-6 bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-3 border border-white/20 inline-flex">
                        <div class="relative mr-3">
                            <div class="absolute inset-0 bg-yellow-400 rounded-full blur-md opacity-60 animate-pulse"></div>
                            <i class="fas fa-heart text-yellow-300 text-3xl relative animate-heartbeat"></i>
                        </div>
                        <span class="text-white font-bold text-2xl">
                            <span class="font-dancing bg-gradient-to-r from-yellow-200 to-yellow-400 bg-clip-text text-transparent">Valentine</span>
                            <span class="text-white/90">Finder</span>
                        </span>
                    </div>
                    <p class="text-white/80 leading-relaxed text-lg">
                        Find your perfect Valentine partner. Connect with like-minded singles and start your beautiful love story today.
                    </p>
                    
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-xl mb-6 flex items-center">
                        <span class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center mr-3 shadow">
                            <i class="fas fa-link text-gray-900 text-sm"></i>
                        </span>
                        Quick Links
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-white/80 hover:text-yellow-300 transition-all duration-300 flex items-center group bg-white/5 hover:bg-white/10 rounded-xl px-4 py-3 border border-white/10">
                                <i class="fas fa-home text-pink-300 mr-3 group-hover:text-yellow-300 transition-colors"></i>
                                <span>Home</span>
                                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all text-yellow-300"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('couples') }}" class="text-white/80 hover:text-yellow-300 transition-all duration-300 flex items-center group bg-white/5 hover:bg-white/10 rounded-xl px-4 py-3 border border-white/10">
                                <i class="fas fa-check-circle text-pink-300 mr-3 group-hover:text-yellow-300 transition-colors"></i>
                                <span>Success Stories</span>
                                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all text-yellow-300"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-white/80 hover:text-yellow-300 transition-all duration-300 flex items-center group bg-white/5 hover:bg-white/10 rounded-xl px-4 py-3 border border-white/10">
                                <i class="fas fa-user-plus text-pink-300 mr-3 group-hover:text-yellow-300 transition-colors"></i>
                                <span>Register</span>
                                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all text-yellow-300"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="text-white/80 hover:text-yellow-300 transition-all duration-300 flex items-center group bg-white/5 hover:bg-white/10 rounded-xl px-4 py-3 border border-white/10">
                                <i class="fas fa-sign-in-alt text-pink-300 mr-3 group-hover:text-yellow-300 transition-colors"></i>
                                <span>Login</span>
                                <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all text-yellow-300"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Event Info -->
                <div>
                    <h4 class="text-white font-bold text-xl mb-6 flex items-center">
                        <span class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center mr-3 shadow">
                            <i class="fas fa-calendar-alt text-gray-900 text-sm"></i>
                        </span>
                        Event Period
                    </h4>
                    <div class="bg-gradient-to-br from-white/15 to-white/5 backdrop-blur-sm rounded-2xl p-6 border-2 border-white/20 shadow-xl">
                        <div class="flex items-center mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-calendar-alt text-gray-900 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold text-xl">Feb 7-14, 2026</p>
                                <p class="text-white/70 text-sm">Valentine's Week 💕</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-yellow-400/30 to-orange-400/30 rounded-xl px-4 py-3 mt-4 border border-yellow-400/30">
                            <p class="text-yellow-200 text-sm font-semibold flex items-center">
                                <i class="fas fa-clock mr-2 animate-pulse"></i>
                                Registration closes Feb 6th
                            </p>
                        </div>
                        
                        <!-- Mini Stats -->
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="bg-white/10 rounded-xl p-3 text-center border border-white/10">
                                <p class="text-2xl font-bold text-yellow-300">500+</p>
                                <p class="text-white/60 text-xs">Happy Couples</p>
                            </div>
                            <div class="bg-white/10 rounded-xl p-3 text-center border border-white/10">
                                <p class="text-2xl font-bold text-pink-300">2K+</p>
                                <p class="text-white/60 text-xs">Active Users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-white/20 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-white/80 flex items-center text-lg">
                        <span>Made with</span>
                        <span class="mx-2 inline-flex items-center justify-center w-8 h-8 bg-gradient-to-br from-valentine-400 to-pink-400 rounded-full shadow-lg">
                            <i class="fas fa-heart text-white text-sm animate-heartbeat"></i>
                        </span>
                        <span>for Valentine's Day 2026</span>
                    </p>
                    <p class="text-white/50 text-sm">
                        &copy; {{ date('Y') }} ValentinePartnerFinder.com - All rights reserved
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Bottom Gradient Line -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-400"></div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('menuIcon');
            menu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        }
        
        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl');
            } else {
                nav.classList.remove('shadow-2xl');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
