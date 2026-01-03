@extends('layouts.admin')

@section('title', 'Match Payments - Admin - Valentine Partner Finder')

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
    
    .match-card {
        transition: all 0.3s ease;
    }
    
    .match-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.15);
    }
    
    .user-avatar {
        transition: all 0.3s ease;
    }
    
    .user-avatar:hover {
        transform: scale(1.05);
    }
    
    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transition: all 0.3s ease;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
    }
    
    .screenshot-modal {
        display: none;
    }
    
    .screenshot-modal.active {
        display: flex;
    }
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
                    <span>Match <span class="gradient-text">Payments</span></span>
                </h1>
                <p class="text-gray-500 mt-2 ml-15">Review and approve match payments - Both users shown together</p>
            </div>
            
            <!-- Stats Badge -->
            @if($matches->count() > 0)
                <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-100 to-rose-100 rounded-xl border border-pink-200">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center">
                        <i class="fas fa-heart text-white text-sm"></i>
                    </span>
                    <div>
                        <p class="text-xs text-pink-600">Pending Matches</p>
                        <p class="text-xl font-bold text-pink-700">{{ $matches->total() }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($matches->count() > 0)
        <div class="space-y-6">
            @foreach($matches as $match)
                @php
                    $user1 = $match->user1;
                    $user2 = $match->user2;
                    $payment1 = $match->payments->where('user_id', $user1->id)->first();
                    $payment2 = $match->payments->where('user_id', $user2->id)->first();
                @endphp
                
                <div class="match-card glass-card rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
                    <!-- Match Header -->
                    <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-white">
                                <i class="fas fa-heart text-2xl"></i>
                                <div>
                                    <h3 class="font-bold text-lg">Match #{{ $match->id }}</h3>
                                    <p class="text-pink-100 text-sm">Created {{ $match->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($payment1 && $payment1->status === 'verified' && $payment2 && $payment2->status === 'verified')
                                    <span class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-bold">
                                        <i class="fas fa-check-double mr-1"></i> Both Paid
                                    </span>
                                @elseif(($payment1 && $payment1->status === 'verified') || ($payment2 && $payment2->status === 'verified'))
                                    <span class="bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm font-bold">
                                        <i class="fas fa-clock mr-1"></i> Partial Payment
                                    </span>
                                @else
                                    <span class="bg-white/20 text-white px-4 py-2 rounded-xl text-sm font-bold">
                                        <i class="fas fa-hourglass-half mr-1"></i> Awaiting Payments
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Both Users Side by Side -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- User 1 -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border-2 {{ $payment1 && $payment1->status === 'verified' ? 'border-green-300' : ($payment1 && $payment1->status === 'submitted' ? 'border-yellow-300' : 'border-gray-200') }}">
                                <!-- User Info -->
                                <div class="flex items-center gap-4 mb-4">
                                    @if($user1->gallery_images && count($user1->gallery_images) > 0)
                                        <img src="{{ Storage::url($user1->gallery_images[0]) }}" 
                                            alt="{{ $user1->full_name }}"
                                            class="user-avatar w-16 h-16 rounded-full object-cover shadow-lg ring-2 ring-blue-200">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shadow-lg">
                                            <svg class="w-8 h-8 text-blue-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $user1->full_name }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $user1->email }}</p>
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium {{ $user1->gender === 'male' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                            {{ ucfirst($user1->gender) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Payment Status -->
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm text-gray-600 font-medium">Payment Status</span>
                                        @if($payment1)
                                            @if($payment1->status === 'verified')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                                </span>
                                            @elseif($payment1->status === 'submitted')
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-clock mr-1"></i> Submitted
                                                </span>
                                            @elseif($payment1->status === 'rejected')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                                </span>
                                            @endif
                                        @else
                                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">
                                                <i class="fas fa-minus-circle mr-1"></i> Not Created
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($payment1)
                                        <div class="flex items-center justify-between text-sm mb-2">
                                            <span class="text-gray-500">Amount</span>
                                            <span class="font-bold text-gray-800">₹{{ number_format($payment1->amount) }}</span>
                                        </div>
                                        
                                        @if($payment1->payment_screenshot)
                                            <button onclick="openScreenshot('{{ Storage::url($payment1->payment_screenshot) }}', '{{ $user1->full_name }}')" 
                                                class="w-full mt-2 bg-blue-50 text-blue-600 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 transition flex items-center justify-center gap-2">
                                                <i class="fas fa-receipt"></i> View Screenshot
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <!-- User 2 -->
                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-5 border-2 {{ $payment2 && $payment2->status === 'verified' ? 'border-green-300' : ($payment2 && $payment2->status === 'submitted' ? 'border-yellow-300' : 'border-gray-200') }}">
                                <!-- User Info -->
                                <div class="flex items-center gap-4 mb-4">
                                    @if($user2->gallery_images && count($user2->gallery_images) > 0)
                                        <img src="{{ Storage::url($user2->gallery_images[0]) }}" 
                                            alt="{{ $user2->full_name }}"
                                            class="user-avatar w-16 h-16 rounded-full object-cover shadow-lg ring-2 ring-pink-200">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center shadow-lg">
                                            <svg class="w-8 h-8 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $user2->full_name }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $user2->email }}</p>
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium {{ $user2->gender === 'male' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                            {{ ucfirst($user2->gender) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Payment Status -->
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm text-gray-600 font-medium">Payment Status</span>
                                        @if($payment2)
                                            @if($payment2->status === 'verified')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                                </span>
                                            @elseif($payment2->status === 'submitted')
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-clock mr-1"></i> Submitted
                                                </span>
                                            @elseif($payment2->status === 'rejected')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                                </span>
                                            @endif
                                        @else
                                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">
                                                <i class="fas fa-minus-circle mr-1"></i> Not Created
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($payment2)
                                        <div class="flex items-center justify-between text-sm mb-2">
                                            <span class="text-gray-500">Amount</span>
                                            <span class="font-bold text-gray-800">₹{{ number_format($payment2->amount) }}</span>
                                        </div>
                                        
                                        @if($payment2->payment_screenshot)
                                            <button onclick="openScreenshot('{{ Storage::url($payment2->payment_screenshot) }}', '{{ $user2->full_name }}')" 
                                                class="w-full mt-2 bg-pink-50 text-pink-600 py-2 rounded-lg text-sm font-medium hover:bg-pink-100 transition flex items-center justify-center gap-2">
                                                <i class="fas fa-receipt"></i> View Screenshot
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Approval Section -->
                        @php
                            $canApprove = ($payment1 && $payment1->status === 'submitted') || ($payment2 && $payment2->status === 'submitted');
                            $bothVerified = ($payment1 && $payment1->status === 'verified') && ($payment2 && $payment2->status === 'verified');
                        @endphp
                        
                        @if($bothVerified)
                            <div class="mt-6 bg-green-50 border-2 border-green-200 rounded-xl p-4 text-center">
                                <i class="fas fa-check-double text-green-500 text-2xl mb-2"></i>
                                <p class="text-green-700 font-bold">Both payments verified! Match is complete.</p>
                            </div>
                        @elseif($canApprove)
                            <div class="mt-6 pt-6 border-t-2 border-gray-100">
                                <h4 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                                    <i class="fas fa-gavel text-pink-500"></i> Approve Payments
                                </h4>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <!-- Approve User 1 Payment -->
                                    @if($payment1 && $payment1->status === 'submitted')
                                        <form action="{{ route('admin.payments.verify', $payment1) }}" method="POST" class="bg-blue-50 rounded-xl p-4">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <p class="text-sm text-gray-600 mb-3">Approve <strong>{{ $user1->full_name }}</strong>'s payment</p>
                                            <input type="text" name="notes" placeholder="Notes (optional)..."
                                                class="w-full px-3 py-2 rounded-lg border border-blue-200 text-sm mb-3 focus:outline-none focus:border-blue-400">
                                            <div class="flex gap-2">
                                                <button type="submit" class="flex-1 btn-approve text-white py-2 rounded-lg font-semibold text-sm">
                                                    <i class="fas fa-check mr-1"></i> Approve
                                                </button>
                                                <button type="submit" name="action" value="reject" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-semibold text-sm hover:bg-red-200 transition">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @elseif($payment1 && $payment1->status === 'verified')
                                        <div class="bg-green-50 rounded-xl p-4 flex items-center justify-center">
                                            <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-2"></i>{{ $user1->full_name }}'s payment verified</span>
                                        </div>
                                    @else
                                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium"><i class="fas fa-clock mr-2"></i>Waiting for {{ $user1->full_name }}'s payment</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Approve User 2 Payment -->
                                    @if($payment2 && $payment2->status === 'submitted')
                                        <form action="{{ route('admin.payments.verify', $payment2) }}" method="POST" class="bg-pink-50 rounded-xl p-4">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <p class="text-sm text-gray-600 mb-3">Approve <strong>{{ $user2->full_name }}</strong>'s payment</p>
                                            <input type="text" name="notes" placeholder="Notes (optional)..."
                                                class="w-full px-3 py-2 rounded-lg border border-pink-200 text-sm mb-3 focus:outline-none focus:border-pink-400">
                                            <div class="flex gap-2">
                                                <button type="submit" class="flex-1 btn-approve text-white py-2 rounded-lg font-semibold text-sm">
                                                    <i class="fas fa-check mr-1"></i> Approve
                                                </button>
                                                <button type="submit" name="action" value="reject" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-semibold text-sm hover:bg-red-200 transition">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @elseif($payment2 && $payment2->status === 'verified')
                                        <div class="bg-green-50 rounded-xl p-4 flex items-center justify-center">
                                            <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-2"></i>{{ $user2->full_name }}'s payment verified</span>
                                        </div>
                                    @else
                                        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium"><i class="fas fa-clock mr-2"></i>Waiting for {{ $user2->full_name }}'s payment</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mt-6 bg-gray-50 border-2 border-gray-200 rounded-xl p-4 text-center">
                                <i class="fas fa-hourglass-half text-gray-400 text-2xl mb-2"></i>
                                <p class="text-gray-600">Waiting for both users to submit their payments</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($matches->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $matches->links() }}
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
                There are no pending match payments at the moment. 
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

<!-- Screenshot Modal -->
<div id="screenshotModal" class="screenshot-modal fixed inset-0 bg-black/80 backdrop-blur-sm z-50 items-center justify-center p-4" onclick="closeScreenshot()">
    <div class="relative max-w-3xl max-h-[90vh]" onclick="event.stopPropagation()">
        <button onclick="closeScreenshot()" class="absolute -top-12 right-0 text-white hover:text-pink-300 transition">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <p id="screenshotTitle" class="absolute -top-12 left-0 text-white font-medium"></p>
        <img id="screenshotImage" src="" alt="Payment Screenshot" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl">
    </div>
</div>

<script>
    function openScreenshot(url, userName) {
        document.getElementById('screenshotImage').src = url;
        document.getElementById('screenshotTitle').textContent = userName + "'s Payment Screenshot";
        document.getElementById('screenshotModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeScreenshot() {
        document.getElementById('screenshotModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeScreenshot();
    });
</script>
@endsection
