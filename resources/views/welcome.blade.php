@extends('layouts.app')

@section('title', 'Find Your Valentine Partner - Valentine Partner Finder 2026')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 gradient-bg-animated"></div>

    
    <!-- Floating Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Large Gradient Orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-br from-white/20 to-transparent rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-gradient-to-br from-pink-300/20 to-transparent rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-gradient-to-br from-valentine-300/20 to-transparent rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        
        <!-- Floating Hearts -->
        <div class="absolute top-32 right-20 text-6xl animate-float opacity-30">💕</div>
        <div class="absolute bottom-32 left-20 text-5xl animate-float-slow opacity-30">💗</div>
        <div class="absolute top-1/3 right-1/3 text-4xl animate-float opacity-20" style="animation-delay: 1s;">💖</div>
        <div class="absolute bottom-1/4 right-1/4 text-5xl animate-float-slow opacity-25" style="animation-delay: 3s;">❤️</div>
        
        <!-- Sparkle Effects -->
        <div class="absolute top-1/4 left-1/3 w-3 h-3 bg-white rounded-full animate-pulse-slow opacity-60"></div>
        <div class="absolute top-2/3 right-1/4 w-2 h-2 bg-yellow-300 rounded-full animate-pulse-slow opacity-80" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 left-1/4 w-2 h-2 bg-white rounded-full animate-pulse-slow opacity-70" style="animation-delay: 2s;"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <!-- Event Badge -->
        <div class="inline-flex items-center bg-white/20 backdrop-blur-md border border-white/30 rounded-full px-6 py-2 mb-8 animate-slide-down">
            <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
            <span class="text-white font-medium">Valentine's Day 2026 Event</span>
            <span class="ml-3 bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full">Feb 7-14</span>
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-tight animate-fade-in">
            Find Your
            <span class="block font-dancing text-yellow-300 text-6xl md:text-8xl lg:text-9xl mt-2 drop-shadow-lg neon-text">
                Perfect Valentine
            </span>
        </h1>
        
        <!-- Subheading -->
        <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto mb-10 leading-relaxed animate-fade-in stagger-2">
            Join thousands of singles looking for their special someone this Valentine's season. 
            <span class="text-yellow-300 font-semibold">Start your love story today!</span>
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16 animate-fade-in stagger-3">
            <a href="{{ route('register') }}" class="group relative bg-white text-valentine-600 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-yellow-300 hover:text-valentine-700 transition-all duration-300 shadow-2xl hover:shadow-yellow-300/30 hover:scale-105 flex items-center overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <i class="fas fa-heart mr-3 group-hover:animate-heartbeat"></i>
                    Find My Valentine
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 to-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
            <a href="{{ route('couples') }}" class="group glass text-white px-10 py-5 rounded-2xl font-semibold text-lg hover:bg-white/30 transition-all duration-300 flex items-center">
                <i class="fas fa-heart-circle-check mr-3 group-hover:scale-110 transition-transform"></i>
                View Success Stories
            </a>
        </div>
        
        <!-- Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-4xl mx-auto animate-fade-in stagger-4">
            <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">500+</div>
                <div class="text-white/80 text-sm md:text-base">Active Members</div>
            </div>
            <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">150+</div>
                <div class="text-white/80 text-sm md:text-base">Matches Made</div>
            </div>
            <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">98%</div>
                <div class="text-white/80 text-sm md:text-base">Satisfaction Rate</div>
            </div>
            <div class="glass rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                <div class="text-4xl md:text-5xl font-bold text-white mb-2">7</div>
                <div class="text-white/80 text-sm md:text-base">Days of Love</div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-8 h-12 border-2 border-white/50 rounded-full flex items-start justify-center p-2">
                <div class="w-1.5 h-3 bg-white rounded-full animate-pulse"></div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-24 bg-gradient-to-b from-valentine-50 via-pink-50 to-purple-50 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-valentine-100/30 to-transparent"></div>
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-valentine-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-pink-100 rounded-full blur-3xl opacity-50"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-20">
            <span class="inline-block bg-valentine-100 text-valentine-600 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-magic mr-2"></i>Simple Process
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                How It <span class="text-gradient">Works</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Finding your Valentine is easy! Follow these simple steps to start your journey.
            </p>
        </div>
        
        <!-- Steps Grid -->
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="relative group">
                <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-valentine-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-valentine-100 to-transparent rounded-bl-full opacity-50"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-valentine-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-plus text-white text-3xl"></i>
                        </div>
                        <span class="absolute -top-2 -left-2 w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-gray-900 font-bold text-lg shadow-lg">1</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Create Profile</h3>
                        <p class="text-gray-600">Sign up and create your profile with photos and preferences to get started.</p>
                    </div>
                </div>
                <!-- Connector Line -->
                <div class="hidden md:block absolute top-1/2 -right-4 w-8 h-0.5 bg-gradient-to-r from-valentine-300 to-pink-300"></div>
            </div>
            
            <!-- Step 2 -->
            <div class="relative group">
                <div class="bg-gradient-to-br from-white to-pink-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-pink-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-100 to-transparent rounded-bl-full opacity-50"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-credit-card text-white text-3xl"></i>
                        </div>
                        <span class="absolute -top-2 -left-2 w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-gray-900 font-bold text-lg shadow-lg">2</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pay & Verify</h3>
                        <p class="text-gray-600">Complete payment and get verified to access all features and matches.</p>
                    </div>
                </div>
                <div class="hidden md:block absolute top-1/2 -right-4 w-8 h-0.5 bg-gradient-to-r from-pink-300 to-purple-300"></div>
            </div>
            
            <!-- Step 3 -->
            <div class="relative group">
                <div class="bg-gradient-to-br from-white to-purple-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-purple-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-transparent rounded-bl-full opacity-50"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-search-heart text-white text-3xl"></i>
                        </div>
                        <span class="absolute -top-2 -left-2 w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-gray-900 font-bold text-lg shadow-lg">3</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Browse Matches</h3>
                        <p class="text-gray-600">Explore potential matches and express interest in profiles you like.</p>
                    </div>
                </div>
                <div class="hidden md:block absolute top-1/2 -right-4 w-8 h-0.5 bg-gradient-to-r from-purple-300 to-valentine-300"></div>
            </div>
            
            <!-- Step 4 -->
            <div class="relative group">
                <div class="bg-gradient-to-br from-white to-yellow-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-yellow-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-valentine-100 to-transparent rounded-bl-full opacity-50"></div>
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-valentine-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300 animate-glow">
                            <i class="fas fa-heart text-white text-3xl animate-heartbeat"></i>
                        </div>
                        <span class="absolute -top-2 -left-2 w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-gray-900 font-bold text-lg shadow-lg">4</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Find Your Match!</h3>
                        <p class="text-gray-600">Connect with your Valentine and start your beautiful love story!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-gradient-to-b from-pink-100 via-valentine-50 to-purple-50 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-valentine-100 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-pink-100 rounded-full blur-3xl opacity-30"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <span class="inline-block bg-pink-100 text-pink-600 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-star mr-2"></i>Why Choose Us
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Features That Make Us <span class="text-gradient">Special</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                We've designed every feature with your perfect match in mind.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-white to-green-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-green-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-shield-check text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Verified Profiles</h3>
                <p class="text-gray-600 leading-relaxed">Every profile is manually verified with live photos to ensure authenticity and safety.</p>
                <div class="mt-6 flex items-center text-green-600 font-medium">
                    <i class="fas fa-check-circle mr-2"></i>
                    100% Verified
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-blue-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Privacy First</h3>
                <p class="text-gray-600 leading-relaxed">Your data is secure with us. Contact details are shared only with mutual matches.</p>
                <div class="mt-6 flex items-center text-blue-600 font-medium">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Secure & Private
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-valentine-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Matching</h3>
                <p class="text-gray-600 leading-relaxed">Our algorithm suggests compatible matches based on your preferences and interests.</p>
                <div class="mt-6 flex items-center text-valentine-600 font-medium">
                    <i class="fas fa-magic mr-2"></i>
                    AI-Powered
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="bg-gradient-to-br from-white to-yellow-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-yellow-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Instant Connect</h3>
                <p class="text-gray-600 leading-relaxed">Get matched instantly and start chatting with your Valentine right away.</p>
                <div class="mt-6 flex items-center text-yellow-600 font-medium">
                    <i class="fas fa-comments mr-2"></i>
                    Real-time Chat
                </div>
            </div>
            
            <!-- Feature 5 -->
            <div class="bg-gradient-to-br from-white to-purple-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-purple-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Limited Time Event</h3>
                <p class="text-gray-600 leading-relaxed">Exclusive Valentine's week event with special activities and surprise matches.</p>
                <div class="mt-6 flex items-center text-purple-600 font-medium">
                    <i class="fas fa-clock mr-2"></i>
                    Feb 7-14, 2026
                </div>
            </div>
            
            <!-- Feature 6 -->
            <div class="bg-gradient-to-br from-white to-teal-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 card-hover border-2 border-teal-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">24/7 Support</h3>
                <p class="text-gray-600 leading-relaxed">Our dedicated team is always here to help you on your journey to find love.</p>
                <div class="mt-6 flex items-center text-teal-600 font-medium">
                    <i class="fab fa-whatsapp mr-2"></i>
                    WhatsApp Support
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 gradient-bg-animated relative overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block bg-white/20 text-white px-6 py-2 rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">
                <i class="fas fa-quote-left mr-2"></i>Success Stories
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Love Stories That <span class="text-yellow-300">Inspire</span>
            </h2>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                Real couples who found their perfect match through our platform.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="glass rounded-3xl p-8 transform hover:scale-105 transition-all duration-500">
                <div class="flex items-center mb-6">
                    <div class="flex -space-x-3">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-valentine-400 to-pink-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">R</div>
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">A</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-white font-bold">Rahul & Ananya</h4>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 leading-relaxed italic">
                    "We matched on Valentine's Day last year and have been inseparable since! Thank you for bringing us together."
                </p>
                <div class="mt-6 flex items-center text-white/70 text-sm">
                    <i class="fas fa-heart text-valentine-300 mr-2"></i>
                    Matched Feb 14, 2025
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="glass rounded-3xl p-8 transform hover:scale-105 transition-all duration-500">
                <div class="flex items-center mb-6">
                    <div class="flex -space-x-3">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">P</div>
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">S</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-white font-bold">Priya & Sanjay</h4>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 leading-relaxed italic">
                    "Never thought I'd find love online, but this platform proved me wrong. Getting married next month!"
                </p>
                <div class="mt-6 flex items-center text-white/70 text-sm">
                    <i class="fas fa-ring text-yellow-300 mr-2"></i>
                    Engaged!
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="glass rounded-3xl p-8 transform hover:scale-105 transition-all duration-500">
                <div class="flex items-center mb-6">
                    <div class="flex -space-x-3">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">K</div>
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-pink-400 to-valentine-500 flex items-center justify-center text-white font-bold text-xl border-3 border-white shadow-lg">M</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-white font-bold">Karan & Meera</h4>
                        <div class="flex text-yellow-400 text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 leading-relaxed italic">
                    "The verification process gave us confidence. We knew we were talking to real people. Best decision ever!"
                </p>
                <div class="mt-6 flex items-center text-white/70 text-sm">
                    <i class="fas fa-heart text-valentine-300 mr-2"></i>
                    Together 1 year
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('couples') }}" class="inline-flex items-center bg-white text-valentine-600 px-8 py-4 rounded-2xl font-bold hover:bg-yellow-300 hover:text-valentine-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                <i class="fas fa-heart-circle-check mr-3"></i>
                View All Success Stories
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-valentine-200 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-200 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-yellow-200 rounded-full blur-3xl opacity-40"></div>
    </div>
    
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="animated-border rounded-3xl overflow-hidden">
            <div class="bg-gradient-to-br from-white to-valentine-50 p-12 md:p-16 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-valentine-500 to-pink-500 rounded-3xl mb-8 shadow-2xl animate-glow">
                    <i class="fas fa-heart text-white text-4xl animate-heartbeat"></i>
                </div>
                
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Ready to Find Your <span class="text-gradient">Valentine?</span>
                </h2>
                
                <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-10">
                    Don't wait! Registration closes on <span class="font-bold text-valentine-600">February 6th, 2026</span>. 
                    Join now and be part of our Valentine's celebration!
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 hover:from-valentine-600 hover:to-pink-600 text-white px-10 py-5 rounded-2xl font-bold text-lg shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-105">
                        <i class="fas fa-heart mr-3"></i>
                        Register Now - It's Free!
                    </a>
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 px-10 py-5 rounded-2xl font-bold text-lg hover:from-gray-200 hover:to-gray-300 transition-all duration-300 flex items-center justify-center shadow">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Already a Member?
                    </a>
                </div>
                
                <!-- Trust Badges -->
                <div class="mt-12 flex flex-wrap justify-center gap-6 text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-shield-check text-green-500 mr-2"></i>
                        <span class="text-sm">100% Verified</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>
                        <span class="text-sm">Secure Platform</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-heart text-valentine-500 mr-2"></i>
                        <span class="text-sm">500+ Matches</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <span class="text-sm">4.9/5 Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
