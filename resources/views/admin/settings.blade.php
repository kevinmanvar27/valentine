@extends('layouts.admin')

@section('title', 'Settings - Admin - Valentine Partner Finder')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold">
            <span class="gradient-text">
                <i class="fas fa-cog mr-2"></i> Admin Settings
            </span>
        </h1>
        <p class="text-gray-400 mt-2">Configure application settings</p>
    </div>

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="glass-card rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
            
            <!-- Payment Settings Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                        <i class="fas fa-rupee-sign text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Payment Settings</h2>
                        <p class="text-sm text-gray-500">Configure payment amounts</p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-plus text-rose-400 mr-1"></i> Registration Fee (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">₹</span>
                            <input type="number" name="registration_fee" value="{{ $settings['registration_fee'] }}" required
                                class="input-modern w-full pl-10 @error('registration_fee') border-red-500 @enderror">
                        </div>
                        @error('registration_fee')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-heart text-rose-400 mr-1"></i> Full Payment (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">₹</span>
                            <input type="number" name="full_payment_amount" value="{{ $settings['full_payment_amount'] }}" required
                                class="input-modern w-full pl-10 @error('full_payment_amount') border-red-500 @enderror">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> For mutual matches
                        </p>
                        @error('full_payment_amount')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-heart-half-stroke text-rose-400 mr-1"></i> Half Payment (₹)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">₹</span>
                            <input type="number" name="half_payment_amount" value="{{ $settings['half_payment_amount'] }}" required
                                class="input-modern w-full pl-10 @error('half_payment_amount') border-red-500 @enderror">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> For one-sided acceptance
                        </p>
                        @error('half_payment_amount')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Google Pay / UPI Settings Section -->
            <div class="p-6 border-b border-gray-100" x-data="{ enabled: {{ $settings['googlepay_enabled'] ? 'true' : 'false' }} }">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Google Pay / UPI</h2>
                            <p class="text-sm text-gray-500">Manual UPI payment with screenshot upload</p>
                        </div>
                    </div>
                    <!-- Toggle Switch -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="googlepay_enabled" value="1" x-model="enabled" class="sr-only peer" {{ $settings['googlepay_enabled'] ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700" x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                    </label>
                </div>
                
                <div x-show="enabled" x-transition class="space-y-4">
                    <div class="form-group max-w-md">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-at text-green-500 mr-1"></i> UPI ID
                        </label>
                        <div class="relative">
                            <input type="text" name="payment_upi" value="{{ $settings['payment_upi'] }}"
                                class="input-modern w-full pr-24 @error('payment_upi') border-red-500 @enderror"
                                placeholder="yourname@upi">
                            <button type="button" onclick="copyUPI()" 
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm text-gray-600 transition">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                        </div>
                        @error('payment_upi')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <p class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i> Users will pay via UPI and upload payment screenshot for verification
                    </p>
                </div>
            </div>
            
            <!-- Razorpay Settings Section -->
            <div class="p-6 border-b border-gray-100" x-data="{ enabled: {{ $settings['razorpay_enabled'] ? 'true' : 'false' }} }">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                            <i class="fas fa-credit-card text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Razorpay</h2>
                            <p class="text-sm text-gray-500">Automatic online payment gateway</p>
                        </div>
                    </div>
                    <!-- Toggle Switch -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="razorpay_enabled" value="1" x-model="enabled" class="sr-only peer" {{ $settings['razorpay_enabled'] ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700" x-text="enabled ? 'Enabled' : 'Disabled'"></span>
                    </label>
                </div>
                
                <div x-show="enabled" x-transition class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-key text-blue-500 mr-1"></i> Razorpay Key ID
                            </label>
                            <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] }}"
                                class="input-modern w-full @error('razorpay_key_id') border-red-500 @enderror"
                                placeholder="rzp_test_xxxxxxxxxxxxx">
                            @error('razorpay_key_id')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-blue-500 mr-1"></i> Razorpay Key Secret
                            </label>
                            <input type="password" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] }}"
                                class="input-modern w-full @error('razorpay_key_secret') border-red-500 @enderror"
                                placeholder="••••••••••••••••">
                            @error('razorpay_key_secret')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i> Get your API keys from <a href="https://dashboard.razorpay.com/app/keys" target="_blank" class="text-blue-500 hover:underline">Razorpay Dashboard</a>
                    </p>
                </div>
            </div>
            
            <!-- Images Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-image text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Images</h2>
                        <p class="text-sm text-gray-500">Logo and QR code settings</p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- App Logo -->
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Application Logo</label>
                        
                        @if($settings['app_logo'])
                            <div class="mb-4 p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl inline-block">
                                <img src="{{ Storage::url($settings['app_logo']) }}" alt="Logo" class="h-16 object-contain">
                            </div>
                        @endif
                        
                        <div class="file-upload-wrapper">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-rose-400 hover:bg-rose-50/50 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-semibold text-rose-500">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                                </div>
                                <input type="file" name="app_logo" accept="image/*" class="hidden">
                            </label>
                        </div>
                        @error('app_logo')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Payment QR Code -->
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Payment QR Code</label>
                        
                        @if($settings['payment_qr_code'])
                            <div class="mb-4 p-4 bg-white rounded-xl border-2 border-gray-100 inline-block shadow-sm">
                                <img src="{{ Storage::url($settings['payment_qr_code']) }}" alt="QR Code" class="h-32 object-contain">
                            </div>
                        @endif
                        
                        <div class="file-upload-wrapper">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-rose-400 hover:bg-rose-50/50 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-qrcode text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-semibold text-rose-500">Click to upload</span> QR code
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
                                </div>
                                <input type="file" name="payment_qr_code" accept="image/*" class="hidden">
                            </label>
                        </div>
                        @error('payment_qr_code')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100">
                <button type="submit" class="btn-gradient px-8 py-3 rounded-xl font-bold text-lg group">
                    <i class="fas fa-save mr-2 transition-transform group-hover:scale-110"></i> Save Settings
                </button>
            </div>
        </div>
    </form>
    
    <!-- Bulk Notification Section -->
    <div class="glass-card rounded-2xl overflow-hidden mt-8 animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                    <i class="fas fa-bullhorn text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Send Bulk Notification</h2>
                    <p class="text-sm text-gray-500">Broadcast messages to users</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.notifications.bulk') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-amber-500 mr-1"></i> Title
                    </label>
                    <input type="text" name="title" required
                        class="input-modern w-full"
                        placeholder="Notification title...">
                </div>
                
                <div class="form-group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-users text-amber-500 mr-1"></i> Target Users
                    </label>
                    <select name="target" required class="input-modern w-full">
                        <option value="all">All Users</option>
                        <option value="active">Active Users Only</option>
                        <option value="pending">Pending Users Only</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-comment-alt text-amber-500 mr-1"></i> Message
                </label>
                <textarea name="message" rows="4" required
                    class="input-modern w-full resize-none"
                    placeholder="Write your notification message here..."></textarea>
            </div>
            
            <div class="form-group mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-tag text-amber-500 mr-1"></i> Type
                </label>
                <div class="flex flex-wrap gap-3">
                    <label class="notification-type-option">
                        <input type="radio" name="type" value="info" checked class="sr-only peer">
                        <span class="px-4 py-2 rounded-xl border-2 border-gray-200 cursor-pointer transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:border-blue-300 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i> Info
                        </span>
                    </label>
                    <label class="notification-type-option">
                        <input type="radio" name="type" value="success" class="sr-only peer">
                        <span class="px-4 py-2 rounded-xl border-2 border-gray-200 cursor-pointer transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 hover:border-emerald-300 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Success
                        </span>
                    </label>
                    <label class="notification-type-option">
                        <input type="radio" name="type" value="warning" class="sr-only peer">
                        <span class="px-4 py-2 rounded-xl border-2 border-gray-200 cursor-pointer transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:border-amber-300 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i> Warning
                        </span>
                    </label>
                    <label class="notification-type-option">
                        <input type="radio" name="type" value="error" class="sr-only peer">
                        <span class="px-4 py-2 rounded-xl border-2 border-gray-200 cursor-pointer transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 hover:border-red-300 flex items-center gap-2">
                            <i class="fas fa-times-circle"></i> Error
                        </span>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn-amber px-6 py-3 rounded-xl font-semibold group">
                <i class="fas fa-paper-plane mr-2 transition-transform group-hover:translate-x-1"></i> Send to All
            </button>
        </form>
    </div>
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -10px rgba(244, 63, 94, 0.5);
    }
    
    .btn-amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-amber:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.5);
    }
    
    .input-modern {
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        background: white;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .input-modern:focus {
        outline: none;
        border-color: #f43f5e;
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
    }
    
    .input-modern::placeholder {
        color: #9ca3af;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
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
    
    /* File upload hover effect */
    .file-upload-wrapper label:hover i {
        transform: translateY(-3px);
        transition: transform 0.3s ease;
    }
</style>

<script>
    function copyUPI() {
        const upiInput = document.querySelector('input[name="payment_upi"]');
        navigator.clipboard.writeText(upiInput.value).then(() => {
            // Show toast or feedback
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
            btn.classList.add('bg-emerald-100', 'text-emerald-700');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('bg-emerald-100', 'text-emerald-700');
            }, 2000);
        });
    }
</script>
@endsection
