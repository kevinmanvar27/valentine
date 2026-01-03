@section('title', 'Find Your Match - Valentine Partner Finder')

@section('content')
<!-- Clean Valentine Theme - Suggestions Page -->
<div class="min-h-screen bg-gray-50">
    
    <!-- Header - Clean rose background -->
    <div class="bg-rose-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-3 inline-flex items-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <h1 class="text-2xl md:text-3xl font-serif font-bold text-white flex items-center">
                        <i class="fas fa-heart mr-3"></i>
                        Find Your Valentine
                    </h1>
                    <p class="text-white/80 mt-1">Discover compatible matches waiting for you</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 rounded-xl px-5 py-2.5 text-white">
                        <span class="text-xl font-bold">{{ $suggestions->count() }}</span>
                        <span class="text-white/80 ml-2">Suggestions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($suggestions->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center max-w-2xl mx-auto">
                <div class="w-20 h-20 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart-crack text-rose-500 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-3">No Suggestions Yet</h2>
                <p class="text-gray-600 mb-6">We're working on finding the perfect matches for you. Check back soon or complete your profile to improve your matches!</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('user.profile') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl font-semibold flex items-center justify-center transition-colors">
                        <i class="fas fa-user-edit mr-2"></i>Complete Profile
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-colors">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Filter Bar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap items-center gap-3">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-filter mr-2"></i>
                    <span class="font-medium">Filter:</span>
                </div>
                <button class="px-4 py-2 rounded-lg bg-rose-500 text-white font-medium transition-colors">
                    All
                </button>
                <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-rose-500 hover:text-white transition-colors">
                    Same Location
                </button>
                <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-rose-500 hover:text-white transition-colors">
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:border-rose-200 transition-all">
                        <!-- Photo Section with Gallery -->
                        <div class="relative h-72 overflow-hidden">
                            @if($user->gallery_images && count($user->gallery_images) > 0)
                                <!-- Main Image -->
                                <img src="{{ Storage::url($user->gallery_images[0]) }}" alt="{{ $user->full_name }}" class="w-full h-full object-cover">
                                
                                <!-- Photo Count Badge -->
                                @if(count($user->gallery_images) > 1)
                                    <div class="absolute bottom-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-xs font-medium flex items-center">
                                        <i class="fas fa-images mr-1"></i>{{ count($user->gallery_images) }}
                                    </div>
                                @endif
                            @else
                                <!-- SVG Placeholder -->
                                <div class="w-full h-full bg-rose-50 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-rose-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            
                            <!-- Status Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                @if($user->registration_verified)
                                    <span class="bg-emerald-500 text-white px-2.5 py-1 rounded-lg text-xs font-medium flex items-center">
                                        <i class="fas fa-shield-check mr-1"></i>Verified
                                    </span>
                                @endif
                                @if($user->created_at->diffInDays() < 3)
                                    <span class="bg-amber-400 text-amber-900 px-2.5 py-1 rounded-lg text-xs font-medium flex items-center">
                                        <i class="fas fa-sparkles mr-1"></i>New
                                    </span>
                                @endif
                                @if($hasRejectedMe)
                                    <span class="bg-red-500 text-white px-2.5 py-1 rounded-lg text-xs font-medium flex items-center">
                                        <i class="fas fa-heart-broken mr-1"></i>Not Interested
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Like Button -->
                            <button class="absolute top-4 right-4 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center text-white hover:bg-rose-500 transition-colors">
                                <i class="far fa-heart"></i>
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
                        <div class="p-5">
                            @if($user->bio)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $user->bio }}</p>
                            @else
                                <p class="text-gray-400 text-sm mb-4 italic">No bio added yet</p>
                            @endif
                            
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-lg text-xs font-medium border border-rose-100">
                                    {{ ucfirst($user->gender) }}
                                </span>
                                @if($user->instagram_id)
                                    <span class="bg-purple-50 text-purple-600 px-3 py-1 rounded-lg text-xs font-medium border border-purple-100">
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
                                        <button type="submit" class="w-11 h-11 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center hover:bg-red-100 hover:text-red-500 transition-colors" title="Pass">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Accept Button -->
                                    <form action="{{ route('user.suggestions.respond', $suggestion->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="response" value="accepted">
                                        <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3 rounded-xl font-semibold flex items-center justify-center transition-colors">
                                            <i class="fas fa-heart mr-2"></i>Like
                                        </button>
                                    </form>
                                    
                                    <!-- View Profile Button -->
                                    <button onclick="viewProfile({{ $suggestion->id }}, {{ json_encode($user->gallery_images ?? []) }})" class="w-11 h-11 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors" title="View Profile">
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
                <div class="mt-8">
                    {{ $suggestions->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Profile View Modal - Clean Design -->
<div id="profileModal" class="fixed inset-0 bg-black/70 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-xl max-h-[90vh] overflow-y-auto">
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
        <div class="bg-rose-500 p-5">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Profile Details</h3>
                <button onclick="closeProfileModal()" class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition-colors text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-6 text-center">
            <div class="w-14 h-14 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-spinner fa-spin text-rose-500 text-xl"></i>
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
