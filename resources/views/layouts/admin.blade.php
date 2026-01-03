<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Valentine Partner Finder')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        valentine: {
                            50: '#fef2f2',
                            100: '#ffe2e2',
                            200: '#ffc9c9',
                            300: '#ffa3a3',
                            400: '#ff6b6b',
                            500: '#f93a3a',
                            600: '#e71d1d',
                            700: '#c21414',
                            800: '#a01414',
                            900: '#841818',
                        }
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.3s ease-in forwards',
                        'slideIn': 'slideIn 0.3s ease-out forwards',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-10px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        }
        .gradient-sidebar {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
        }
        .nav-item-active {
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.9) 0%, rgba(236, 72, 153, 0.9) 100%);
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.3);
        }
        .nav-item-hover:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .text-gradient {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #e11d48, #db2777);
        }
        /* Sidebar scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-valentine-50 via-pink-50 to-purple-50 min-h-screen" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 gradient-sidebar transform transition-all duration-300 lg:translate-x-0 shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-20 px-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                    <div class="w-10 h-10 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-heart text-white text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <span class="text-white font-bold text-lg">Valentine</span>
                        <span class="block text-xs text-white/60">Admin Panel</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4 sidebar-scroll overflow-y-auto" style="max-height: calc(100vh - 5rem);">
                <!-- Main Section -->
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-white/40 uppercase tracking-wider mb-3">Main</p>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users*') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="ml-3 font-medium">All Users</span>
                    </a>
                </div>
                
                <!-- Verification Section -->
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-white/40 uppercase tracking-wider mb-3">Verification</p>
                    
                    <a href="{{ route('admin.verifications') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.verifications') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.verifications') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <span class="ml-3 font-medium">Verifications</span>
                        @php $pendingVerifications = \App\Models\User::where('registration_paid', true)->where('registration_verified', false)->count(); @endphp
                        @if($pendingVerifications > 0)
                            <span class="ml-auto bg-gradient-to-r from-amber-400 to-yellow-500 text-xs text-white px-2.5 py-1 rounded-full font-bold shadow-lg animate-pulse-slow">
                                {{ $pendingVerifications }}
                            </span>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.payments') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.payments') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.payments') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <span class="ml-3 font-medium">Payments</span>
                        @php $pendingPayments = \App\Models\MatchPayment::where('status', 'submitted')->count(); @endphp
                        @if($pendingPayments > 0)
                            <span class="ml-auto bg-gradient-to-r from-emerald-400 to-green-500 text-xs text-white px-2.5 py-1 rounded-full font-bold shadow-lg animate-pulse-slow">
                                {{ $pendingPayments }}
                            </span>
                        @endif
                    </a>
                </div>
                
                <!-- Matchmaking Section -->
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-white/40 uppercase tracking-wider mb-3">Matchmaking</p>
                    
                    <a href="{{ route('admin.matchmaking') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.matchmaking') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.matchmaking') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-wand-magic-sparkles"></i>
                        </div>
                        <span class="ml-3 font-medium">Matchmaking</span>
                    </a>
                    
                    <a href="{{ route('admin.matches') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.matches') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.matches') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-heart"></i>
                        </div>
                        <span class="ml-3 font-medium">All Matches</span>
                    </a>
                    
                    <a href="{{ route('admin.couples') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.couples') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.couples') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="ml-3 font-medium">Couples</span>
                    </a>
                </div>
                
                <!-- Settings Section -->
                <div class="mb-6 pb-6 border-t border-white/10 pt-6">
                    <a href="{{ route('admin.settings') }}" 
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'nav-item-active text-white' : 'text-white/70 nav-item-hover' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.settings') ? 'bg-white/20' : 'bg-white/5' }}">
                            <i class="fas fa-cog"></i>
                        </div>
                        <span class="ml-3 font-medium">Settings</span>
                    </a>
                    
                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center px-4 py-3 rounded-xl mb-2 transition-all duration-200 text-white/70 nav-item-hover">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-white/5">
                            <i class="fas fa-external-link-alt"></i>
                        </div>
                        <span class="ml-3 font-medium">View Site</span>
                    </a>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-72 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="glass-card shadow-sm h-20 flex items-center justify-between px-6 border-b border-gray-100">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-600 hover:text-valentine-600 mr-4 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="hidden sm:block">
                        <h2 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-xs text-gray-500">@yield('page-subtitle', 'Welcome back!')</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Admin Badge -->
                    <div class="hidden md:flex items-center bg-gradient-to-r from-valentine-50 to-pink-50 px-4 py-2 rounded-xl border border-valentine-100">
                        <div class="w-8 h-8 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shield-halved text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->full_name }}</p>
                            <p class="text-xs text-valentine-600">Administrator</p>
                        </div>
                    </div>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 px-4 py-2.5 rounded-xl transition-all duration-200 group">
                            <i class="fas fa-sign-out-alt group-hover:rotate-12 transition-transform"></i>
                            <span class="ml-2 hidden sm:inline font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4 animate-slideIn">
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 text-emerald-700 px-5 py-4 rounded-xl shadow-sm flex items-center" role="alert">
                        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <p class="font-medium">{{ session('success') }}</p>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 animate-slideIn">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 px-5 py-4 rounded-xl shadow-sm flex items-center" role="alert">
                        <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-exclamation text-white"></i>
                        </div>
                        <p class="font-medium">{{ session('error') }}</p>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
