@extends('layouts.app')

@section('title', 'Unlock Match Contact - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/2 left-1/4 w-56 h-56 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 1s;"></div>
    </div>
    
    <!-- Header -->
    <div class="gradient-bg-animated relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('user.matches') }}" class="text-white/80 hover:text-white transition-colors mb-4 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Matches
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center">
                        <i class="fas fa-unlock mr-4"></i>
                        Unlock Contact
                    </h1>
                    <p class="text-white/80 mt-2">Get connected with your match!</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Match Preview -->
            <div class="space-y-6">
                <!-- Match Card -->
                <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-xl overflow-hidden border-2 border-valentine-200 animate-fade-in">
                    <div class="relative h-64 overflow-hidden">
                        @if($partner->gallery_images && count($partner->gallery_images) > 0)
                            <img src="{{ Storage::url($partner->gallery_images[0]) }}" alt="{{ $partner->full_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-valentine-100 to-pink-100 flex items-center justify-center">
                                <i class="fas fa-user text-valentine-300 text-6xl"></i>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        
                        <!-- Match Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-valentine-500 text-white px-4 py-2 rounded-xl text-sm font-bold flex items-center shadow-lg">
                                <i class="fas fa-heart mr-2 animate-heartbeat"></i>It's a Match!
                            </span>
                        </div>
                        
                        <!-- Basic Info Overlay -->
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-2xl font-bold mb-1">{{ $partner->full_name }}, {{ $partner->age }}</h3>
                            <p class="text-white/90 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $partner->location }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($partner->bio)
                            <p class="text-gray-600 mb-4">{{ $partner->bio }}</p>
                        @endif
                        
                        <!-- Keywords -->
                        @if($partner->keywords && count($partner->keywords) > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($partner->keywords as $keyword)
                                    <span class="bg-valentine-100 text-valentine-700 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Locked Contact Info -->
                        <div class="bg-gradient-to-r from-valentine-50 to-pink-50 rounded-xl p-4 border-2 border-valentine-200">
                            <div class="flex items-center justify-center text-valentine-500 py-4">
                                <i class="fas fa-lock text-2xl mr-3"></i>
                                <div>
                                    <p class="font-medium text-valentine-700">Contact details locked</p>
                                    <p class="text-sm text-valentine-500">Pay to unlock WhatsApp & Instagram</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- What You'll Get -->
                <div class="bg-gradient-to-r from-green-50 via-purple-50 to-blue-50 rounded-2xl shadow-lg p-6 border-2 border-green-200">
                    <h3 class="font-bold text-gray-900 mb-4">After both payments verified, you'll get:</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3 shadow">
                                <i class="fab fa-whatsapp text-white"></i>
                            </div>
                            <span class="font-medium">WhatsApp number</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3 shadow">
                                <i class="fab fa-instagram text-white"></i>
                            </div>
                            <span class="font-medium">Instagram profile</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 shadow">
                                <i class="fas fa-comments text-white"></i>
                            </div>
                            <span class="font-medium">Direct messaging access</span>
                        </div>
                    </div>
                    
                    <!-- Important Note -->
                    <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-yellow-800 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Contact details will be shared only after <strong>both</strong> you and your match complete the payment.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <div class="bg-gradient-to-br from-white to-pink-50 rounded-3xl shadow-xl p-8 border-2 border-valentine-200 animate-fade-in" style="animation-delay: 0.1s;">
                <!-- Amount -->
                <div class="text-center mb-8 bg-gradient-to-r from-valentine-500 to-pink-500 rounded-2xl p-6 -mx-2">
                    <span class="text-white/80">Unlock Fee</span>
                    <div class="text-4xl font-bold text-white mt-2">
                        ₹<span class="text-yellow-300">{{ number_format($payment->amount, 0) }}</span>
                    </div>
                    <p class="text-white/70 mt-1">
                        {{ $payment->payment_type === 'full' ? 'Mutual Match' : 'One-sided' }} Payment
                    </p>
                </div>
                
                <!-- Payment Status (if already submitted) -->
                @if($payment->status === 'submitted')
                    <div class="bg-yellow-50 rounded-xl p-6 mb-6 border border-yellow-200 text-center">
                        <i class="fas fa-clock text-yellow-500 text-4xl mb-3"></i>
                        <h3 class="font-bold text-yellow-800 mb-2">Payment Under Review</h3>
                        <p class="text-yellow-700 text-sm">Your payment screenshot has been submitted. Please wait for admin verification.</p>
                        @if($payment->transaction_id)
                            <p class="text-yellow-600 text-xs mt-2">Transaction ID: {{ $payment->transaction_id }}</p>
                        @endif
                    </div>
                @elseif($payment->status === 'verified')
                    <div class="bg-green-50 rounded-xl p-6 mb-6 border border-green-200 text-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                        <h3 class="font-bold text-green-800 mb-2">Payment Verified!</h3>
                        <p class="text-green-700 text-sm">Waiting for your match partner to complete their payment.</p>
                    </div>
                @elseif($payment->status === 'rejected')
                    <div class="bg-red-50 rounded-xl p-6 mb-6 border border-red-200">
                        <div class="text-center mb-4">
                            <i class="fas fa-times-circle text-red-500 text-4xl mb-3"></i>
                            <h3 class="font-bold text-red-800 mb-2">Payment Rejected</h3>
                            <p class="text-red-700 text-sm">Please resubmit a valid payment screenshot.</p>
                        </div>
                        @if($payment->admin_notes)
                            <div class="bg-red-100 rounded-lg p-3">
                                <p class="text-red-800 text-sm"><strong>Reason:</strong> {{ $payment->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
                
                @if($payment->status === 'pending' || $payment->status === 'rejected')
                    <!-- QR Code -->
                    <div class="bg-gradient-to-br from-valentine-50 to-pink-50 rounded-2xl p-6 mb-6 text-center border border-valentine-100">
                        <div class="bg-gradient-to-br from-white to-valentine-50 rounded-xl p-4 inline-block shadow-lg mb-4 border border-valentine-100">
                            @if($paymentQR)
                                <img src="{{ Storage::url($paymentQR) }}" alt="Payment QR Code" class="w-40 h-40 mx-auto">
                            @else
                                <div class="w-40 h-40 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-qrcode text-gray-300 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm">Scan with any UPI app</p>
                    </div>
                    
                    <!-- UPI ID -->
                    <div class="bg-valentine-50 rounded-xl p-4 mb-6 border border-valentine-100">
                        <p class="text-valentine-800 text-sm font-medium mb-2">Or pay directly to UPI ID:</p>
                        <div class="flex items-center justify-between bg-gradient-to-r from-white to-valentine-50 rounded-lg px-4 py-3 border border-valentine-100">
                            <span class="font-mono text-gray-900" id="upiId">{{ $paymentUPI ?? 'valentine@upi' }}</span>
                            <button onclick="copyUPI()" class="text-valentine-600 hover:text-valentine-700 transition-colors">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <form action="{{ route('user.matches.payment.submit', $match->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Transaction ID -->
                        <div class="mb-6">
                            <label for="transaction_id" class="block text-sm font-semibold text-gray-700 mb-2">Transaction ID / UTR Number</label>
                            <input type="text" name="transaction_id" id="transaction_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('transaction_id') border-red-500 @enderror"
                                placeholder="Enter 12-digit UTR number">
                            @error('transaction_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Screenshot Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Screenshot <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div id="screenshotPreview" class="w-full h-40 rounded-xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center transition-all duration-300 group-hover:border-valentine-400 cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-500 text-sm">Click to upload</p>
                                    </div>
                                </div>
                                <input type="file" name="payment_screenshot" id="screenshotInput" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            @error('payment_screenshot')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Payment
                        </button>
                    </form>
                @endif
                
                <!-- Help Text -->
                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <p class="text-gray-600 text-sm">
                        <i class="fas fa-info-circle text-valentine-500 mr-2"></i>
                        Payment will be verified within 24 hours. Contact will be shared after both payments are verified.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Screenshot preview
document.getElementById('screenshotInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('screenshotPreview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain">`;
        };
        reader.readAsDataURL(file);
    }
});

// Copy UPI ID
function copyUPI() {
    const upiId = document.getElementById('upiId').textContent;
    navigator.clipboard.writeText(upiId).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>UPI ID copied!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 2000);
    });
}
</script>
@endpush
@endsection