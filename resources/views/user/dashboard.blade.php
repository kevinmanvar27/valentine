@extends('layouts.app')

@section('title', 'Dashboard - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/2 right-1/4 w-64 h-64 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 left-1/3 w-48 h-48 bg-yellow-200 rounded-full blur-3xl opacity-30 animate-float" style="animation-delay: 3s;"></div>
    </div>
    
    <!-- Header Section -->
    <div class="gradient-bg-animated relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center">
                    <div class="relative">
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" alt="Profile" class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-2xl">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-white/20 flex items-center justify-center border-4 border-white shadow-2xl">
                                <i class="fas fa-user text-white text-3xl"></i>
                            </div>
                        @endif
                        @if($user->is_verified)
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            Welcome, {{ Str::words($user->full_name, 1, '') }}! 
                            <span class="inline-block animate-wiggle">👋</span>
                        </h1>
                        <div class="flex flex-wrap items-center gap-3">
                            @if($user->is_verified)
                                <span class="inline-flex items-center bg-green-400/30 text-white px-3 py-1 rounded-lg text-sm font-medium backdrop-blur-sm">
                                    <i class="fas fa-shield-check mr-2"></i>Verified
                                </span>
                            @endif
                            @if($user->payment_verified)
                                <span class="inline-flex items-center bg-yellow-400/30 text-white px-3 py-1 rounded-lg text-sm font-medium backdrop-blur-sm">
                                    <i class="fas fa-crown mr-2"></i>Premium
                                </span>
                            @endif
                            <span class="inline-flex items-center bg-white/20 text-white px-3 py-1 rounded-lg text-sm backdrop-blur-sm">
                                <i class="fas fa-graduation-cap mr-2"></i>{{ $user->branch }} - {{ $user->year }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('user.profile') }}" class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 flex items-center">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('user.suggestions') }}" class="bg-white text-valentine-600 px-6 py-3 rounded-xl font-bold hover:bg-yellow-300 hover:text-valentine-700 transition-all duration-300 flex items-center shadow-lg whitespace-nowrap">
                        <i class="fas fa-heart mr-2 animate-heartbeat"></i>Find Matches
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alert Messages -->
        @if(!$user->is_verified)
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-2xl p-6 mb-8 animate-fade-in shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-yellow-800 mb-1">Profile Under Review</h3>
                        <p class="text-yellow-700">Your profile is being verified by our team. This usually takes 24-48 hours. You'll be notified once approved!</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($user->is_verified && !$user->payment_verified)
            <div class="bg-gradient-to-r from-valentine-50 to-pink-50 border-l-4 border-valentine-500 rounded-2xl p-6 mb-8 animate-fade-in shadow-lg">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-credit-card text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-valentine-800 mb-1">Complete Your Payment</h3>
                            <p class="text-valentine-700">Pay the registration fee to unlock all features and start matching!</p>
                        </div>
                    </div>
                    <a href="{{ route('user.payment') }}" class="btn-primary text-white px-8 py-3 rounded-xl font-bold flex items-center shadow-lg whitespace-nowrap">
                        <i class="fas fa-crown mr-2"></i>Pay Now
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
            <div class="bg-gradient-to-br from-valentine-500 to-pink-500 rounded-2xl p-6 shadow-xl card-hover relative overflow-hidden">

                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-heart text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-white">{{ $matchesCount ?? 0 }}</span>
                    </div>
                    <h3 class="text-white/90 font-medium">Matches</h3>
                    <a href="{{ route('user.matches') }}" class="text-white text-sm font-medium hover:underline mt-2 inline-flex items-center">
                        View all <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-pink-500 to-purple-500 rounded-2xl p-6 shadow-xl card-hover relative overflow-hidden">

                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-white">{{ $suggestionsCount ?? 0 }}</span>
                    </div>
                    <h3 class="text-white/90 font-medium">Suggestions</h3>
                    <a href="{{ route('user.suggestions') }}" class="text-white text-sm font-medium hover:underline mt-2 inline-flex items-center">
                        Browse <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 shadow-xl card-hover relative overflow-hidden">

                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-bell text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-white">{{ $notificationsCount ?? 0 }}</span>
                    </div>
                    <h3 class="text-white/90 font-medium">Notifications</h3>
                    <a href="{{ route('user.notifications') }}" class="text-white text-sm font-medium hover:underline mt-2 inline-flex items-center">
                        View all <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl p-6 shadow-xl card-hover relative overflow-hidden">

                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-white">{{ $profileViews ?? 0 }}</span>
                    </div>
                    <h3 class="text-white/90 font-medium">Profile Views</h3>
                    <span class="text-white text-sm font-medium mt-2 inline-flex items-center">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i> This week
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-xl overflow-hidden card-hover border-2 border-valentine-200">
                    <div class="gradient-bg-animated p-6 text-center relative">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="relative">
                            @if($user->photo)
                                <img src="{{ Storage::url($user->photo) }}" alt="Profile" class="w-32 h-32 rounded-2xl object-cover mx-auto border-4 border-white shadow-2xl">
                            @else
                                <div class="w-32 h-32 rounded-2xl bg-white/20 flex items-center justify-center mx-auto border-4 border-white shadow-2xl">
                                    <i class="fas fa-user text-white text-4xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 text-center mb-2">{{ $user->full_name }}</h2>
                        <p class="text-gray-500 text-center mb-6">{{ $user->age }} years • {{ ucfirst($user->gender) }}</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-valentine-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-graduation-cap text-valentine-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Branch</p>
                                    <p class="font-medium text-gray-900">{{ $user->branch }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar text-pink-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Year</p>
                                    <p class="font-medium text-gray-900">{{ $user->year }}</p>
                                </div>
                            </div>
                            
                            @if($user->instagram_id)
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fab fa-instagram text-purple-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Instagram</p>
                                    <p class="font-medium text-gray-900">@{{ $user->instagram_id }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($user->bio)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-400 mb-2">About Me</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $user->bio }}</p>
                        </div>
                        @endif
                        
                        <a href="{{ route('user.profile') }}" class="mt-6 w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Activity & Suggestions -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-white to-pink-50 rounded-3xl shadow-xl p-8 border-2 border-pink-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-valentine-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-bolt text-valentine-500"></i>
                        </div>
                        Quick Actions
                    </h2>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <a href="{{ route('user.suggestions') }}" class="group bg-gradient-to-r from-valentine-50 to-pink-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-valentine-100">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-search-heart text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Browse Matches</h3>
                                    <p class="text-gray-500 text-sm">Find your perfect Valentine</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.matches') }}" class="group bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-pink-100">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-heart text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">My Matches</h3>
                                    <p class="text-gray-500 text-sm">View your connections</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.notifications') }}" class="group bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-purple-100">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-bell text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Notifications</h3>
                                    <p class="text-gray-500 text-sm">Stay updated</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('couples') }}" class="group bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-green-100">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-heart-circle-check text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Success Stories</h3>
                                    <p class="text-gray-500 text-sm">Get inspired</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Couple -->
                @if(isset($featuredCouple) && $featuredCouple)
                <div class="bg-gradient-to-r from-valentine-500 to-pink-500 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
    
                    <div class="relative">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold flex items-center">
                                <i class="fas fa-star text-yellow-300 mr-3"></i>
                                Featured Couple
                            </h2>
                            <span class="bg-white/20 px-4 py-1 rounded-full text-sm backdrop-blur-sm">
                                <i class="fas fa-heart mr-1"></i> Success Story
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-center mb-6">
                            <div class="relative">
                                <img src="{{ Storage::url($featuredCouple->partner1_photo) }}" alt="" class="w-20 h-20 rounded-xl object-cover border-3 border-white shadow-lg">
                            </div>
                            <div class="mx-4 text-4xl animate-heartbeat">💕</div>
                            <div class="relative">
                                <img src="{{ Storage::url($featuredCouple->partner2_photo) }}" alt="" class="w-20 h-20 rounded-xl object-cover border-3 border-white shadow-lg">
                            </div>
                        </div>
                        
                        <p class="text-center text-white/90 text-lg">
                            <span class="font-bold">{{ $featuredCouple->partner1_name }}</span> & 
                            <span class="font-bold">{{ $featuredCouple->partner2_name }}</span>
                        </p>
                        <p class="text-center text-white/70 text-sm mt-2">Found love on Valentine Finder! ❤️</p>
                        
                        <a href="{{ route('couples') }}" class="mt-6 w-full bg-white text-valentine-600 py-3 rounded-xl font-bold hover:bg-yellow-300 hover:text-valentine-700 transition-all duration-300 flex items-center justify-center">
                            View All Success Stories
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                @endif
                
                <!-- Event Countdown -->
                <div class="bg-gradient-to-br from-white to-yellow-50 rounded-3xl shadow-xl p-8 border-2 border-yellow-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-heart text-yellow-500"></i>
                        </div>
                        Valentine's Week 2026
                    </h2>
                    
                    <div class="bg-gradient-to-r from-valentine-50 to-pink-50 rounded-2xl p-6 border border-valentine-100">
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="bg-gradient-to-br from-valentine-500 to-pink-500 rounded-xl p-4 shadow-lg">
                                <span class="text-3xl font-bold text-white" id="days">--</span>
                                <p class="text-white/80 text-sm mt-1">Days</p>
                            </div>
                            <div class="bg-gradient-to-br from-pink-500 to-purple-500 rounded-xl p-4 shadow-lg">
                                <span class="text-3xl font-bold text-white" id="hours">--</span>
                                <p class="text-white/80 text-sm mt-1">Hours</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl p-4 shadow-lg">
                                <span class="text-3xl font-bold text-white" id="minutes">--</span>
                                <p class="text-white/80 text-sm mt-1">Minutes</p>
                            </div>
                            <div class="bg-gradient-to-br from-indigo-500 to-blue-500 rounded-xl p-4 shadow-lg">
                                <span class="text-3xl font-bold text-white" id="seconds">--</span>
                                <p class="text-white/80 text-sm mt-1">Seconds</p>
                            </div>
                        </div>
                        <p class="text-center text-gray-600 mt-4">
                            <i class="fas fa-info-circle text-valentine-500 mr-2"></i>
                            Event runs from <span class="font-bold">Feb 7-14, 2026</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Countdown Timer
function updateCountdown() {
    const eventDate = new Date('February 7, 2026 00:00:00').getTime();
    const now = new Date().getTime();
    const distance = eventDate - now;
    
    if (distance > 0) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('days').textContent = days;
        document.getElementById('hours').textContent = hours;
        document.getElementById('minutes').textContent = minutes;
        document.getElementById('seconds').textContent = seconds;
    } else {
        document.getElementById('days').textContent = '0';
        document.getElementById('hours').textContent = '0';
        document.getElementById('minutes').textContent = '0';
        document.getElementById('seconds').textContent = '0';
    }
}

updateCountdown();
setInterval(updateCountdown, 1000);
</script>
@endpush
@endsection
