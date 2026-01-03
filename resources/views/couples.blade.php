@extends('layouts.app')

@section('title', 'Our Couples - Valentine Partner Finder')

@section('content')
<!-- Hero Section - Love Stories That Inspire -->
<section class="relative py-24 md:py-32 overflow-hidden">
    <!-- Multi-layer Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-valentine-500 via-pink-500 to-purple-600"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/30 to-transparent"></div>

    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Large floating blobs -->
        <div class="absolute top-10 left-10 w-40 h-40 bg-yellow-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-20 right-10 w-60 h-60 bg-pink-300/20 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-20 left-1/4 w-48 h-48 bg-purple-400/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-10 right-1/3 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-pulse-slow"></div>
        
        <!-- Floating hearts -->
        <div class="absolute top-1/4 left-20 text-4xl animate-float opacity-30" style="animation-delay: 0.5s;">💕</div>
        <div class="absolute top-1/3 right-20 text-3xl animate-float-slow opacity-30" style="animation-delay: 1s;">💗</div>
        <div class="absolute bottom-1/3 left-1/3 text-5xl animate-float opacity-20" style="animation-delay: 1.5s;">💖</div>
        <div class="absolute top-1/2 right-1/4 text-3xl animate-pulse-slow opacity-25">❤️</div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <!-- Badge -->
        <div class="inline-flex items-center bg-gradient-to-r from-white/20 to-white/10 backdrop-blur-sm rounded-full px-6 py-3 mb-8 border border-white/30 shadow-xl">
            <span class="animate-heartbeat mr-3 text-2xl">💕</span>
            <span class="text-white font-semibold tracking-wide">Love Stories That Inspire</span>
            <span class="animate-pulse ml-3 text-2xl">✨</span>
        </div>
        
        <!-- Main Title with Gradient Text -->
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-8">
            <span class="text-white drop-shadow-lg">Our Successful</span>
            <br class="md:hidden">
            <span class="relative inline-block mt-2 md:mt-0 md:ml-4">
                <span class="bg-gradient-to-r from-yellow-300 via-yellow-400 to-orange-400 bg-clip-text text-transparent">Couples</span>
                <!-- Decorative underline -->
                <svg class="absolute -bottom-2 left-0 w-full" height="12" viewBox="0 0 200 12" fill="none">
                    <path d="M2 8C50 2 150 2 198 8" stroke="url(#underline-gradient)" stroke-width="4" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="underline-gradient" x1="0" y1="0" x2="200" y2="0">
                            <stop offset="0%" stop-color="#fcd34d"/>
                            <stop offset="100%" stop-color="#fb923c"/>
                        </linearGradient>
                    </defs>
                </svg>
            </span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed mb-10">
            These beautiful souls found their Valentine through our platform. 
            <br class="hidden md:block">
            <span class="text-yellow-300 font-semibold">Your love story could be next!</span> ✨
        </p>
        
        <!-- Stats Row -->
        <div class="flex flex-wrap justify-center gap-6 md:gap-10">
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/20 shadow-xl">
                <p class="text-3xl md:text-4xl font-bold text-yellow-300">500+</p>
                <p class="text-white/80 text-sm">Happy Couples</p>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/20 shadow-xl">
                <p class="text-3xl md:text-4xl font-bold text-pink-300">98%</p>
                <p class="text-white/80 text-sm">Success Rate</p>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/20 shadow-xl">
                <p class="text-3xl md:text-4xl font-bold text-purple-300">2K+</p>
                <p class="text-white/80 text-sm">Active Users</p>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="url(#wave-gradient)"/>
            <defs>
                <linearGradient id="wave-gradient" x1="0" y1="0" x2="1440" y2="0">
                    <stop offset="0%" stop-color="#fdf2f8"/>
                    <stop offset="50%" stop-color="#fce7f3"/>
                    <stop offset="100%" stop-color="#f3e8ff"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
</section>

<!-- Couples Grid -->
<section class="py-16 bg-gradient-to-br from-valentine-50 via-pink-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($couples->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($couples as $couple)
                    <div class="group bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-lg overflow-hidden card-hover border-2 border-valentine-200">
                        <!-- Couple Photos -->
                        <div class="relative h-72 bg-gradient-to-br from-valentine-400 via-pink-400 to-purple-400 overflow-hidden">
                            <!-- Background Pattern -->

                            
                            <div class="absolute inset-0 flex items-center justify-center">
                                <!-- User 1 Photo -->
                                <div class="relative z-10 transform -translate-x-4 group-hover:-translate-x-6 transition-transform duration-500">
                                    <div class="relative">
                                        <img src="{{ get_image_url($couple->user1->live_image) }}" 
                                            alt="{{ $couple->user1->full_name }}"
                                            class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-white shadow-2xl">
                                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                                            <span class="text-lg">{{ $couple->user1->gender === 'male' ? '👨' : '👩' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Heart -->
                                <div class="relative z-20 mx-2">
                                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-xl animate-pulse">
                                        <span class="text-2xl">❤️</span>
                                    </div>
                                </div>
                                
                                <!-- User 2 Photo -->
                                <div class="relative z-10 transform translate-x-4 group-hover:translate-x-6 transition-transform duration-500">
                                    <div class="relative">
                                        <img src="{{ get_image_url($couple->user2->live_image) }}" 
                                            alt="{{ $couple->user2->full_name }}"
                                            class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-white shadow-2xl">
                                        <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                                            <span class="text-lg">{{ $couple->user2->gender === 'male' ? '👨' : '👩' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Hearts Animation -->
                            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                                @for($i = 0; $i < 5; $i++)
                                <div class="floating-heart-card" style="left: {{ 10 + ($i * 20) }}%; animation-delay: {{ $i * 0.5 }}s;">
                                    @if($i % 2 == 0) 💕 @else 💗 @endif
                                </div>
                                @endfor
                            </div>
                        </div>
                        
                        <!-- Couple Info -->
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ Str::words($couple->user1->full_name, 2, '') }} & {{ Str::words($couple->user2->full_name, 2, '') }}
                            </h3>
                            <p class="text-valentine-500 font-medium flex items-center justify-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> {{ $couple->user1->location }}
                            </p>
                            <p class="text-gray-400 text-sm mt-2 flex items-center justify-center">
                                <i class="fas fa-calendar-heart mr-2"></i>
                                Matched on {{ $couple->coupled_at->format('F d, Y') }}
                            </p>
                            
                            <!-- Common Keywords -->
                            @php
                                $commonKeywords = array_intersect($couple->user1->keywords ?? [], $couple->user2->keywords ?? []);
                            @endphp
                            @if(count($commonKeywords) > 0)
                                <div class="mt-4 flex flex-wrap justify-center gap-2">
                                    @foreach(array_slice($commonKeywords, 0, 3) as $keyword)
                                        <span class="bg-gradient-to-r from-valentine-50 to-pink-50 text-valentine-600 px-3 py-1 rounded-full text-sm font-medium border border-valentine-100">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $couples->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-full mb-6 shadow-xl">
                    <span class="text-5xl">💔</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">No Couples Yet</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Be the first to find your Valentine! Register now and start your love journey.
                </p>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 hover:from-valentine-600 hover:to-pink-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl inline-flex items-center group transition-all duration-300">
                    <i class="fas fa-heart mr-2 group-hover:animate-pulse"></i> Find Your Valentine
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
@if($couples->count() > 0)
<section class="py-20 bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-10 left-10 w-64 h-64 bg-valentine-200 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-pink-200 rounded-full blur-3xl opacity-50"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-2xl p-10 md:p-16 border-2 border-valentine-200">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-valentine-500 to-pink-500 rounded-full mb-6 shadow-xl">
                <i class="fas fa-heart text-white text-3xl animate-pulse"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                Ready to Find Your <span class="text-gradient">Valentine?</span>
            </h2>
            <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto">
                Join thousands of singles who found their perfect match through Valentine Partner Finder.
            </p>
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 hover:from-valentine-600 hover:to-pink-600 text-white px-10 py-5 rounded-full font-bold text-xl shadow-2xl inline-flex items-center group transition-all duration-300 hover:scale-105">
                <i class="fas fa-heart mr-3 group-hover:animate-pulse"></i> 
                Start Your Love Story
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

<style>
    @keyframes float-up-card {
        0% {
            opacity: 0;
            transform: translateY(50px) scale(0.5);
        }
        50% {
            opacity: 0.8;
        }
        100% {
            opacity: 0;
            transform: translateY(-50px) scale(1);
        }
    }
    
    .floating-heart-card {
        position: absolute;
        bottom: -20px;
        font-size: 1.2rem;
        animation: float-up-card 3s ease-in-out infinite;
    }
</style>
@endsection
