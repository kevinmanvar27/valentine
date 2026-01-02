@extends('layouts.app')

@section('title', 'Complete Payment - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-yellow-200 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 2s;"></div>
    </div>
    
    <!-- Header -->
    <div class="gradient-bg-animated relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-4 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center">
                        <i class="fas fa-crown mr-4 text-yellow-300"></i>
                        Complete Payment
                    </h1>
                    <p class="text-white/80 mt-2">Unlock all premium features and start matching!</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Payment Details -->
            <div class="space-y-6">
                <!-- Amount Card -->
                <div class="bg-gradient-to-br from-valentine-500 via-pink-500 to-purple-500 rounded-3xl shadow-xl p-8 animate-fade-in relative overflow-hidden">
                    <div class="relative text-center mb-8">
                        <span class="text-white/80 text-lg">Registration Fee</span>
                        <div class="text-5xl font-bold text-white mt-2">
                            ₹<span class="text-yellow-300">{{ $registrationFee }}</span>
                        </div>
                        <p class="text-white/70 mt-2">One-time payment</p>
                    </div>
                    
                    <!-- Features Included -->
                    <div class="relative space-y-4">
                        <h3 class="font-bold text-white mb-4">What you'll get:</h3>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-yellow-300 text-sm"></i>
                            </div>
                            <span>Unlimited match suggestions</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-yellow-300 text-sm"></i>
                            </div>
                            <span>View who liked your profile</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-yellow-300 text-sm"></i>
                            </div>
                            <span>Unlock contact details of matches</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-yellow-300 text-sm"></i>
                            </div>
                            <span>Priority profile visibility</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-yellow-300 text-sm"></i>
                            </div>
                            <span>Access for entire Valentine's week</span>
                        </div>
                    </div>
                </div>
                
                <!-- Trust Badges -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-lg p-6 border-2 border-green-200">
                    <div class="flex items-center justify-center gap-6 text-green-700">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                            <span class="text-sm font-medium">Secure Payment</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-lock text-green-500 mr-2"></i>
                            <span class="text-sm font-medium">SSL Encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="space-y-6" x-data="{ activeTab: '{{ $razorpayEnabled ? 'razorpay' : 'upi' }}' }">
                
                @if($razorpayEnabled && $googlePayEnabled)
                <!-- Payment Method Tabs -->
                <div class="bg-white rounded-2xl p-2 shadow-lg flex gap-2">
                    <button @click="activeTab = 'razorpay'" 
                        :class="activeTab === 'razorpay' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="flex-1 py-3 px-4 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-credit-card mr-2"></i> Razorpay
                    </button>
                    <button @click="activeTab = 'upi'" 
                        :class="activeTab === 'upi' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="flex-1 py-3 px-4 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-mobile-alt mr-2"></i> UPI / GPay
                    </button>
                </div>
                @endif
                
                @if($razorpayEnabled)
                <!-- Razorpay Payment -->
                <div x-show="activeTab === 'razorpay'" x-transition class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 border-2 border-blue-200 animate-fade-in">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-credit-card text-blue-500"></i>
                        </div>
                        Pay with Razorpay
                    </h2>
                    
                    <div class="text-center mb-6">
                        <p class="text-gray-600 mb-4">Pay securely using UPI, Cards, Net Banking, or Wallets</p>
                        <div class="flex justify-center gap-4 mb-6">
                            <img src="https://cdn.razorpay.com/static/assets/logo/payment.svg" alt="Payment Methods" class="h-8">
                        </div>
                    </div>
                    
                    <button id="razorpayBtn" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white py-4 rounded-xl font-bold flex items-center justify-center text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-lock mr-2"></i> Pay ₹{{ $registrationFee }} Securely
                    </button>
                    
                    <p class="text-center text-gray-500 text-sm mt-4">
                        <i class="fas fa-bolt text-yellow-500 mr-1"></i> Instant verification - No waiting!
                    </p>
                </div>
                @endif
                
                @if($googlePayEnabled)
                <!-- UPI / Google Pay Payment -->
                <div x-show="activeTab === 'upi'" x-transition class="bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-xl p-8 border-2 border-green-200 animate-fade-in">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-qrcode text-green-500"></i>
                        </div>
                        Pay via UPI / Google Pay
                    </h2>
                    
                    <!-- QR Code -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 mb-6 text-center border border-green-100">
                        <div class="bg-white rounded-xl p-4 inline-block shadow-lg mb-4 border border-green-100">
                            @if($paymentQR)
                                <img src="{{ Storage::url($paymentQR) }}" alt="Payment QR Code" class="w-48 h-48 mx-auto">
                            @else
                                <div class="w-48 h-48 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-qrcode text-gray-300 text-6xl"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm">Scan with any UPI app</p>
                    </div>
                    
                    <!-- UPI ID -->
                    <div class="bg-green-50 rounded-xl p-4 mb-6 border border-green-100">
                        <p class="text-green-800 text-sm font-medium mb-2">Or pay directly to UPI ID:</p>
                        <div class="flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-green-100">
                            <span class="font-mono text-gray-900" id="upiId">{{ $paymentUPI }}</span>
                            <button type="button" onclick="copyUPI()" class="text-green-600 hover:text-green-700 transition-colors">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <form action="{{ route('user.payment.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Screenshot Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Screenshot</label>
                            <div class="relative group">
                                <div id="screenshotPreview" class="w-full h-48 rounded-xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center transition-all duration-300 group-hover:border-green-400 cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <p class="text-gray-500">Click to upload screenshot</p>
                                        <p class="text-gray-400 text-sm mt-1">Max 5MB, JPG/PNG</p>
                                    </div>
                                </div>
                                <input type="file" name="payment_screenshot" id="screenshotInput" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            @error('payment_screenshot')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white py-4 rounded-xl font-bold flex items-center justify-center text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Payment
                        </button>
                    </form>
                    
                    <!-- Help Text -->
                    <div class="mt-6 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                        <p class="text-yellow-800 text-sm">
                            <i class="fas fa-clock text-yellow-500 mr-2"></i>
                            After submitting, your payment will be verified within 24 hours.
                        </p>
                    </div>
                </div>
                @endif
                
                @if(!$razorpayEnabled && !$googlePayEnabled)
                <!-- No Payment Method Available -->
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-xl p-8 border-2 border-gray-200 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Payment Unavailable</h3>
                    <p class="text-gray-500">Payment methods are currently being configured. Please check back later or contact support.</p>
                </div>
                @endif
            </div>
        </div>
        
        @if($googlePayEnabled)
        <!-- Payment Instructions -->
        <div class="mt-8 bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 border-2 border-blue-200 animate-fade-in" style="animation-delay: 0.2s;">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-list-ol text-white"></i>
                </div>
                How to Pay via UPI
            </h2>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-gradient-to-br from-valentine-50 to-pink-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-valentine-400 to-valentine-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold shadow-lg">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Scan QR Code</h3>
                    <p class="text-gray-600 text-sm">Open any UPI app and scan the QR code above</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-pink-50 to-purple-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold shadow-lg">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Enter Amount</h3>
                    <p class="text-gray-600 text-sm">Enter ₹{{ $registrationFee }} and complete payment</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold shadow-lg">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Take Screenshot</h3>
                    <p class="text-gray-600 text-sm">Screenshot the success page with UTR number</p>
                </div>
                <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold shadow-lg">4</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Submit Details</h3>
                    <p class="text-gray-600 text-sm">Upload screenshot above and submit</p>
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
            // Send payment details to server for verification
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
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
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