@extends('layouts.admin')

@section('title', 'All Matches - Admin - Valentine Partner Finder')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold">
            <span class="gradient-text">
                <i class="fas fa-heart mr-2"></i> All Matches
            </span>
        </h1>
        <p class="text-gray-400 mt-2">View all mutual matches between users</p>
    </div>

    @if($matches->count() > 0)
        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            @php
                $completedCount = $matches->where('status', 'completed')->count();
                $pendingCount = $matches->where('status', 'payment_submitted')->count();
                $activeCount = $matches->where('status', 'active')->count();
                $coupledCount = $matches->filter(fn($m) => $m->couple)->count();
            @endphp
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-gray-800">{{ $matches->count() }}</div>
                <div class="text-sm text-gray-500">Total Matches</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-emerald-600">{{ $completedCount }}</div>
                <div class="text-sm text-gray-500">Completed</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-amber-600">{{ $pendingCount }}</div>
                <div class="text-sm text-gray-500">Payment Pending</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-rose-600">{{ $coupledCount }}</div>
                <div class="text-sm text-gray-500">Coupled</div>
            </div>
        </div>
        
        <div class="space-y-6">
            @foreach($matches as $index => $match)
                <div class="match-card glass-card rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300"
                     style="opacity: 0; animation: fadeInUp 0.5s ease-out forwards; animation-delay: {{ 0.1 * ($index % 5) }}s;">
                    <div class="md:flex">
                        <!-- User 1 -->
                        <div class="md:w-5/12 p-6 bg-gradient-to-br from-rose-50 to-pink-50 relative">
                            <div class="flex items-center">
                                <div class="relative">
                                    <img src="{{ get_image_url($match->user1->live_image) }}" 
                                        alt="{{ $match->user1->full_name }}"
                                        class="w-16 h-16 rounded-full object-cover border-3 border-white shadow-lg">
                                    <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center text-xs
                                        @if($match->user1->gender === 'male') bg-blue-500 text-white
                                        @elseif($match->user1->gender === 'female') bg-pink-500 text-white
                                        @else bg-purple-500 text-white @endif">
                                        <i class="fas fa-{{ $match->user1->gender === 'male' ? 'mars' : ($match->user1->gender === 'female' ? 'venus' : 'genderless') }}"></i>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $match->user1->full_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $match->user1->age }} yrs • {{ ucfirst($match->user1->gender) }}</p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt text-rose-400 mr-1"></i> {{ $match->user1->location }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Payment Status for User 1 -->
                            @php $payment1 = $match->payments->where('user_id', $match->user1_id)->first(); @endphp
                            <div class="mt-4">
                                <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                                    @if($payment1 && $payment1->status === 'verified') bg-emerald-100 text-emerald-700 border border-emerald-200
                                    @elseif($payment1 && $payment1->status === 'submitted') bg-amber-100 text-amber-700 border border-amber-200
                                    @else bg-red-100 text-red-700 border border-red-200 @endif">
                                    <i class="fas fa-{{ $payment1 && $payment1->status === 'verified' ? 'check-circle' : ($payment1 && $payment1->status === 'submitted' ? 'clock' : 'exclamation-circle') }} mr-1.5"></i>
                                    Payment: {{ $payment1 ? ucfirst($payment1->status) : 'Pending' }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Heart Connector -->
                        <div class="md:w-2/12 flex items-center justify-center py-6 md:py-0 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="hidden md:block w-full h-0.5 bg-gradient-to-r from-rose-200 via-pink-300 to-rose-200"></div>
                            </div>
                            <div class="relative z-10 w-16 h-16 rounded-full bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center shadow-lg animate-pulse-slow">
                                <i class="fas fa-heart text-white text-2xl"></i>
                            </div>
                        </div>
                        
                        <!-- User 2 -->
                        <div class="md:w-5/12 p-6 bg-gradient-to-br from-pink-50 to-purple-50 relative">
                            <div class="flex items-center">
                                <div class="relative">
                                    <img src="{{ get_image_url($match->user2->live_image) }}" 
                                        alt="{{ $match->user2->full_name }}"
                                        class="w-16 h-16 rounded-full object-cover border-3 border-white shadow-lg">
                                    <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center text-xs
                                        @if($match->user2->gender === 'male') bg-blue-500 text-white
                                        @elseif($match->user2->gender === 'female') bg-pink-500 text-white
                                        @else bg-purple-500 text-white @endif">
                                        <i class="fas fa-{{ $match->user2->gender === 'male' ? 'mars' : ($match->user2->gender === 'female' ? 'venus' : 'genderless') }}"></i>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $match->user2->full_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $match->user2->age }} yrs • {{ ucfirst($match->user2->gender) }}</p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt text-rose-400 mr-1"></i> {{ $match->user2->location }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Payment Status for User 2 -->
                            @php $payment2 = $match->payments->where('user_id', $match->user2_id)->first(); @endphp
                            <div class="mt-4">
                                <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                                    @if($payment2 && $payment2->status === 'verified') bg-emerald-100 text-emerald-700 border border-emerald-200
                                    @elseif($payment2 && $payment2->status === 'submitted') bg-amber-100 text-amber-700 border border-amber-200
                                    @else bg-red-100 text-red-700 border border-red-200 @endif">
                                    <i class="fas fa-{{ $payment2 && $payment2->status === 'verified' ? 'check-circle' : ($payment2 && $payment2->status === 'submitted' ? 'clock' : 'exclamation-circle') }} mr-1.5"></i>
                                    Payment: {{ $payment2 ? ucfirst($payment2->status) : 'Pending' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Match Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- Match Status -->
                            <span class="status-badge px-4 py-2 rounded-full text-sm font-semibold
                                @if($match->status === 'completed') bg-gradient-to-r from-emerald-500 to-green-500 text-white
                                @elseif($match->status === 'payment_submitted') bg-gradient-to-r from-amber-400 to-orange-400 text-white
                                @else bg-gradient-to-r from-rose-500 to-pink-500 text-white @endif">
                                <i class="fas fa-{{ $match->status === 'completed' ? 'check-double' : ($match->status === 'payment_submitted' ? 'hourglass-half' : 'heart') }} mr-1.5"></i>
                                {{ ucfirst(str_replace('_', ' ', $match->status)) }}
                            </span>
                            
                            <!-- Coupled Badge -->
                            @if($match->couple)
                                <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 rounded-full text-sm font-semibold border border-emerald-200">
                                    <i class="fas fa-ring mr-1"></i> Coupled
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>
                                <i class="fas fa-calendar-alt mr-1"></i> {{ $match->created_at->format('d M Y') }}
                            </span>
                            <span>
                                <i class="fas fa-clock mr-1"></i> {{ $match->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 animate-fade-in-up">
            {{ $matches->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center animate-fade-in-up">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                <i class="fas fa-heart-broken text-rose-400 text-4xl animate-bounce-subtle"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">No Matches Yet</h2>
            <p class="text-gray-500 mb-6">Matches will appear here when users mutually accept each other.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('admin.matchmaking') }}" class="btn-gradient px-6 py-3 rounded-xl font-semibold inline-flex items-center">
                    <i class="fas fa-magic mr-2"></i> Start Matchmaking
                </a>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 rounded-xl font-semibold border-2 border-gray-200 text-gray-600 hover:border-rose-300 hover:text-rose-500 transition inline-flex items-center">
                    <i class="fas fa-users mr-2"></i> View Users
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
    
    .status-badge {
        position: relative;
        overflow: hidden;
    }
    
    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 3s infinite;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-bounce-subtle {
        animation: bounce-subtle 2s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
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
    
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .border-3 {
        border-width: 3px;
    }
</style>
@endsection
