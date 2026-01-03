@extends('layouts.app')

@section('title', 'Find Your Valentine Partner - Valentine Partner Finder 2026')

@section('content')
<!-- Hero Section - Clean design -->
<section class="relative min-h-[90vh] flex items-center bg-gray-50 overflow-hidden">
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center bg-rose-100 text-rose-600 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-rose-500 rounded-full mr-2"></span>
                    Valentine's Day 2026 Event
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight font-serif">
                    Find Your
                    <span class="text-rose-500 block">Perfect Valentine</span>
                </h1>
                
                <!-- Subheading -->
                <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0">
                    Join thousands of singles looking for their special someone this Valentine's season. Your love story starts here.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-xl font-semibold text-lg flex items-center justify-center transition-colors">
                        <i class="fas fa-heart mr-2"></i>
                        Find My Valentine
                    </a>
                    <a href="{{ route('couples') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-xl font-semibold text-lg flex items-center justify-center border border-gray-200 transition-colors">
                        <i class="fas fa-play-circle mr-2 text-rose-500"></i>
                        Success Stories
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="flex items-center justify-center lg:justify-start gap-6 mt-8 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-shield-check text-emerald-500 mr-2"></i>
                        Verified Profiles
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>
                        Secure
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Stats Cards -->
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Stat Card 1 -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-users text-rose-500 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">500+</div>
                        <div class="text-gray-500 text-sm">Active Members</div>
                    </div>
                    
                    <!-- Stat Card 2 -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mt-8">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-heart text-emerald-500 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">150+</div>
                        <div class="text-gray-500 text-sm">Matches Made</div>
                    </div>
                    
                    <!-- Stat Card 3 -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-star text-amber-500 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-1">98%</div>
                        <div class="text-gray-500 text-sm">Satisfaction</div>
                    </div>
                    
                    <!-- Stat Card 4 -->
                    <div class="bg-rose-500 rounded-2xl p-6 shadow-sm mt-8">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-calendar-heart text-white text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-white mb-1">7</div>
                        <div class="text-rose-100 text-sm">Days of Love</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block text-rose-500 font-medium mb-2">Simple Process</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-serif">
                How It Works
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Finding your Valentine is easy! Follow these simple steps to start your journey.
            </p>
        </div>
        
        <!-- Steps -->
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-rose-500 transition-colors duration-300">
                        <i class="fas fa-user-plus text-rose-500 text-2xl group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center text-sm font-bold md:right-auto md:left-1/2 md:ml-6">1</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Create Profile</h3>
                <p class="text-gray-500 text-sm">Sign up and create your profile with photos and preferences.</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-rose-500 transition-colors duration-300">
                        <i class="fas fa-credit-card text-rose-500 text-2xl group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center text-sm font-bold md:right-auto md:left-1/2 md:ml-6">2</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Pay & Verify</h3>
                <p class="text-gray-500 text-sm">Complete payment and get verified to access all features.</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-rose-500 transition-colors duration-300">
                        <i class="fas fa-search-heart text-rose-500 text-2xl group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center text-sm font-bold md:right-auto md:left-1/2 md:ml-6">3</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Browse Matches</h3>
                <p class="text-gray-500 text-sm">Explore potential matches and express interest.</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center group">
                <div class="relative mb-6">
                    <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto group-hover:bg-rose-500 transition-colors duration-300">
                        <i class="fas fa-heart text-rose-500 text-2xl group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center text-sm font-bold md:right-auto md:left-1/2 md:ml-6">4</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Find Your Match!</h3>
                <p class="text-gray-500 text-sm">Connect with your Valentine and start your love story!</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block text-rose-500 font-medium mb-2">Why Choose Us</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-serif">
                Features That Make Us Special
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                We've designed every feature with your perfect match in mind.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-shield-check text-emerald-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Verified Profiles</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Every profile is manually verified with live photos to ensure authenticity and safety.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-lock text-blue-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Privacy First</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Your data is secure. Contact details are shared only with mutual matches.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-wand-magic-sparkles text-rose-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Smart Matching</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Our algorithm suggests compatible matches based on your preferences.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-bolt text-amber-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Instant Connect</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Get matched instantly and start connecting with your Valentine right away.</p>
            </div>
            
            <!-- Feature 5 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-alt text-purple-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Limited Time Event</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Exclusive Valentine's week event with special activities and surprise matches.</p>
            </div>
            
            <!-- Feature 6 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-headset text-teal-500 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Our dedicated team is always here to help you on your journey to find love.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-rose-500">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block text-rose-200 font-medium mb-2">Success Stories</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 font-serif">
                Love Stories That Inspire
            </h2>
            <p class="text-rose-100 max-w-2xl mx-auto">
                Real couples who found their perfect match through our platform.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="bg-white/15 rounded-2xl p-6 border border-white/20">
                <div class="flex items-center mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full bg-rose-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">R</div>
                        <div class="w-10 h-10 rounded-full bg-blue-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">A</div>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-white font-semibold">Rahul & Ananya</h4>
                        <div class="flex text-amber-300 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 text-sm leading-relaxed italic">
                    "We matched on Valentine's Day last year and have been inseparable since! Thank you for bringing us together."
                </p>
                <div class="mt-4 flex items-center text-rose-200 text-xs">
                    <i class="fas fa-heart mr-1"></i>
                    Matched Feb 14, 2025
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white/15 rounded-2xl p-6 border border-white/20">
                <div class="flex items-center mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full bg-purple-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">P</div>
                        <div class="w-10 h-10 rounded-full bg-emerald-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">S</div>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-white font-semibold">Priya & Sanjay</h4>
                        <div class="flex text-amber-300 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 text-sm leading-relaxed italic">
                    "Never thought I'd find love online, but this platform proved me wrong. Getting married next month!"
                </p>
                <div class="mt-4 flex items-center text-amber-300 text-xs">
                    <i class="fas fa-ring mr-1"></i>
                    Engaged!
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white/15 rounded-2xl p-6 border border-white/20">
                <div class="flex items-center mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full bg-orange-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">K</div>
                        <div class="w-10 h-10 rounded-full bg-rose-300 flex items-center justify-center text-white font-semibold text-sm border-2 border-white">M</div>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-white font-semibold">Karan & Meera</h4>
                        <div class="flex text-amber-300 text-xs">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-white/90 text-sm leading-relaxed italic">
                    "The verification process gave us confidence. We knew we were talking to real people. Best decision ever!"
                </p>
                <div class="mt-4 flex items-center text-rose-200 text-xs">
                    <i class="fas fa-heart mr-1"></i>
                    Together 1 year
                </div>
            </div>
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('couples') }}" class="inline-flex items-center bg-white text-rose-500 px-6 py-3 rounded-xl font-semibold hover:bg-rose-50 transition-colors">
                View All Stories
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-rose-50 rounded-2xl p-8 md:p-12 text-center border border-rose-100">
            <div class="w-16 h-16 bg-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-serif">
                Ready to Find Your Valentine?
            </h2>
            
            <p class="text-gray-600 max-w-xl mx-auto mb-8">
                Don't wait! Registration closes on <span class="font-semibold text-rose-600">February 6th, 2026</span>. 
                Join now and be part of our Valentine's celebration!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-xl font-semibold text-lg flex items-center justify-center transition-colors">
                    <i class="fas fa-heart mr-2"></i>
                    Register Now - It's Free!
                </a>
                <a href="{{ route('login') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-xl font-semibold text-lg flex items-center justify-center border border-gray-200 transition-colors">
                    Already a Member?
                </a>
            </div>
            
            <!-- Trust Badges -->
            <div class="flex flex-wrap justify-center gap-6 mt-8 text-sm text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-shield-check text-emerald-500 mr-2"></i>
                    100% Verified
                </div>
                <div class="flex items-center">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>
                    Secure Platform
                </div>
                <div class="flex items-center">
                    <i class="fas fa-heart text-rose-500 mr-2"></i>
                    500+ Matches
                </div>
                <div class="flex items-center">
                    <i class="fas fa-star text-amber-500 mr-2"></i>
                    4.9/5 Rating
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
