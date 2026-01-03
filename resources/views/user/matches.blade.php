@extends('layouts.app')

@section('title', 'My Matches - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/3 right-1/3 w-56 h-56 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 1.5s;"></div>
    </div>
    
    <!-- Header -->
    <div class="gradient-bg-animated relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-4 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center">
                        <i class="fas fa-heart-circle-check mr-4"></i>
                        My Matches
                    </h1>
                    <p class="text-white/80 mt-2">Your mutual connections are waiting!</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3 text-white">
                        <span class="text-2xl font-bold">{{ $matches->count() }}</span>
                        <span class="text-white/80 ml-2">Matches</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($matches->isEmpty())
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-white via-pink-50 to-valentine-50 rounded-3xl shadow-xl p-12 text-center max-w-2xl mx-auto border-2 border-valentine-200">
                <div class="w-24 h-24 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-heart text-white text-4xl animate-heartbeat"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">No Matches Yet</h2>
                <p class="text-gray-600 mb-8">When someone you like also likes you back, they'll appear here. Keep exploring to find your Valentine!</p>
                <a href="{{ route('user.suggestions') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 text-white px-8 py-3 rounded-xl font-bold inline-flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-search-heart mr-2"></i>Browse Suggestions
                </a>
            </div>
        @else
            <!-- Match Celebration Banner -->
            <div class="bg-gradient-to-r from-valentine-500 to-pink-500 rounded-3xl p-8 mb-8 text-white relative overflow-hidden">

                <div class="relative flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center">
                        <div class="text-6xl mr-6">🎉</div>
                        <div>
                            <h2 class="text-2xl font-bold mb-2">Congratulations!</h2>
                            <p class="text-white/90">You have {{ $matches->count() }} mutual match{{ $matches->count() > 1 ? 'es' : '' }}! Start connecting now.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-4xl animate-float">
                        💕 💖 💕
                    </div>
                </div>
            </div>
            
            <!-- Matches Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($matches as $index => $match)
                    <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-xl overflow-hidden card-hover border-2 border-valentine-200 hover:border-valentine-400 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                        <!-- Match Badge -->
                        <div class="bg-gradient-to-r from-valentine-500 to-pink-500 px-4 py-2 text-white text-center text-sm font-medium">
                            <i class="fas fa-heart-circle-check mr-2"></i>
                            Matched {{ $match->match_created_at ? $match->match_created_at->diffForHumans() : 'recently' }}
                        </div>
                        
                        <!-- Photo Section -->
                        <div class="relative h-64 overflow-hidden">
                            @if($match->photo)
                                <img src="{{ Storage::url($match->photo) }}" alt="{{ $match->full_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-valentine-100 to-pink-100 flex items-center justify-center">
                                    <i class="fas fa-user text-valentine-300 text-6xl"></i>
                                </div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            
                            <!-- Verified Badge -->
                            @if($match->is_verified)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-medium flex items-center shadow-lg">
                                        <i class="fas fa-shield-check mr-1"></i>Verified
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Heart Animation -->
                            <div class="absolute top-4 right-4 w-10 h-10 bg-valentine-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-heart animate-heartbeat"></i>
                            </div>
                            
                            <!-- Basic Info Overlay -->
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="text-xl font-bold mb-1">{{ $match->full_name }}, {{ $match->age }}</h3>
                                <p class="text-white/90 text-sm flex items-center">
                                    <i class="fas fa-graduation-cap mr-2"></i>
                                    {{ $match->branch }} • {{ $match->year }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Info Section -->
                        <div class="p-6">
                            @if($match->bio)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $match->bio }}</p>
                            @endif
                            
                            <!-- Contact Info (if payment verified) -->
                            @if($match->contact_unlocked)
                                <div class="bg-green-50 rounded-xl p-4 mb-4 border border-green-100">
                                    <p class="text-green-800 text-sm font-medium mb-3">
                                        <i class="fas fa-unlock mr-2"></i>Contact Unlocked
                                    </p>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 text-sm flex items-center">
                                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>WhatsApp
                                            </span>
                                            <button onclick="copyToClipboard('{{ $match->whatsapp_no }}')" class="text-valentine-600 text-sm font-medium hover:underline flex items-center">
                                                {{ $match->whatsapp_no }}
                                                <i class="fas fa-copy ml-2"></i>
                                            </button>
                                        </div>
                                        @if($match->instagram_id)
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600 text-sm flex items-center">
                                                    <i class="fab fa-instagram text-purple-500 mr-2"></i>Instagram
                                                </span>
                                                <a href="https://instagram.com/{{ $match->instagram_id }}" target="_blank" class="text-valentine-600 text-sm font-medium hover:underline">
                                                    @{{ $match->instagram_id }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $match->whatsapp_no) }}" target="_blank" class="flex-1 bg-green-500 text-white py-3 rounded-xl font-bold flex items-center justify-center hover:bg-green-600 transition-all duration-300">
                                        <i class="fab fa-whatsapp mr-2"></i>Message
                                    </a>
                                    @if($match->instagram_id)
                                        <a href="https://instagram.com/{{ $match->instagram_id }}" target="_blank" class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-xl flex items-center justify-center hover:opacity-90 transition-all duration-300">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <!-- Unlock Contact -->
                                <div class="bg-valentine-50 rounded-xl p-4 mb-4 border border-valentine-100">
                                    <p class="text-valentine-800 text-sm font-medium mb-2">
                                        <i class="fas fa-lock mr-2"></i>Contact Locked
                                    </p>
                                    <p class="text-valentine-600 text-xs">Pay to unlock contact details</p>
                                </div>
                                
                                <a href="{{ route('user.matches.payment', $match->match_id) }}" class="w-full btn-primary text-white py-3 rounded-xl font-bold flex items-center justify-center">
                                    <i class="fas fa-unlock mr-2"></i>Unlock Contact
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>Copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 2000);
    });
}
</script>
@endpush
@endsection