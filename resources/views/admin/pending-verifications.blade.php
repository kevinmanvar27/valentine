@extends('layouts.admin')

@section('title', 'Pending Verifications - Admin - Valentine Partner Finder')

@section('content')
<style>
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
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
        50% { box-shadow: 0 0 20px 5px rgba(244, 63, 94, 0.2); }
    }
    
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-bounce-subtle {
        animation: bounce-subtle 2s ease-in-out infinite;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .verification-card {
        transition: all 0.3s ease;
    }
    
    .verification-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(244, 63, 94, 0.15);
    }
    
    .profile-image-container {
        position: relative;
        overflow: hidden;
    }
    
    .profile-image-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    }
    
    .screenshot-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    
    .screenshot-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .screenshot-container:hover::before {
        opacity: 1;
    }
    
    .screenshot-container img {
        transition: transform 0.3s ease;
    }
    
    .screenshot-container:hover img {
        transform: scale(1.02);
    }
    
    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transition: all 0.3s ease;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
    }
    
    .btn-reject {
        transition: all 0.3s ease;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
    }
    
    .btn-reject-confirm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        transition: all 0.3s ease;
    }
    
    .btn-reject-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.35);
    }
    
    .input-modern {
        transition: all 0.3s ease;
        border: 2px solid #fecaca;
    }
    
    .input-modern:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .info-badge {
        transition: all 0.2s ease;
    }
    
    .info-badge:hover {
        transform: scale(1.05);
    }
    
    .pending-indicator {
        position: relative;
    }
    
    .pending-indicator::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 12px;
        height: 12px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 50%;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
    }
    
    /* Staggered animation delays */
    .verification-card:nth-child(1) { animation-delay: 0.1s; }
    .verification-card:nth-child(2) { animation-delay: 0.2s; }
    .verification-card:nth-child(3) { animation-delay: 0.3s; }
    .verification-card:nth-child(4) { animation-delay: 0.4s; }
    .verification-card:nth-child(5) { animation-delay: 0.5s; }
    .verification-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-clock text-white text-lg"></i>
                    </span>
                    <span>Pending <span class="gradient-text">Verifications</span></span>
                </h1>
                <p class="text-gray-500 mt-2 ml-15">Review and verify registration payments from new users</p>
            </div>
            
            <!-- Stats Badge -->
            @if($users->count() > 0)
                <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-orange-100 rounded-xl border border-amber-200">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-white text-sm"></i>
                    </span>
                    <div>
                        <p class="text-xs text-amber-600">Awaiting Review</p>
                        <p class="text-xl font-bold text-amber-700">{{ $users->total() }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($users->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
                <div class="verification-card glass-card rounded-2xl shadow-xl overflow-hidden animate-fade-in-up" style="opacity: 0;">
                    <!-- Profile Image -->
                    <div class="profile-image-container relative">
                        <img src="{{ Storage::url($user->live_image) }}" 
                            alt="{{ $user->full_name }}"
                            class="w-full h-48 object-cover">
                        
                        <!-- Pending Badge -->
                        <div class="absolute top-4 right-4 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-amber-400 to-orange-400 text-white shadow-lg">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        </div>
                        
                        <!-- User Info Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 z-10">
                            <h3 class="text-xl font-bold text-white">{{ $user->full_name }}</h3>
                            <p class="text-white/80 text-sm flex items-center gap-2">
                                <span>{{ $user->age }} years</span>
                                <span class="w-1 h-1 rounded-full bg-white/60"></span>
                                <span>{{ ucfirst($user->gender) }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Contact Info -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-rose-500 text-xs"></i>
                                </span>
                                <span>{{ $user->location }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-rose-500 text-xs"></i>
                                </span>
                                <span class="truncate">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-7 h-7 rounded-lg bg-rose-100 flex items-center justify-center">
                                    <i class="fas fa-phone text-rose-500 text-xs"></i>
                                </span>
                                <span>{{ $user->mobile_number }}</span>
                            </div>
                        </div>
                        
                        <!-- Registration Date -->
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Registered {{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <!-- Payment Screenshot -->
                        @if($user->registration_payment_screenshot)
                            <div class="mb-5">
                                <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-receipt text-emerald-500"></i> Payment Screenshot
                                </p>
                                <a href="{{ Storage::url($user->registration_payment_screenshot) }}" target="_blank" class="block">
                                    <div class="screenshot-container border-2 border-gray-100">
                                        <img src="{{ Storage::url($user->registration_payment_screenshot) }}" 
                                            alt="Payment Screenshot" 
                                            class="w-full rounded-lg">
                                        <div class="absolute inset-0 flex items-center justify-center z-10 opacity-0 hover:opacity-100 transition-opacity">
                                            <span class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg text-sm font-medium text-gray-700 shadow-lg">
                                                <i class="fas fa-expand mr-1"></i> View Full Size
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="mb-5 p-4 bg-amber-50 rounded-xl border border-amber-200">
                                <p class="text-sm text-amber-700 flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No payment screenshot uploaded
                                </p>
                            </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="space-y-3">
                            <form action="{{ route('admin.verifications.verify', $user) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn-approve w-full text-white py-3 rounded-xl font-semibold shadow-lg flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Approve Registration
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.verifications.verify', $user) }}" method="POST" 
                                x-data="{ showReason: false }">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                
                                <!-- Rejection Reason Input -->
                                <div x-show="showReason" x-transition class="mb-3">
                                    <input type="text" name="reason" placeholder="Enter rejection reason..." required
                                        class="input-modern w-full px-4 py-3 rounded-xl bg-white focus:outline-none text-sm">
                                </div>
                                
                                <!-- Initial Reject Button -->
                                <button type="button" x-show="!showReason" @click="showReason = true"
                                    class="btn-reject w-full bg-red-50 text-red-600 py-3 rounded-xl font-semibold border-2 border-red-200 hover:bg-red-100 flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle"></i> Reject
                                </button>
                                
                                <!-- Confirm Rejection Button -->
                                <div x-show="showReason" class="flex gap-2">
                                    <button type="button" @click="showReason = false"
                                        class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-medium hover:bg-gray-200 transition">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="btn-reject-confirm flex-1 text-white py-3 rounded-xl font-semibold shadow-lg flex items-center justify-center gap-2">
                                        <i class="fas fa-times-circle"></i> Confirm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl shadow-xl p-12 text-center animate-fade-in-up">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center mx-auto mb-6 animate-bounce-subtle">
                <i class="fas fa-check-circle text-5xl text-emerald-500"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">All Caught Up! 🎉</h2>
            <p class="text-gray-500 max-w-md mx-auto">
                There are no pending registration verifications at the moment. 
                New submissions will appear here automatically.
            </p>
            <div class="mt-8 flex items-center justify-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-500 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                    <i class="fas fa-home mr-2"></i> Back to Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all">
                    <i class="fas fa-users mr-2"></i> View All Users
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    // Trigger staggered animations
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.verification-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
            }, index * 100);
        });
    });
</script>
@endsection
