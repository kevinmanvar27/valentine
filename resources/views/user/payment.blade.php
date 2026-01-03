@extends('layouts.app')

@section('title', 'Complete Payment - Valentine Partner Finder')

@section('content')
<!-- Clean background - no animated decorations -->
<div class="min-h-screen bg-gray-50">
    
    <!-- Header - Clean rose background -->
    <div class="bg-rose-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div>
                <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-3 inline-flex items-center text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-white flex items-center font-serif">
                    <i class="fas fa-crown mr-3 text-amber-300"></i>
                    Complete Payment
                </h1>
                <p class="text-white/80 mt-1">Unlock all premium features and start matching!</p>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Payment Details -->
            <div class="space-y-5">
                <!-- Amount Card - Clean rose card -->
                <div class="bg-rose-500 rounded-2xl shadow-sm p-6">
                    <div class="text-center mb-6">
                        <span class="text-white/80">Registration Fee</span>
                        <div class="text-4xl font-bold text-white mt-2 font-serif">
                            ₹<span class="text-amber-300">{{ $registrationFee }}</span>
                        </div>
                        <p class="text-white/70 mt-1 text-sm">One-time payment</p>
                    </div>
                    
                    <!-- Features Included -->
                    <div class="space-y-3">
                        <h3 class="font-semibold text-white mb-3">What you'll get:</h3>
                        <div class="flex items-center text-white/90 text-sm">
                            <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-amber-300 text-xs"></i>
                            </div>
                            <span>Unlimited match suggestions</span>
                        </div>
                        <div class="flex items-center text-white/90 text-sm">
                            <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-amber-300 text-xs"></i>
                            </div>
                            <span>View who liked your profile</span>
                        </div>
                        <div class="flex items-center text-white/90 text-sm">
                            <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-amber-300 text-xs"></i>
                            </div>
                            <span>Unlock contact details of matches</span>
                        </div>
                        <div class="flex items-center text-white/90 text-sm">
                            <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-amber-300 text-xs"></i>
                            </div>
                            <span>Priority profile visibility</span>
                        </div>
                        <div class="flex items-center text-white/90 text-sm">
                            <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-amber-300 text-xs"></i>
                            </div>
                            <span>Access for entire Valentine's week</span>
                        </div>
                    </div>
                </div>
                
                <!-- Trust Badges - Clean card -->
                <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center justify-center gap-6 text-emerald-700">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-shield-alt text-emerald-500 mr-2"></i>
                            <span class="font-medium">Secure Payment</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-lock text-emerald-500 mr-2"></i>
                            <span class="font-medium">SSL Encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="space-y-5" x-data="{ activeTab: '{{ $razorpayEnabled ? 'razorpay' : 'upi' }}' }">
                
                @if($razorpayEnabled && $googlePayEnabled)
                <!-- Payment Method Tabs - Clean design -->
                <div class="bg-white rounded-xl p-1.5 shadow-sm border border-gray-100 flex gap-1.5">
                    <button @click="activeTab = 'razorpay'" 
                        :class="activeTab === 'razorpay' ? 'bg-rose-500 text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                        class="flex-1 py-2.5 px-4 rounded-lg font-medium transition-colors flex items-center justify-center text-sm">
                        <i class="fas fa-credit-card mr-2"></i> Razorpay
                    </button>
                    <button @click="activeTab = 'upi'" 
                        :class="activeTab === 'upi' ? 'bg-emerald-500 text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                        class="flex-1 py-2.5 px-4 rounded-lg font-medium transition-colors flex items-center justify-center text-sm">
                        <i class="fas fa-mobile-alt mr-2"></i> UPI / GPay
                    </button>
                </div>
                @endif
                
                @if($razorpayEnabled)
                <!-- Razorpay Payment - Clean card -->
                <div x-show="activeTab === 'razorpay'" x-transition class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-credit-card text-blue-500"></i>
                        </div>
                        Pay with Razorpay
                    </h2>
                    
                    <div class="text-center mb-5">
                        <p class="text-gray-600 text-sm mb-4">Pay securely using UPI, Cards, Net Banking, or Wallets</p>
                        <div class="flex justify-center gap-4 mb-5">
                            <img src="https://cdn.razorpay.com/static/assets/logo/payment.svg" alt="Payment Methods" class="h-7">
                        </div>
                    </div>
                    
                    <button id="razorpayBtn" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                        <i class="fas fa-lock mr-2"></i> Pay ₹{{ $registrationFee }} Securely
                    </button>
                    
                    <p class="text-center text-gray-500 text-sm mt-4">
                        <i class="fas fa-bolt text-amber-500 mr-1"></i> Instant verification - No waiting!
                    </p>
                </div>
                @endif
                
                @if($googlePayEnabled)
                <!-- UPI / Google Pay Payment - Clean card -->
                <div x-show="activeTab === 'upi'" x-transition class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-qrcode text-emerald-500"></i>
                        </div>
                        Pay via UPI / Google Pay
                    </h2>
                    
                    <!-- QR Code -->
                    <div class="bg-gray-50 rounded-xl p-5 mb-5 text-center border border-gray-100">
                        <div class="bg-white rounded-lg p-3 inline-block shadow-sm mb-3 border border-gray-100">
                            @if($paymentQR)
                                <img src="{{ Storage::url($paymentQR) }}" alt="Payment QR Code" class="w-44 h-44 mx-auto">
                            @else
                                <div class="w-44 h-44 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-qrcode text-gray-300 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-500 text-sm">Scan with any UPI app</p>
                    </div>
                    
                    <!-- UPI ID -->
                    <div class="bg-emerald-50 rounded-xl p-4 mb-5 border border-emerald-100">
                        <p class="text-emerald-800 text-sm font-medium mb-2">Or pay directly to UPI ID:</p>
                        <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2.5 border border-emerald-100">
                            <span class="font-mono text-gray-900 text-sm" id="upiId">{{ $paymentUPI }}</span>
                            <button type="button" onclick="copyUPI()" class="text-emerald-600 hover:text-emerald-700 transition-colors">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <form action="{{ route('user.payment.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Screenshot Upload -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Screenshot</label>
                            <div class="relative group">
                                <div id="screenshotPreview" class="w-full h-40 rounded-xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center transition-all group-hover:border-rose-300 cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-500 text-sm">Click to upload screenshot</p>
                                        <p class="text-gray-400 text-xs mt-1">Max 5MB, JPG/PNG</p>
                                    </div>
                                </div>
                                <input type="file" name="payment_screenshot" id="screenshotInput" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            @error('payment_screenshot')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Payment
                        </button>
                    </form>
                    
                    <!-- Help Text -->
                    <div class="mt-5 p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <p class="text-amber-800 text-sm">
                            <i class="fas fa-clock text-amber-500 mr-2"></i>
                            After submitting, your payment will be verified within 24 hours.
                        </p>
                    </div>
                </div>
                @endif
                
                @if(!$razorpayEnabled && !$googlePayEnabled)
                <!-- No Payment Method Available -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 text-center">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Payment Unavailable</h3>
                    <p class="text-gray-500 text-sm">Payment methods are currently being configured. Please check back later or contact support.</p>
                </div>
                @endif
            </div>
        </div>
        
        @if($googlePayEnabled)
        <!-- Payment Instructions - Clean card -->
        <div class="mt-6 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-list-ol text-blue-500"></i>
                </div>
                How to Pay via UPI
            </h2>
            
            <div class="grid md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <div class="w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white font-bold">1</div>
                    <h3 class="font-semibold text-gray-900 mb-1 text-sm">Scan QR Code</h3>
                    <p class="text-gray-600 text-xs">Open any UPI app and scan the QR code above</p>
                </div>
                <div class="text-center p-4 bg-pink-50 rounded-xl border border-pink-100">
                    <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white font-bold">2</div>
                    <h3 class="font-semibold text-gray-900 mb-1 text-sm">Enter Amount</h3>
                    <p class="text-gray-600 text-xs">Enter ₹{{ $registrationFee }} and complete payment</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-100">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white font-bold">3</div>
                    <h3 class="font-semibold text-gray-900 mb-1 text-sm">Take Screenshot</h3>
                    <p class="text-gray-600 text-xs">Screenshot the success page with UTR number</p>
                </div>
                <div class="text-center p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-3 text-white font-bold">4</div>
                    <h3 class="font-semibold text-gray-900 mb-1 text-sm">Submit Details</h3>
                    <p class="text-gray-600 text-xs">Upload screenshot above and submit</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if($razorpayEnabled)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('razorpayBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    
    var options = {
        "key": "{{ $razorpayKeyId }}",
        "amount": "{{ $registrationFee * 100 }}",
        "currency": "INR",
        "name": "Valentine Partner Finder",
        "description": "Registration Fee",
        "image": "{{ asset('images/logo.png') }}",
        "handler": function (response) {
            fetch("{{ route('user.payment.razorpay.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "{{ route('user.dashboard') }}";
                } else {
                    alert('Payment verification failed. Please contact support.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            });
        },
        "prefill": {
            "name": "{{ $user->full_name }}",
            "email": "{{ $user->email }}",
            "contact": "{{ $user->mobile_number }}"
        },
        "theme": {
            "color": "#f43f5e"
        }
    };
    
    var rzp = new Razorpay(options);
    rzp.open();
});
</script>
@endif

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
    const upiId = document.getElementById('upiId')?.textContent;
    if (upiId) {
        navigator.clipboard.writeText(upiId).then(() => {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50';
            toast.innerHTML = '<i class="fas fa-check mr-2"></i>UPI ID copied!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        });
    }
}
</script>
@endpush
@endsection