@extends('layouts.app')

@section('title', 'Find Your Match - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/3 right-1/4 w-48 h-48 bg-yellow-200 rounded-full blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
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
                        <i class="fas fa-heart mr-4 animate-heartbeat"></i>
                        Find Your Valentine
                    </h1>
                    <p class="text-white/80 mt-2">Discover compatible matches waiting for you</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3 text-white">
                        <span class="text-2xl font-bold">{{ $suggestions->count() }}</span>
                        <span class="text-white/80 ml-2">Suggestions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($suggestions->isEmpty())
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-white via-pink-50 to-valentine-50 rounded-3xl shadow-xl p-12 text-center max-w-2xl mx-auto border-2 border-valentine-200">
                <div class="w-24 h-24 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-heart-crack text-white text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">No Suggestions Yet</h2>
                <p class="text-gray-600 mb-8">We're working on finding the perfect matches for you. Check back soon or complete your profile to improve your matches!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('user.profile') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 text-white px-8 py-3 rounded-xl font-bold flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-user-edit mr-2"></i>Complete Profile
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="bg-white text-valentine-600 border-2 border-valentine-300 px-8 py-3 rounded-xl font-semibold hover:bg-valentine-50 transition-all duration-300">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Filter Bar -->
            <div class="bg-gradient-to-r from-valentine-500/10 via-pink-500/10 to-purple-500/10 backdrop-blur-sm rounded-2xl shadow-lg p-4 mb-8 flex flex-wrap items-center gap-4 border border-valentine-200">
                <div class="flex items-center text-valentine-600">
                    <i class="fas fa-filter mr-2"></i>
                    <span class="font-semibold">Filter:</span>
                </div>
                <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-valentine-500 to-pink-500 text-white font-medium transition-all duration-300 shadow-lg">
                    All
                </button>
                <button class="px-4 py-2 rounded-xl bg-white/80 text-gray-700 font-medium hover:bg-gradient-to-r hover:from-valentine-500 hover:to-pink-500 hover:text-white transition-all duration-300 border border-valentine-200">
                    Same Location
                </button>
                <button class="px-4 py-2 rounded-xl bg-white/80 text-gray-700 font-medium hover:bg-gradient-to-r hover:from-valentine-500 hover:to-pink-500 hover:text-white transition-all duration-300 border border-valentine-200">
                    Verified Only
                </button>
            </div>
            
            <!-- Suggestions Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($suggestions as $index => $suggestion)
                    @php 
                        $user = $suggestion->suggestedUser; 
                        // Check if this user has rejected the current logged-in user
                        $hasRejectedMe = in_array($user->id, $rejectedByUsers ?? []);
                    @endphp
                    <div class="bg-gradient-to-br from-white to-pink-50 rounded-3xl shadow-xl overflow-hidden card-hover border-2 border-valentine-100 hover:border-valentine-300 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                        <!-- Photo Section with Gallery -->
                        <div class="relative h-72 overflow-hidden">
                            @if($user->gallery_images && count($user->gallery_images) > 0)
                                <!-- Main Image -->
                                <img src="{{ Storage::url($user->gallery_images[0]) }}" alt="{{ $user->full_name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                
                                <!-- Photo Count Badge -->
                                @if(count($user->gallery_images) > 1)
                                    <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium flex items-center">
                                        <i class="fas fa-images mr-1"></i>{{ count($user->gallery_images) }}
                                    </div>
                                @endif
                            @else
                                <!-- SVG Placeholder -->
                                <div class="w-full h-full bg-gradient-to-br from-valentine-100 to-pink-100 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-valentine-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            
                            <!-- Status Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                @if($user->registration_verified)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-medium flex items-center shadow-lg">
                                        <i class="fas fa-shield-check mr-1"></i>Verified
                                    </span>
                                @endif
                                @if($user->created_at->diffInDays() < 3)
                                    <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-lg text-xs font-medium flex items-center shadow-lg">
                                        <i class="fas fa-sparkles mr-1"></i>New
                                    </span>
                                @endif
                                @if($hasRejectedMe)
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-medium flex items-center shadow-lg">
                                        <i class="fas fa-heart-broken mr-1"></i>Not Interested
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Like Button -->
                            <button class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white hover:bg-valentine-500 hover:text-white transition-all duration-300 group">
                                <i class="far fa-heart group-hover:hidden"></i>
                                <i class="fas fa-heart hidden group-hover:block animate-heartbeat"></i>
                            </button>
                            
                            <!-- Basic Info Overlay -->
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="text-xl font-bold mb-1">{{ $user->full_name }}, {{ $user->age }}</h3>
                                @if($user->location)
                                <p class="text-white/90 text-sm flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $user->location }}
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Info Section -->
                        <div class="p-6">
                            @if($user->bio)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $user->bio }}</p>
                            @else
                                <p class="text-gray-400 text-sm mb-4 italic">No bio added yet</p>
                            @endif
                            
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="bg-valentine-50 text-valentine-600 px-3 py-1 rounded-lg text-xs font-medium">
                                    {{ ucfirst($user->gender) }}
                                </span>
                                @if($user->instagram_id)
                                    <span class="bg-purple-50 text-purple-600 px-3 py-1 rounded-lg text-xs font-medium">
                                        <i class="fab fa-instagram mr-1"></i>Instagram
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Action Buttons -->
                            @if($hasRejectedMe)
                                <!-- User has rejected current user - show info message -->
                                <div class="bg-gray-100 text-gray-600 py-3 px-4 rounded-xl text-center text-sm">
                                    <i class="fas fa-info-circle mr-2"></i>This user is not interested
                                </div>
                            @else
                                <!-- Normal accept/reject buttons -->
                                <div class="flex gap-3">
                                    <!-- Reject Button -->
                                    <form action="{{ route('user.suggestions.respond', $suggestion->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="response" value="rejected">
                                        <button type="submit" class="w-12 h-12 bg-gray-100 text-gray-600 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-500 transition-all duration-300" title="Pass">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Accept Button -->
                                    <form action="{{ route('user.suggestions.respond', $suggestion->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="response" value="accepted">
                                        <button type="submit" class="w-full btn-primary text-white py-3 rounded-xl font-bold flex items-center justify-center">
                                            <i class="fas fa-heart mr-2"></i>Like
                                        </button>
                                    </form>
                                    
                                    <!-- View Profile Button -->
                                    <button onclick="viewProfile({{ $suggestion->id }}, {{ json_encode($user->gallery_images ?? []) }})" class="w-12 h-12 bg-gray-100 text-gray-600 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-all duration-300" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($suggestions->hasPages())
                <div class="mt-10">
                    {{ $suggestions->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Profile View Modal -->
<div id="profileModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl max-h-[90vh] overflow-y-auto border-2 border-valentine-200">
        <div id="profileModalContent">
            <!-- Content loaded dynamically -->
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewProfile(userId, images) {
    // This would typically fetch profile data via AJAX
    // For now, showing a placeholder
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');
    
    content.innerHTML = `
        <div class="gradient-bg-animated p-6 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Profile Details</h3>
                <button onclick="closeProfileModal()" class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-valentine-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-spinner fa-spin text-valentine-500 text-2xl"></i>
            </div>
            <p class="text-gray-600">Loading profile...</p>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal on outside click
document.getElementById('profileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProfileModal();
    }
});
</script>
@endpush
@endsection
