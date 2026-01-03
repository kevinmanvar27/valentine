@extends('layouts.admin')

@section('title', $user->full_name . ' - Admin - Valentine Partner Finder')

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
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
        50% { box-shadow: 0 0 20px 5px rgba(244, 63, 94, 0.2); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-slide-in-left {
        animation: slideInLeft 0.4s ease-out forwards;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
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
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    }
    
    .status-badge-large {
        position: relative;
        overflow: hidden;
    }
    
    .status-badge-large::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .info-item {
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
    }
    
    .keyword-tag {
        transition: all 0.2s ease;
    }
    
    .keyword-tag:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.25);
    }
    
    .gallery-image {
        transition: all 0.3s ease;
    }
    
    .gallery-image:hover {
        transform: scale(1.1);
        z-index: 10;
    }
    
    .suggestion-card {
        transition: all 0.3s ease;
    }
    
    .suggestion-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(244, 63, 94, 0.1);
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(244, 63, 94, 0.35);
    }
    
    .input-modern {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }
    
    .input-modern:focus {
        border-color: #f43f5e;
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
    }
    
    .payment-card {
        transition: all 0.3s ease;
    }
    
    .payment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .back-link {
        transition: all 0.3s ease;
    }
    
    .back-link:hover {
        transform: translateX(-5px);
    }
</style>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 animate-fade-in-up bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 animate-fade-in-up bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    
    <!-- Back Button -->
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.users') }}" class="back-link inline-flex items-center gap-2 text-rose-600 hover:text-rose-700 font-medium">
            <span class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center">
                <i class="fas fa-arrow-left text-sm"></i>
            </span>
            Back to Users
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card rounded-2xl shadow-xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
                <!-- Profile Image -->
                <div class="profile-image-container relative cursor-pointer group" onclick="openLightbox(0, ['{{ get_image_url($user->live_image) }}'])">
                    <img src="{{ get_image_url($user->live_image) }}" 
                        alt="{{ $user->full_name }}"
                        class="w-full h-72 object-cover">
                    
                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                        <span class="opacity-0 group-hover:opacity-100 bg-white/90 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 transition-opacity">
                            <i class="fas fa-expand mr-1"></i> Click to view full size
                        </span>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="status-badge-large inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold shadow-lg
                            @if($user->status === 'active') bg-gradient-to-r from-emerald-400 to-green-500 text-white
                            @elseif($user->status === 'matched') bg-gradient-to-r from-rose-400 to-pink-500 text-white
                            @elseif($user->status === 'blocked') bg-gradient-to-r from-red-400 to-rose-500 text-white
                            @else bg-gradient-to-r from-amber-400 to-yellow-500 text-white @endif">
                            @if($user->status === 'active')
                                <i class="fas fa-check-circle"></i>
                            @elseif($user->status === 'matched')
                                <i class="fas fa-heart"></i>
                            @elseif($user->status === 'blocked')
                                <i class="fas fa-ban"></i>
                            @else
                                <i class="fas fa-clock"></i>
                            @endif
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                    
                    <!-- Gender Badge -->
                    <div class="absolute bottom-4 left-4 z-10">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium bg-white/90 backdrop-blur-sm shadow-lg
                            {{ $user->gender === 'male' ? 'text-blue-600' : ($user->gender === 'female' ? 'text-pink-600' : 'text-purple-600') }}">
                            {{ $user->gender === 'male' ? '♂' : ($user->gender === 'female' ? '♀' : '⚧') }}
                            {{ ucfirst($user->gender) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Name & Age -->
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $user->full_name }}</h1>
                        <p class="text-gray-500 flex items-center justify-center gap-2 mt-1">
                            <i class="fas fa-birthday-cake text-rose-400"></i>
                            {{ $user->age }} years old
                        </p>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="space-y-2">
                        <div class="info-item flex items-center gap-3 p-3 rounded-xl">
                            <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                <i class="fas fa-envelope text-rose-500"></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-400">Email</p>
                                <p class="text-sm text-gray-700 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item flex items-center gap-3 p-3 rounded-xl">
                            <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                <i class="fas fa-phone text-rose-500"></i>
                            </span>
                            <div>
                                <p class="text-xs text-gray-400">Mobile</p>
                                <p class="text-sm text-gray-700">{{ $user->mobile_number }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item flex items-center gap-3 p-3 rounded-xl">
                            <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                <i class="fab fa-whatsapp text-green-500"></i>
                            </span>
                            <div>
                                <p class="text-xs text-gray-400">WhatsApp</p>
                                <p class="text-sm text-gray-700">{{ $user->whatsapp_number }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item flex items-center gap-3 p-3 rounded-xl">
                            <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-rose-500"></i>
                            </span>
                            <div>
                                <p class="text-xs text-gray-400">Location</p>
                                <p class="text-sm text-gray-700">{{ $user->location }}</p>
                            </div>
                        </div>
                        
                        <div class="info-item flex items-center gap-3 p-3 rounded-xl">
                            <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-rose-500"></i>
                            </span>
                            <div>
                                <p class="text-xs text-gray-400">Date of Birth</p>
                                <p class="text-sm text-gray-700">{{ $user->dob->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keywords -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-heart text-rose-400"></i> Looking for
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->keywords ?? [] as $keyword)
                                <span class="keyword-tag bg-gradient-to-r from-rose-100 to-pink-100 text-rose-700 px-3 py-1.5 rounded-full text-sm font-medium cursor-default">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Expectations -->
                    @if($user->expectations)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-star text-amber-400"></i> Expectations
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed bg-gradient-to-r from-rose-50 to-pink-50 p-4 rounded-xl">
                                {{ $user->expectations }}
                            </p>
                        </div>
                    @endif
                    
                    <!-- Registration Info -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-400"></i> Registration Info
                        </p>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm text-gray-500">Registration Paid</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->registration_paid ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    @if($user->registration_paid)
                                        <i class="fas fa-check-circle"></i> Yes
                                    @else
                                        <i class="fas fa-times-circle"></i> No
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm text-gray-500">Verified</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->registration_verified ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    @if($user->registration_verified)
                                        <i class="fas fa-check-circle"></i> Yes
                                    @else
                                        <i class="fas fa-clock"></i> Pending
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm text-gray-500">Registered</span>
                                <span class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gallery -->
            @if($user->gallery_images && count($user->gallery_images) > 0)
                <div class="glass-card rounded-2xl shadow-xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-images text-white text-sm"></i>
                        </span>
                        Gallery
                        <span class="ml-auto text-xs text-gray-500">{{ count($user->gallery_images) }} {{ count($user->gallery_images) === 1 ? 'photo' : 'photos' }}</span>
                    </h3>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($user->gallery_images as $index => $image)
                            <div class="relative overflow-hidden rounded-xl group">
                                <img src="{{ get_image_url($image) }}" 
                                     alt="Gallery Image {{ $index + 1 }}" 
                                     class="gallery-image w-full h-24 object-cover cursor-pointer"
                                     onclick="openLightbox({{ $index }}, {{ json_encode(array_map(fn($img) => get_image_url($img), $user->gallery_images)) }})">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Send Notification -->
            <div class="glass-card rounded-2xl shadow-xl p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-bell text-white text-sm"></i>
                    </span>
                    Send Notification
                </h3>
                <form action="{{ route('admin.notifications.send') }}" method="POST" class="space-y-4" id="notification-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div>
                        <input type="text" name="title" placeholder="Notification title..." required
                            class="input-modern w-full px-4 py-3 rounded-xl bg-white focus:outline-none" maxlength="255">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <textarea name="message" rows="3" placeholder="Write your message..." required
                            class="input-modern w-full px-4 py-3 rounded-xl bg-white focus:outline-none resize-none"></textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <select name="type" class="input-modern w-full px-4 py-3 rounded-xl bg-white focus:outline-none appearance-none cursor-pointer">
                            <option value="info">ℹ️ Info</option>
                            <option value="success">✅ Success</option>
                            <option value="warning">⚠️ Warning</option>
                            <option value="error">❌ Error</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-gradient w-full text-white py-3 rounded-xl font-semibold shadow-lg" id="send-notification-btn">
                        <i class="fas fa-paper-plane mr-2"></i> Send Notification
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Activity Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Suggestions Received -->
            <div class="glass-card rounded-2xl shadow-xl p-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-paper-plane text-white"></i>
                    </span>
                    <div>
                        <span>Suggestions Received</span>
                        <span class="suggestions-received-count ml-2 px-2.5 py-0.5 bg-rose-100 text-rose-700 rounded-full text-sm font-medium">
                            {{ $user->sentSuggestions->count() }}
                        </span>
                    </div>
                </h3>
                
                @if($user->sentSuggestions->count() > 0)
                    <div class="space-y-3" id="suggestions-container">
                        @foreach($user->sentSuggestions as $suggestion)
                            <div class="suggestion-card flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-rose-50/30 rounded-xl border border-gray-100" id="suggestion-{{ $suggestion->id }}">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ get_image_url($suggestion->suggestedUser->live_image) }}" 
                                            alt="{{ $suggestion->suggestedUser->full_name }}"
                                            class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md">
                                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs
                                            {{ $suggestion->suggestedUser->gender === 'male' ? 'bg-blue-500' : ($suggestion->suggestedUser->gender === 'female' ? 'bg-pink-500' : 'bg-purple-500') }} text-white shadow">
                                            {{ $suggestion->suggestedUser->gender === 'male' ? '♂' : ($suggestion->suggestedUser->gender === 'female' ? '♀' : '⚧') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $suggestion->suggestedUser->full_name }}</p>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-xs text-rose-400"></i>
                                            {{ $suggestion->suggestedUser->location }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                                        @if($suggestion->status === 'accepted') bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700
                                        @elseif($suggestion->status === 'rejected') bg-gradient-to-r from-red-100 to-rose-100 text-red-700
                                        @else bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700 @endif">
                                        @if($suggestion->status === 'accepted')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($suggestion->status === 'rejected')
                                            <i class="fas fa-times-circle"></i>
                                        @else
                                            <i class="fas fa-clock"></i>
                                        @endif
                                        {{ ucfirst($suggestion->status) }}
                                    </span>
                                    @if($suggestion->status === 'pending')
                                        <button type="button" 
                                            class="revoke-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600 hover:from-red-100 hover:to-red-200 hover:text-red-600 transition-all duration-200"
                                            data-suggestion-id="{{ $suggestion->id }}"
                                            title="Revoke this suggestion">
                                            <i class="fas fa-undo"></i>
                                            Revoke
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-paper-plane text-2xl text-rose-300"></i>
                        </div>
                        <p class="text-gray-500">No suggestions received yet</p>
                    </div>
                @endif
            </div>
            
            <!-- Profiles Shared to Others (This user's profile was shared to these users) -->
            <div class="glass-card rounded-2xl shadow-xl p-6 animate-fade-in-up" style="animation-delay: 0.25s;">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-share-alt text-white"></i>
                    </span>
                    <div>
                        <span>Profile Shared To</span>
                        <span class="ml-2 px-2.5 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                            {{ $user->receivedSuggestions->count() }}
                        </span>
                    </div>
                </h3>
                
                @if($user->receivedSuggestions->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->receivedSuggestions as $suggestion)
                            <div class="suggestion-card flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-indigo-50/30 rounded-xl border border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ get_image_url($suggestion->user->live_image) }}" 
                                            alt="{{ $suggestion->user->full_name }}"
                                            class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md">
                                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs
                                            {{ $suggestion->user->gender === 'male' ? 'bg-blue-500' : ($suggestion->user->gender === 'female' ? 'bg-pink-500' : 'bg-purple-500') }} text-white shadow">
                                            {{ $suggestion->user->gender === 'male' ? '♂' : ($suggestion->user->gender === 'female' ? '♀' : '⚧') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $suggestion->user->full_name }}</p>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-xs text-indigo-400"></i>
                                            {{ $suggestion->user->location }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                                        @if($suggestion->status === 'accepted') bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700
                                        @elseif($suggestion->status === 'rejected') bg-gradient-to-r from-red-100 to-rose-100 text-red-700
                                        @else bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700 @endif">
                                        @if($suggestion->status === 'accepted')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($suggestion->status === 'rejected')
                                            <i class="fas fa-times-circle"></i>
                                        @else
                                            <i class="fas fa-clock"></i>
                                        @endif
                                        {{ ucfirst($suggestion->status) }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ $suggestion->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-share-alt text-2xl text-indigo-300"></i>
                        </div>
                        <p class="text-gray-500">This profile hasn't been shared to anyone yet</p>
                    </div>
                @endif
            </div>
            
            <!-- Payments Section -->
            <div class="glass-card rounded-2xl shadow-xl p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                        <i class="fas fa-credit-card text-white"></i>
                    </span>
                    <span>Payment History</span>
                </h3>
                
                <!-- Registration Payment -->
                @if($user->registration_payment_screenshot)
                    <div class="payment-card mb-6 p-5 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-user-plus text-emerald-600"></i>
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-800">Registration Payment</p>
                                    <p class="text-sm text-gray-500">Initial registration fee</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                                {{ $user->registration_verified ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                @if($user->registration_verified)
                                    <i class="fas fa-check-circle"></i> Verified
                                @else
                                    <i class="fas fa-clock"></i> Pending
                                @endif
                            </span>
                        </div>
                        <div class="relative group">
                            <img src="{{ Storage::url($user->registration_payment_screenshot) }}" 
                                alt="Registration Payment Screenshot" 
                                class="w-full max-w-md rounded-xl border-2 border-white shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                                onclick="openLightbox(0, ['{{ Storage::url($user->registration_payment_screenshot) }}'])">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-all flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 bg-white/90 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 transition-opacity">
                                    <i class="fas fa-expand mr-1"></i> Click to expand
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Match Payments -->
                @if($user->payments->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->payments as $payment)
                            <div class="payment-card p-5 bg-gradient-to-r from-gray-50 to-rose-50/30 rounded-xl border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center">
                                            <i class="fas fa-heart text-rose-600"></i>
                                        </span>
                                        <div>
                                            <p class="font-semibold text-gray-800">Match Payment</p>
                                            <p class="text-sm text-gray-500">{{ ucfirst($payment->payment_type) }} payment</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold gradient-text">₹{{ number_format($payment->amount) }}</p>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                            @if($payment->status === 'verified') bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700
                                            @elseif($payment->status === 'rejected') bg-gradient-to-r from-red-100 to-rose-100 text-red-700
                                            @elseif($payment->status === 'submitted') bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            @if($payment->status === 'verified')
                                                <i class="fas fa-check-circle"></i>
                                            @elseif($payment->status === 'rejected')
                                                <i class="fas fa-times-circle"></i>
                                            @elseif($payment->status === 'submitted')
                                                <i class="fas fa-clock"></i>
                                            @else
                                                <i class="fas fa-hourglass-half"></i>
                                            @endif
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </div>
                                </div>
                                @if($payment->payment_screenshot)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($payment->payment_screenshot) }}" 
                                            alt="Match Payment Screenshot" 
                                            class="w-full max-w-sm rounded-xl border-2 border-white shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                                            onclick="openLightbox(0, ['{{ Storage::url($payment->payment_screenshot) }}'])">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-all flex items-center justify-center">
                                            <span class="opacity-0 group-hover:opacity-100 bg-white/90 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 transition-opacity">
                                                <i class="fas fa-expand mr-1"></i> Click to expand
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    @if(!$user->registration_payment_screenshot)
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-credit-card text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500">No payments recorded yet</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4" onclick="closeLightbox()">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-rose-400 transition-colors z-10">
        <i class="fas fa-times text-3xl"></i>
    </button>
    
    <button onclick="event.stopPropagation(); previousImage()" class="absolute left-4 text-white hover:text-rose-400 transition-colors z-10">
        <i class="fas fa-chevron-left text-3xl"></i>
    </button>
    
    <button onclick="event.stopPropagation(); nextImage()" class="absolute right-4 text-white hover:text-rose-400 transition-colors z-10">
        <i class="fas fa-chevron-right text-3xl"></i>
    </button>
    
    <div class="max-w-5xl max-h-[90vh] w-full" onclick="event.stopPropagation()">
        <img id="lightbox-image" src="" alt="Gallery Image" class="w-full h-full object-contain rounded-lg shadow-2xl">
        <div class="text-center mt-4">
            <span id="lightbox-counter" class="text-white text-sm"></span>
        </div>
    </div>
</div>

<script>
// Lightbox functionality
let currentImageIndex = 0;
let galleryImages = [];

function openLightbox(index, images) {
    currentImageIndex = index;
    galleryImages = images;
    const modal = document.getElementById('lightbox-modal');
    const image = document.getElementById('lightbox-image');
    const counter = document.getElementById('lightbox-counter');
    
    image.src = galleryImages[currentImageIndex];
    counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const modal = document.getElementById('lightbox-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    const image = document.getElementById('lightbox-image');
    const counter = document.getElementById('lightbox-counter');
    image.src = galleryImages[currentImageIndex];
    counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    const image = document.getElementById('lightbox-image');
    const counter = document.getElementById('lightbox-counter');
    image.src = galleryImages[currentImageIndex];
    counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
}

// Keyboard navigation for lightbox
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('lightbox-modal');
    if (!modal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') previousImage();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Notification form handling
    const notificationForm = document.getElementById('notification-form');
    if (notificationForm) {
        notificationForm.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('send-notification-btn');
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
                submitBtn.disabled = true;
                
                // Re-enable after 3 seconds to prevent stuck state
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalContent;
                        submitBtn.disabled = false;
                    }
                }, 3000);
            }
        });
    }
    
    // Revoke suggestion functionality
    document.querySelectorAll('.revoke-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const suggestionId = this.dataset.suggestionId;
            const button = this;
            
            if (!confirm('Are you sure you want to revoke this suggestion?')) {
                return;
            }
            
            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            fetch(`/admin/matchmaking/revoke/${suggestionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the suggestion card with animation
                    const card = document.getElementById(`suggestion-${suggestionId}`);
                    if (card) {
                        card.style.transition = 'all 0.3s ease-out';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            card.remove();
                            
                            // Update counter
                            const counter = document.querySelector('.suggestions-received-count');
                            if (counter) {
                                const currentCount = parseInt(counter.textContent);
                                const newCount = currentCount - 1;
                                counter.textContent = newCount;
                                
                                // Check if there are no more suggestions
                                const container = document.getElementById('suggestions-container');
                                if (container && container.children.length === 0) {
                                    // Show empty state
                                    container.innerHTML = `
                                        <div class="text-center py-12">
                                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-paper-plane text-2xl text-rose-300"></i>
                                            </div>
                                            <p class="text-gray-500">No suggestions received yet</p>
                                        </div>
                                    `;
                                }
                            }
                            
                            // Show success message
                            showNotification('Suggestion revoked successfully', 'success');
                        }, 300);
                    }
                } else {
                    throw new Error(data.message || 'Failed to revoke suggestion');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'An error occurred while revoking the suggestion', 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });
    });
    
    // Auto-dismiss success/error messages
    const alertMessages = document.querySelectorAll('[class*="from-emerald-50"], [class*="from-red-50"]');
    alertMessages.forEach(alert => {
        if (alert.textContent.trim()) {
            setTimeout(() => {
                alert.style.transition = 'all 0.5s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });
    
    // Notification helper function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-gradient-to-r from-emerald-500 to-green-500' :
            type === 'error' ? 'bg-gradient-to-r from-red-500 to-rose-500' :
            'bg-gradient-to-r from-blue-500 to-indigo-500'
        } text-white font-medium flex items-center gap-3`;
        
        notification.innerHTML = `
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' :
                type === 'error' ? 'fa-exclamation-circle' :
                'fa-info-circle'
            }"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(150%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endsection
