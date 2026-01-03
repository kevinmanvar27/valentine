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
    
    <!-- Google Fonts - Elegant Pairing -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rose: {
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
                    },
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                        'sans': ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Clean Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #fda4af;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #fb7185;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation - Clean & Elegant -->
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        @php $logo = \App\Models\AdminSetting::getAppLogo(); @endphp
                        @if($logo)
                            <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-10 w-auto">
                        @else
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-heart text-white text-lg"></i>
                                </div>
                                <span class="text-xl font-semibold text-gray-900 font-serif">
                                    Valentine<span class="text-rose-500">Finder</span>
                                </span>
                            </div>
                        @endif
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="text-gray-600 hover:text-rose-500 p-2 rounded-lg hover:bg-rose-50 transition-colors">
                        <i class="fas fa-bars text-xl" id="menuIcon"></i>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    @guest
                        <a href="{{ route('couples') }}" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium">
                            Success Stories
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center ml-2 transition-colors">
                            <i class="fas fa-heart mr-2"></i>
                            Get Started
                        </a>
                    @else
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium flex items-center">
                                <i class="fas fa-tachometer-alt mr-3 w-5 text-center text-rose-400"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium flex items-center">
                                <i class="fas fa-home mr-3 w-5 text-center text-rose-400"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('user.notifications') }}" class="text-gray-600 hover:text-rose-500 p-2 rounded-lg hover:bg-rose-50 transition-colors relative">
                                <i class="fas fa-bell text-lg"></i>
                                @php $unreadCount = auth()->user()->notifications()->unread()->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('user.profile') }}" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium flex items-center">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-rose-500 px-4 py-2 rounded-lg hover:bg-rose-50 transition-colors font-medium flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="px-4 py-3 space-y-1">
                @guest
                    <a href="{{ route('couples') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                        <i class="fas fa-heart-circle-check mr-3 w-5 text-center text-rose-400"></i>
                        Success Stories
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                        <i class="fas fa-sign-in-alt mr-3 w-5 text-center text-rose-400"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white px-4 py-3 rounded-lg font-semibold mt-2 transition-colors">
                        <i class="fas fa-heart mr-2"></i>
                        Get Started
                    </a>
                @else
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center text-rose-400"></i>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                            <i class="fas fa-home mr-3 w-5 text-center text-rose-400"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                            <i class="fas fa-user mr-3 w-5 text-center text-rose-400"></i>
                            Profile
                        </a>
                        <a href="{{ route('user.notifications') }}" class="flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                            <i class="fas fa-bell mr-3 w-5 text-center text-rose-400"></i>
                            Notifications
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center text-gray-600 hover:text-rose-500 px-4 py-3 rounded-lg hover:bg-rose-50 transition-colors">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center text-rose-400"></i>
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-center" role="alert">
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-check text-emerald-500"></i>
                </div>
                <p class="font-medium flex-1">{{ session('success') }}</p>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-xl flex items-center" role="alert">
                <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-exclamation text-rose-500"></i>
                </div>
                <p class="font-medium flex-1">{{ session('error') }}</p>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer - Clean & Elegant -->
    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-heart text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 font-serif">
                            Valentine<span class="text-rose-500">Finder</span>
                        </span>
                    </div>
                    <p class="text-gray-500 leading-relaxed max-w-sm">
                        Find your perfect Valentine partner. Connect with like-minded singles and start your beautiful love story.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-rose-500 transition-colors">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('couples') }}" class="text-gray-500 hover:text-rose-500 transition-colors">
                                Success Stories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-gray-500 hover:text-rose-500 transition-colors">
                                Register
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-rose-500 transition-colors">
                                Login
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Event Info -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Event Period</h4>
                    <div class="bg-rose-50 rounded-xl p-4 border border-rose-100">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-heart text-rose-500 mr-2"></i>
                            <span class="font-semibold text-gray-900">Feb 7-14, 2026</span>
                        </div>
                        <p class="text-sm text-gray-500">Valentine's Week</p>
                        <div class="mt-3 pt-3 border-t border-rose-100">
                            <p class="text-xs text-rose-600 font-medium">
                                <i class="fas fa-clock mr-1"></i>
                                Registration closes Feb 6th
                            </p>
                        </div>
                        
                        <!-- Mini Stats -->
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="bg-white rounded-xl p-3 text-center border border-rose-100">
                                <p class="text-2xl font-bold text-rose-500">500+</p>
                                <p class="text-gray-500 text-xs">Happy Couples</p>
                            </div>
                            <div class="bg-white rounded-xl p-3 text-center border border-rose-100">
                                <p class="text-2xl font-bold text-rose-500">2K+</p>
                                <p class="text-gray-500 text-xs">Active Users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 text-sm flex items-center">
                    Made with <i class="fas fa-heart text-rose-500 mx-1.5"></i> for Valentine's Day 2026
                </p>
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} ValentineFinder. All rights reserved.
                </p>
            </div>
        </div>
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
    </script>
    
    @stack('scripts')
</body>
</html>
