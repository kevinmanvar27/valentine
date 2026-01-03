@extends('layouts.admin')

@section('title', 'Pending Payments - Admin - Valentine Partner Finder')

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
        0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        50% { box-shadow: 0 0 20px 5px rgba(16, 185, 129, 0.2); }
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
    
    .payment-card {
        transition: all 0.3s ease;
    }
    
    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.15);
    }
    
    .user-avatar {
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }
    
    .payment-card:hover .user-avatar {
        border-color: #f43f5e;
        transform: scale(1.05);
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
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
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
        border: 2px solid #e5e7eb;
    }
    
    .input-modern:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .input-reject {
        border-color: #fecaca;
    }
    
    .input-reject:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .amount-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        position: relative;
        overflow: hidden;
    }
    
    .amount-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 3s infinite;
    }
    
    .match-connector {
        position: relative;
    }
    
    .match-connector::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #f43f5e, transparent);
        transform: translateY(-50%);
    }
    
    /* Staggered animation delays */
    .payment-card:nth-child(1) { animation-delay: 0.1s; }
    .payment-card:nth-child(2) { animation-delay: 0.2s; }
    .payment-card:nth-child(3) { animation-delay: 0.3s; }
    .payment-card:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-credit-card text-white text-lg"></i>
                    </span>
                    <span>Pending <span class="gradient-text">Payments</span></span>
                </h1>
                <p class="text-gray-500 mt-2 ml-15">Review and verify match payments from users</p>
            </div>
            
            <!-- Stats Badge -->
            @if($payments->count() > 0)
                <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-100 to-green-100 rounded-xl border border-emerald-200">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                        <i class="fas fa-rupee-sign text-white text-sm"></i>
                    </span>
                    <div>
                        <p class="text-xs text-emerald-600">Awaiting Verification</p>
                        <p class="text-xl font-bold text-emerald-700">{{ $payments->total() }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($payments->count() > 0)
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($payments as $payment)
                @php
                    $partner = $payment->match->user1_id === $payment->user_id 
                        ? $payment->match->user2 
                        : $payment->match->user1;
                @endphp
                <div class="payment-card glass-card rounded-2xl shadow-xl overflow-hidden animate-fade-in-up" style="opacity: 0;">
                    <div class="p-6">
                        <!-- Match Header - Both Users -->
                        <div class="flex items-center justify-between mb-6">
                            <!-- Payer -->
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="{{ get_image_url($payment->user->live_image) }}" 
                                        alt="{{ $payment->user->full_name }}"
                                        class="user-avatar w-14 h-14 rounded-full object-cover shadow-md">
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs
                                        {{ $payment->user->gender === 'male' ? 'bg-blue-500' : ($payment->user->gender === 'female' ? 'bg-pink-500' : 'bg-purple-500') }} text-white shadow">
                                        {{ $payment->user->gender === 'male' ? '♂' : ($payment->user->gender === 'female' ? '♀' : '⚧') }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $payment->user->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Heart Connector -->
                            <div class="flex-shrink-0 px-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                    <i class="fas fa-heart text-rose-500"></i>
                                </div>
                            </div>
                            
                            <!-- Partner -->
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <p class="font-bold text-gray-800">{{ $partner->full_name }}</p>
                                    <p class="text-xs text-gray-500">Match Partner</p>
                                </div>
                                <div class="relative">
                                    <img src="{{ get_image_url($partner->live_image) }}" 
                                        alt="{{ $partner->full_name }}"
                                        class="w-14 h-14 rounded-full object-cover shadow-md ring-2 ring-rose-200">
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs
                                        {{ $partner->gender === 'male' ? 'bg-blue-500' : ($partner->gender === 'female' ? 'bg-pink-500' : 'bg-purple-500') }} text-white shadow">
                                        {{ $partner->gender === 'male' ? '♂' : ($partner->gender === 'female' ? '♀' : '⚧') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Details Card -->
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4 mb-5 border border-emerald-100">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                        <i class="fas fa-rupee-sign text-emerald-600 text-sm"></i>
                                    </span>
                                    <span class="text-sm text-gray-600">Payment Amount</span>
                                </div>
                                <span class="amount-badge px-4 py-1.5 rounded-full text-white font-bold shadow-md">
                                    ₹{{ number_format($payment->amount) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                        <i class="fas fa-tag text-emerald-600 text-sm"></i>
                                    </span>
                                    <span class="text-sm text-gray-600">Payment Type</span>
                                </div>
                                <span class="px-3 py-1 bg-white rounded-full text-sm font-medium text-gray-700 shadow-sm">
                                    {{ ucfirst($payment->payment_type) }} Payment
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                        <i class="fas fa-clock text-amber-600 text-sm"></i>
                                    </span>
                                    <span class="text-sm text-gray-600">Submitted</span>
                                </div>
                                <span class="text-sm text-gray-700">{{ $payment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        <!-- Payment Screenshot -->
                        @if($payment->payment_screenshot)
                            <div class="mb-5">
                                <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-receipt text-emerald-500"></i> Payment Screenshot
                                </p>
                                <a href="{{ Storage::url($payment->payment_screenshot) }}" target="_blank" class="block">
                                    <div class="screenshot-container border-2 border-gray-100">
                                        <img src="{{ Storage::url($payment->payment_screenshot) }}" 
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
                            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <input type="text" name="notes" placeholder="Add notes (optional)..."
                                    class="input-modern w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none text-sm mb-3">
                                <button type="submit" class="btn-approve w-full text-white py-3 rounded-xl font-semibold shadow-lg flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Approve Payment
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST"
                                x-data="{ showReason: false }">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                
                                <!-- Rejection Reason Input -->
                                <div x-show="showReason" x-transition class="mb-3">
                                    <input type="text" name="notes" placeholder="Enter rejection reason..." required
                                        class="input-modern input-reject w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none text-sm">
                                </div>
                                
                                <!-- Initial Reject Button -->
                                <button type="button" x-show="!showReason" @click="showReason = true"
                                    class="btn-reject w-full bg-red-50 text-red-600 py-3 rounded-xl font-semibold border-2 border-red-200 hover:bg-red-100 flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle"></i> Reject Payment
                                </button>
                                
                                <!-- Confirm Rejection Buttons -->
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
        @if($payments->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $payments->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl shadow-xl p-12 text-center animate-fade-in-up">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center mx-auto mb-6 animate-bounce-subtle">
                <i class="fas fa-check-circle text-5xl text-emerald-500"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">All Caught Up! 💚</h2>
            <p class="text-gray-500 max-w-md mx-auto">
                There are no pending payment verifications at the moment. 
                New payment submissions will appear here automatically.
            </p>
            <div class="mt-8 flex items-center justify-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-500 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                    <i class="fas fa-home mr-2"></i> Back to Dashboard
                </a>
                <a href="{{ route('admin.matches') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-all">
                    <i class="fas fa-heart mr-2"></i> View All Matches
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    // Trigger staggered animations
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.payment-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
            }, index * 150);
        });
    });
</script>
@endsection
