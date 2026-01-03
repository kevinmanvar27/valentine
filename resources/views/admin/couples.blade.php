@extends('layouts.admin')

@section('title', 'Couples - Admin - Valentine Partner Finder')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold">
            <span class="gradient-text">
                <i class="fas fa-check-circle mr-2"></i> Successful Couples
            </span>
        </h1>
        <p class="text-gray-400 mt-2">All successfully matched couples</p>
    </div>

    @if($couples->count() > 0)
        <!-- Stats Banner -->
        <div class="glass-card rounded-2xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $couples->total() }} Couples</h2>
                        <p class="text-gray-500">Successfully matched and connected</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    @php
                        $sharedCount = $couples->filter(fn($c) => $c->whatsapp_shared)->count();
                        $pendingShareCount = $couples->filter(fn($c) => !$c->whatsapp_shared)->count();
                    @endphp
                    <div class="text-center">
                        <div class="text-xl font-bold text-emerald-600">{{ $sharedCount }}</div>
                        <div class="text-xs text-gray-500">WhatsApp Shared</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-amber-600">{{ $pendingShareCount }}</div>
                        <div class="text-xs text-gray-500">Pending Share</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Couples Grid -->
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($couples as $index => $couple)
                <div class="couple-card rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1"
                     style="opacity: 0; animation: fadeInUp 0.5s ease-out forwards; animation-delay: {{ 0.1 * ($index % 4) }}s;">
                    
                    <!-- Gradient Background -->
                    <div class="relative bg-gradient-to-br from-rose-500 via-pink-500 to-purple-500 p-6">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                        
                        <!-- Couple Display -->
                        <div class="relative flex items-center justify-center gap-4 md:gap-8">
                            <!-- User 1 -->
                            <div class="text-center group">
                                <div class="relative inline-block">
                                    <img src="{{ get_image_url($couple->user1->live_image) }}" 
                                        alt="{{ $couple->user1->full_name }}"
                                        class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-105">
                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full flex items-center justify-center text-xs border-2 border-white
                                        @if($couple->user1->gender === 'male') bg-blue-500 text-white
                                        @elseif($couple->user1->gender === 'female') bg-pink-300 text-pink-800
                                        @else bg-purple-500 text-white @endif">
                                        <i class="fas fa-{{ $couple->user1->gender === 'male' ? 'mars' : ($couple->user1->gender === 'female' ? 'venus' : 'genderless') }}"></i>
                                    </span>
                                </div>
                                <h3 class="font-bold text-white mt-3 text-sm md:text-base">{{ $couple->user1->full_name }}</h3>
                                <p class="text-white/80 text-xs md:text-sm">{{ $couple->user1->age }} yrs</p>
                            </div>
                            
                            <!-- Heart Animation -->
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <div class="text-4xl md:text-5xl animate-heartbeat">❤️</div>
                                    <div class="absolute inset-0 text-4xl md:text-5xl animate-heartbeat-glow opacity-50">❤️</div>
                                </div>
                                <span class="text-white/60 text-xs mt-2 font-medium tracking-wider">MATCHED</span>
                            </div>
                            
                            <!-- User 2 -->
                            <div class="text-center group">
                                <div class="relative inline-block">
                                    <img src="{{ get_image_url($couple->user2->live_image) }}" 
                                        alt="{{ $couple->user2->full_name }}"
                                        class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-105">
                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full flex items-center justify-center text-xs border-2 border-white
                                        @if($couple->user2->gender === 'male') bg-blue-500 text-white
                                        @elseif($couple->user2->gender === 'female') bg-pink-300 text-pink-800
                                        @else bg-purple-500 text-white @endif">
                                        <i class="fas fa-{{ $couple->user2->gender === 'male' ? 'mars' : ($couple->user2->gender === 'female' ? 'venus' : 'genderless') }}"></i>
                                    </span>
                                </div>
                                <h3 class="font-bold text-white mt-3 text-sm md:text-base">{{ $couple->user2->full_name }}</h3>
                                <p class="text-white/80 text-xs md:text-sm">{{ $couple->user2->age }} yrs</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Couple Details Footer -->
                    <div class="bg-gradient-to-br from-white to-valentine-50 p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="space-y-1">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-map-marker-alt text-rose-400 mr-2 w-4"></i> 
                                    {{ $couple->user1->location }}
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-calendar-alt text-rose-400 mr-2 w-4"></i> 
                                    Coupled: {{ $couple->coupled_at->format('d M Y') }}
                                </p>
                            </div>
                            
                            <div>
                                @if($couple->whatsapp_shared)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-emerald-500 to-green-500 text-white shadow-lg">
                                        <i class="fab fa-whatsapp mr-2 text-lg"></i> Connected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-amber-400 to-orange-400 text-white shadow-lg animate-pulse-slow">
                                        <i class="fas fa-clock mr-2"></i> Pending Share
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Time Since Coupled -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-center gap-2 text-gray-400 text-sm">
                                <i class="fas fa-heart text-rose-300"></i>
                                <span>Together for {{ $couple->coupled_at->diffForHumans(null, true) }}</span>
                                <i class="fas fa-heart text-rose-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 animate-fade-in-up">
            {{ $couples->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center animate-fade-in-up">
            <div class="relative w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 animate-pulse-slow"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-heart text-rose-400 text-5xl animate-heartbeat"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">No Couples Yet</h2>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Couples will appear here after both users complete their payments and get connected.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('admin.matches') }}" class="btn-gradient px-6 py-3 rounded-xl font-semibold inline-flex items-center">
                    <i class="fas fa-heart mr-2"></i> View Matches
                </a>
                <a href="{{ route('admin.payments') }}" class="px-6 py-3 rounded-xl font-semibold border-2 border-gray-200 text-gray-600 hover:border-rose-300 hover:text-rose-500 transition inline-flex items-center">
                    <i class="fas fa-credit-card mr-2"></i> Pending Payments
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -10px rgba(244, 63, 94, 0.5);
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }
    
    .animate-heartbeat {
        animation: heartbeat 1.5s ease-in-out infinite;
    }
    
    .animate-heartbeat-glow {
        animation: heartbeat-glow 1.5s ease-in-out infinite;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.02); opacity: 0.9; }
    }
    
    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        10% { transform: scale(1.1); }
        20% { transform: scale(1); }
        30% { transform: scale(1.1); }
        40% { transform: scale(1); }
    }
    
    @keyframes heartbeat-glow {
        0%, 100% { transform: scale(1); filter: blur(0px); }
        10% { transform: scale(1.2); filter: blur(2px); }
        20% { transform: scale(1); filter: blur(0px); }
        30% { transform: scale(1.2); filter: blur(2px); }
        40% { transform: scale(1); filter: blur(0px); }
    }
    
    .couple-card {
        background: white;
    }
</style>
@endsection
