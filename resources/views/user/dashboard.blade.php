@extends('layouts.app')

@section('title', 'Dashboard - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-rose-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center">
                    <div class="relative">
                        @if($user->gallery_images && count($user->gallery_images) > 0)
                            <img src="{{ Storage::url($user->gallery_images[0]) }}" alt="Profile" class="w-20 h-20 rounded-2xl object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center border-4 border-white shadow-lg">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                        @endif
                        @if($user->registration_verified)
                            <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-emerald-500 rounded-lg flex items-center justify-center shadow">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-5">
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">
                            Welcome, {{ Str::words($user->full_name, 1, '') }}! 👋
                        </h1>
                        <div class="flex flex-wrap items-center gap-2">
                            @if($user->registration_verified)
                                <span class="inline-flex items-center bg-white/20 text-white px-2.5 py-1 rounded-lg text-sm font-medium">
                                    <i class="fas fa-shield-check mr-1.5"></i>Verified
                                </span>
                            @endif
                            @if($user->registration_paid)
                                <span class="inline-flex items-center bg-amber-400/30 text-white px-2.5 py-1 rounded-lg text-sm font-medium">
                                    <i class="fas fa-crown mr-1.5"></i>Premium
                                </span>
                            @endif
                            @if($user->location)
                            <span class="inline-flex items-center bg-white/10 text-white px-2.5 py-1 rounded-lg text-sm">
                                <i class="fas fa-map-marker-alt mr-1.5"></i>{{ $user->location }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('user.profile') }}" class="bg-white/20 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-white/30 transition-colors flex items-center">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('user.suggestions') }}" class="bg-white text-rose-600 px-5 py-2.5 rounded-xl font-semibold hover:bg-rose-50 transition-colors flex items-center shadow-sm">
                        <i class="fas fa-heart mr-2"></i>Find Matches
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Messages -->
        @if(!$user->registration_verified)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-amber-800 mb-1">Profile Under Review</h3>
                        <p class="text-amber-700 text-sm">Your profile is being verified by our team. This usually takes 24-48 hours. You'll be notified once approved!</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($user->registration_verified && !$user->registration_paid)
            <div class="bg-rose-50 border border-rose-200 rounded-xl p-5 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-credit-card text-rose-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-rose-800 mb-1">Complete Your Payment</h3>
                            <p class="text-rose-700 text-sm">Pay the registration fee to unlock all features and start matching!</p>
                        </div>
                    </div>
                    <a href="{{ route('user.payment') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center transition-colors whitespace-nowrap">
                        <i class="fas fa-crown mr-2"></i>Pay Now
                    </a>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left Column - Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-rose-500 p-6 text-center">
                        @if($user->gallery_images && count($user->gallery_images) > 0)
                            <img src="{{ Storage::url($user->gallery_images[0]) }}" alt="Profile" class="w-28 h-28 rounded-2xl object-cover mx-auto border-4 border-white shadow-lg">
                        @else
                            <div class="w-28 h-28 rounded-2xl bg-white/20 flex items-center justify-center mx-auto border-4 border-white shadow-lg">
                                <i class="fas fa-user text-white text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-900 text-center mb-1">{{ $user->full_name }}</h2>
                        <p class="text-gray-500 text-center text-sm mb-5">{{ $user->age }} years • {{ ucfirst($user->gender) }}</p>
                        
                        <div class="space-y-3">
                            @if($user->location)
                            <div class="flex items-center text-gray-600">
                                <div class="w-9 h-9 bg-rose-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-rose-500 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Location</p>
                                    <p class="font-medium text-gray-900 text-sm">{{ $user->location }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->whatsapp_number)
                            <div class="flex items-center text-gray-600">
                                <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fab fa-whatsapp text-green-500 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">WhatsApp</p>
                                    <p class="font-medium text-gray-900 text-sm">{{ $user->whatsapp_number }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->instagram_id)
                            <div class="flex items-center text-gray-600">
                                <div class="w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fab fa-instagram text-purple-500 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Instagram</p>
                                    <p class="font-medium text-gray-900 text-sm">@{{ $user->instagram_id }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($user->bio)
                        <div class="mt-5 pt-5 border-t border-gray-100">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">About Me</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $user->bio }}</p>
                        </div>
                        @endif
                        
                        <a href="{{ route('user.profile') }}" class="mt-5 w-full bg-gray-100 text-gray-700 py-2.5 rounded-xl font-medium hover:bg-gray-200 transition-colors flex items-center justify-center text-sm">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Activity & Suggestions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-bolt text-rose-500 text-sm"></i>
                        </div>
                        Quick Actions
                    </h2>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <a href="{{ route('user.suggestions') }}" class="group bg-rose-50 rounded-xl p-4 hover:bg-rose-100 transition-colors border border-rose-100">
                            <div class="flex items-center">
                                <div class="w-11 h-11 bg-rose-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Browse Matches</h3>
                                    <p class="text-gray-500 text-xs">Find your perfect Valentine</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.matches') }}" class="group bg-pink-50 rounded-xl p-4 hover:bg-pink-100 transition-colors border border-pink-100">
                            <div class="flex items-center">
                                <div class="w-11 h-11 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">My Matches</h3>
                                    <p class="text-gray-500 text-xs">View your connections</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.notifications') }}" class="group bg-purple-50 rounded-xl p-4 hover:bg-purple-100 transition-colors border border-purple-100">
                            <div class="flex items-center">
                                <div class="w-11 h-11 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-bell text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Notifications</h3>
                                    <p class="text-gray-500 text-xs">Stay updated</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('couples') }}" class="group bg-emerald-50 rounded-xl p-4 hover:bg-emerald-100 transition-colors border border-emerald-100">
                            <div class="flex items-center">
                                <div class="w-11 h-11 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-heart text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-sm">Success Stories</h3>
                                    <p class="text-gray-500 text-xs">Get inspired</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Couple -->
                @if(isset($featuredCouple) && $featuredCouple)
                <div class="bg-rose-500 rounded-2xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-bold flex items-center">
                            <i class="fas fa-star text-amber-300 mr-2"></i>
                            Featured Couple
                        </h2>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs">
                            <i class="fas fa-heart mr-1"></i> Success Story
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-center mb-4">
                        <div class="relative">
                            <img src="{{ Storage::url($featuredCouple->partner1_photo) }}" alt="" class="w-16 h-16 rounded-xl object-cover border-2 border-white shadow">
                        </div>
                        <div class="mx-3 text-2xl">💕</div>
                        <div class="relative">
                            <img src="{{ Storage::url($featuredCouple->partner2_photo) }}" alt="" class="w-16 h-16 rounded-xl object-cover border-2 border-white shadow">
                        </div>
                    </div>
                    
                    <p class="text-center text-white/90">
                        <span class="font-semibold">{{ $featuredCouple->partner1_name }}</span> & 
                        <span class="font-semibold">{{ $featuredCouple->partner2_name }}</span>
                    </p>
                    <p class="text-center text-white/70 text-sm mt-1">Found love on Valentine Finder! ❤️</p>
                    
                    <a href="{{ route('couples') }}" class="mt-5 w-full bg-white text-rose-600 py-2.5 rounded-xl font-semibold hover:bg-rose-50 transition-colors flex items-center justify-center text-sm">
                        View All Success Stories
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @endif
                
                <!-- Event Countdown -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-amber-500 text-sm"></i>
                        </div>
                        Valentine's Week 2026
                    </h2>
                    
                    <div class="bg-gray-50 rounded-xl p-5">
                        <div class="grid grid-cols-4 gap-3 text-center">
                            <div class="bg-rose-500 rounded-xl p-3">
                                <span class="text-2xl font-bold text-white" id="days">--</span>
                                <p class="text-white/80 text-xs mt-0.5">Days</p>
                            </div>
                            <div class="bg-pink-500 rounded-xl p-3">
                                <span class="text-2xl font-bold text-white" id="hours">--</span>
                                <p class="text-white/80 text-xs mt-0.5">Hours</p>
                            </div>
                            <div class="bg-purple-500 rounded-xl p-3">
                                <span class="text-2xl font-bold text-white" id="minutes">--</span>
                                <p class="text-white/80 text-xs mt-0.5">Minutes</p>
                            </div>
                            <div class="bg-indigo-500 rounded-xl p-3">
                                <span class="text-2xl font-bold text-white" id="seconds">--</span>
                                <p class="text-white/80 text-xs mt-0.5">Seconds</p>
                            </div>
                        </div>
                        <p class="text-center text-gray-500 text-sm mt-4">
                            <i class="fas fa-info-circle text-rose-500 mr-1"></i>
                            Event runs from <span class="font-semibold text-gray-700">Feb 7-14, 2026</span>
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
