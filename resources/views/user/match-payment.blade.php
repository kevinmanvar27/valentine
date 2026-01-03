@section('title', 'Unlock Match Contact - Valentine Partner Finder')

@section('content')
<!-- Clean background - no animated decorations -->
<div class="min-h-screen bg-gray-50">
    
    <!-- Header - Clean rose background -->
    <div class="bg-rose-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div>
                <a href="{{ route('user.matches') }}" class="text-white/80 hover:text-white transition-colors mb-3 inline-flex items-center text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Matches
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-white flex items-center font-serif">
                    <i class="fas fa-unlock mr-3"></i>
                    Unlock Contact
                </h1>
                <p class="text-white/80 mt-1">Get connected with your match!</p>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Match Preview -->
            <div class="space-y-5">
                <!-- Match Card - Clean design -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="relative h-56 overflow-hidden">
                        @if($partner->gallery_images && count($partner->gallery_images) > 0)
                            <img src="{{ Storage::url($partner->gallery_images[0]) }}" alt="{{ $partner->full_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-user text-gray-300 text-5xl"></i>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Match Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="bg-rose-500 text-white px-3 py-1.5 rounded-lg text-sm font-semibold flex items-center">
                                <i class="fas fa-heart mr-1.5"></i>It's a Match!
                            </span>
                        </div>
                        
                        <!-- Basic Info Overlay -->
                        <div class="absolute bottom-3 left-3 right-3 text-white">
                            <h3 class="text-xl font-bold mb-0.5 font-serif">{{ $partner->full_name }}, {{ $partner->age }}</h3>
                            <p class="text-white/90 flex items-center text-sm">
                                <i class="fas fa-map-marker-alt mr-1.5"></i>
                                {{ $partner->location }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        @if($partner->bio)
                            <p class="text-gray-600 text-sm mb-4">{{ $partner->bio }}</p>
                        @endif
                        
                        <!-- Keywords -->
                        @if($partner->keywords && count($partner->keywords) > 0)
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach($partner->keywords as $keyword)
                                    <span class="bg-rose-100 text-rose-700 px-2.5 py-1 rounded-full text-xs font-medium">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Locked Contact Info -->
                        <div class="bg-rose-50 rounded-xl p-4 border border-rose-100">
                            <div class="flex items-center justify-center text-rose-500 py-2">
                                <i class="fas fa-lock text-xl mr-3"></i>
                                <div>
                                    <p class="font-medium text-rose-700 text-sm">Contact details locked</p>
                                    <p class="text-xs text-rose-500">Pay to unlock WhatsApp & Instagram</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- What You'll Get - Clean card -->
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-100">
                    <h3 class="font-semibold text-gray-900 mb-4 text-sm">After both payments verified, you'll get:</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fab fa-whatsapp text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-sm">WhatsApp number</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fab fa-instagram text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-sm">Instagram profile</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-comments text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-sm">Direct messaging access</span>
                        </div>
                    </div>
                    
                    <!-- Important Note -->
                    <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-100">
                        <p class="text-amber-800 text-xs">
                            <i class="fas fa-info-circle mr-1.5"></i>
                            Contact details will be shared only after <strong>both</strong> you and your match complete the payment.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form - Clean card -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <!-- Amount -->
                <div class="text-center mb-6 bg-rose-500 rounded-xl p-5 -mx-1">
                    <span class="text-white/80 text-sm">Unlock Fee</span>
                    <div class="text-3xl font-bold text-white mt-1 font-serif">
                        ₹<span class="text-amber-300">{{ number_format($payment->amount, 0) }}</span>
                    </div>
                    <p class="text-white/70 mt-1 text-sm">
                        {{ $payment->payment_type === 'full' ? 'Mutual Match' : 'One-sided' }} Payment
                    </p>
                </div>
                
                <!-- Payment Status (if already submitted) -->
                @if($payment->status === 'submitted')
                    <div class="bg-amber-50 rounded-xl p-5 mb-5 border border-amber-100 text-center">
                        <i class="fas fa-clock text-amber-500 text-3xl mb-3"></i>
                        <h3 class="font-semibold text-amber-800 mb-1">Payment Under Review</h3>
                        <p class="text-amber-700 text-sm">Your payment screenshot has been submitted. Please wait for admin verification.</p>
                        @if($payment->transaction_id)
                            <p class="text-amber-600 text-xs mt-2">Transaction ID: {{ $payment->transaction_id }}</p>
                        @endif
                    </div>
                @elseif($payment->status === 'verified')
                    <div class="bg-emerald-50 rounded-xl p-5 mb-5 border border-emerald-100 text-center">
                        <i class="fas fa-check-circle text-emerald-500 text-3xl mb-3"></i>
                        <h3 class="font-semibold text-emerald-800 mb-1">Payment Verified!</h3>
                        <p class="text-emerald-700 text-sm">Waiting for your match partner to complete their payment.</p>
                    </div>
                @elseif($payment->status === 'rejected')
                    <div class="bg-red-50 rounded-xl p-5 mb-5 border border-red-100">
                        <div class="text-center mb-3">
                            <i class="fas fa-times-circle text-red-500 text-3xl mb-3"></i>
                            <h3 class="font-semibold text-red-800 mb-1">Payment Rejected</h3>
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
                    <div class="bg-gray-50 rounded-xl p-5 mb-5 text-center border border-gray-100">
                        <div class="bg-white rounded-lg p-3 inline-block shadow-sm mb-3 border border-gray-100">
                            @if($paymentQR)
                                <img src="{{ Storage::url($paymentQR) }}" alt="Payment QR Code" class="w-36 h-36 mx-auto">
                            @else
                                <div class="w-36 h-36 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-qrcode text-gray-300 text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-500 text-sm">Scan with any UPI app</p>
                    </div>
                    
                    <!-- UPI ID -->
                    <div class="bg-rose-50 rounded-xl p-4 mb-5 border border-rose-100">
                        <p class="text-rose-800 text-sm font-medium mb-2">Or pay directly to UPI ID:</p>
                        <div class="flex items-center justify-between bg-white rounded-lg px-4 py-2.5 border border-rose-100">
                            <span class="font-mono text-gray-900 text-sm" id="upiId">{{ $paymentUPI ?? 'valentine@upi' }}</span>
                            <button onclick="copyUPI()" class="text-rose-600 hover:text-rose-700 transition-colors">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <form action="{{ route('user.matches.payment.submit', $match->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Transaction ID -->
                        <div class="mb-5">
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">Transaction ID / UTR Number</label>
                            <input type="text" name="transaction_id" id="transaction_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all @error('transaction_id') border-red-500 @enderror"
                                placeholder="Enter 12-digit UTR number">
                            @error('transaction_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Screenshot Upload -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Screenshot <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div id="screenshotPreview" class="w-full h-36 rounded-xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center transition-all group-hover:border-rose-300 cursor-pointer">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
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
                        <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Payment
                        </button>
                    </form>
                @endif
                
                <!-- Help Text -->
                <div class="mt-5 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-gray-600 text-sm">
                        <i class="fas fa-info-circle text-rose-500 mr-2"></i>
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
        toast.className = 'fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50';
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