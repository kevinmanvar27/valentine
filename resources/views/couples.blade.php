@extends('layouts.app')

@section('title', 'Our Couples - Valentine Partner Finder')

@section('content')
<!-- Hero Section - Clean design -->
<section class="bg-rose-500 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center bg-white/20 rounded-full px-5 py-2 mb-6">
            <span class="mr-2 text-lg">💕</span>
            <span class="text-white font-medium">Love Stories That Inspire</span>
        </div>
        
        <!-- Main Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 font-serif">
            Our Successful <span class="text-amber-300">Couples</span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-8">
            These beautiful souls found their Valentine through our platform. 
            <span class="text-amber-300 font-medium">Your love story could be next!</span>
        </p>
        
        <!-- Stats Row -->
        <div class="flex flex-wrap justify-center gap-4 md:gap-6">
            <div class="bg-white/15 rounded-xl px-5 py-3">
                <p class="text-2xl md:text-3xl font-bold text-amber-300">500+</p>
                <p class="text-white/80 text-sm">Happy Couples</p>
            </div>
            <div class="bg-white/15 rounded-xl px-5 py-3">
                <p class="text-2xl md:text-3xl font-bold text-pink-300">98%</p>
                <p class="text-white/80 text-sm">Success Rate</p>
            </div>
            <div class="bg-white/15 rounded-xl px-5 py-3">
                <p class="text-2xl md:text-3xl font-bold text-purple-300">2K+</p>
                <p class="text-white/80 text-sm">Active Users</p>
            </div>
        </div>
    </div>
</section>

<!-- Couples Grid - Clean design -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($couples->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($couples as $couple)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                        <!-- Couple Photos -->
                        <div class="relative h-56 bg-rose-500 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <!-- User 1 Photo -->
                                <div class="relative z-10 -mr-3">
                                    <div class="relative">
                                        <img src="{{ get_image_url($couple->user1->live_image) }}" 
                                            alt="{{ $couple->user1->full_name }}"
                                            class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-white shadow-lg">
                                        <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow">
                                            <span class="text-sm">{{ $couple->user1->gender === 'male' ? '👨' : '👩' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Heart -->
                                <div class="relative z-20 mx-1">
                                    <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl">❤️</span>
                                    </div>
                                </div>
                                
                                <!-- User 2 Photo -->
                                <div class="relative z-10 -ml-3">
                                    <div class="relative">
                                        <img src="{{ get_image_url($couple->user2->live_image) }}" 
                                            alt="{{ $couple->user2->full_name }}"
                                            class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-white shadow-lg">
                                        <div class="absolute -bottom-1 -left-1 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow">
                                            <span class="text-sm">{{ $couple->user2->gender === 'male' ? '👨' : '👩' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Couple Info -->
                        <div class="p-5 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 font-serif">
                                {{ Str::words($couple->user1->full_name, 2, '') }} & {{ Str::words($couple->user2->full_name, 2, '') }}
                            </h3>
                            <p class="text-rose-500 font-medium flex items-center justify-center text-sm">
                                <i class="fas fa-map-marker-alt mr-1.5"></i> {{ $couple->user1->location }}
                            </p>
                            <p class="text-gray-400 text-sm mt-1.5 flex items-center justify-center">
                                <i class="fas fa-calendar-alt mr-1.5"></i>
                                Matched on {{ $couple->coupled_at->format('F d, Y') }}
                            </p>
                            
                            <!-- Common Keywords -->
                            @php
                                $commonKeywords = array_intersect($couple->user1->keywords ?? [], $couple->user2->keywords ?? []);
                            @endphp
                            @if(count($commonKeywords) > 0)
                                <div class="mt-3 flex flex-wrap justify-center gap-1.5">
                                    @foreach(array_slice($commonKeywords, 0, 3) as $keyword)
                                        <span class="bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full text-xs font-medium border border-rose-100">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10">
                {{ $couples->links() }}
            </div>
        @else
            <!-- Empty State - Clean design -->
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <span class="text-4xl">💔</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3 font-serif">No Couples Yet</h2>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Be the first to find your Valentine! Register now and start your love journey.
                </p>
                <a href="{{ route('register') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center transition-colors">
                    <i class="fas fa-heart mr-2"></i> Find Your Valentine
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section - Clean design -->
@if($couples->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-rose-50 rounded-2xl p-8 md:p-12 border border-rose-100">
            <div class="w-16 h-16 bg-rose-500 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 font-serif">
                Ready to Find Your Valentine?
            </h2>
            <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                Join thousands of singles who found their perfect match through Valentine Partner Finder.
            </p>
            <a href="{{ route('register') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center transition-colors">
                <i class="fas fa-heart mr-2"></i> 
                Start Your Love Story
            </a>
        </div>
    </div>
</section>
@endif
@endsection
