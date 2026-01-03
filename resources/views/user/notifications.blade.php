@extends('layouts.app')

@section('title', 'Notifications - Valentine Partner Finder')

@push('styles')
<style>
    /* Modal animations */
    #profileModal {
        animation: fadeIn 0.3s ease-out;
    }
    
    #profileModal > div {
        animation: slideUp 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Smooth scrollbar for modal */
    #profileModal > div {
        scrollbar-width: thin;
        scrollbar-color: rgba(139, 92, 246, 0.3) transparent;
    }
    
    #profileModal > div::-webkit-scrollbar {
        width: 8px;
    }
    
    #profileModal > div::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #profileModal > div::-webkit-scrollbar-thumb {
        background-color: rgba(139, 92, 246, 0.3);
        border-radius: 20px;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute bottom-1/3 left-1/3 w-48 h-48 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 1.5s;"></div>
    </div>
    
    <!-- Header -->
    <div class="gradient-bg-animated relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-4 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center">
                        <i class="fas fa-bell mr-4"></i>
                        Notifications
                    </h1>
                    <p class="text-white/80 mt-2">Stay updated with your matches and activities</p>
                </div>
                @if($notifications->count() > 0)
                    <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 flex items-center">
                            <i class="fas fa-check-double mr-2"></i>Mark All Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($notifications->isEmpty())
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-white via-purple-50 to-pink-50 rounded-3xl shadow-xl p-12 text-center border-2 border-purple-200">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-bell-slash text-white text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">No Notifications</h2>
                <p class="text-gray-600 mb-8">You're all caught up! When something happens, you'll see it here.</p>
                <a href="{{ route('user.suggestions') }}" class="bg-gradient-to-r from-valentine-500 to-pink-500 text-white px-8 py-3 rounded-xl font-bold inline-flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-heart mr-2"></i>Find Matches
                </a>
            </div>
        @else
            <!-- Notifications List -->
            <div class="space-y-4">
                @foreach($notifications as $index => $notification)
                    @php
                        $typeConfig = [
                            'match' => ['icon' => 'fa-heart', 'bg' => 'bg-valentine-500', 'border' => 'border-valentine-200', 'bgLight' => 'bg-valentine-50'],
                            'like' => ['icon' => 'fa-heart', 'bg' => 'bg-pink-500', 'border' => 'border-pink-200', 'bgLight' => 'bg-pink-50'],
                            'payment' => ['icon' => 'fa-credit-card', 'bg' => 'bg-green-500', 'border' => 'border-green-200', 'bgLight' => 'bg-green-50'],
                            'verification' => ['icon' => 'fa-shield-check', 'bg' => 'bg-blue-500', 'border' => 'border-blue-200', 'bgLight' => 'bg-blue-50'],
                            'profile_suggestion' => ['icon' => 'fa-user-plus', 'bg' => 'bg-purple-500', 'border' => 'border-purple-200', 'bgLight' => 'bg-purple-50'],
                            'system' => ['icon' => 'fa-info-circle', 'bg' => 'bg-gray-500', 'border' => 'border-gray-200', 'bgLight' => 'bg-gray-50'],
                            'warning' => ['icon' => 'fa-exclamation-triangle', 'bg' => 'bg-yellow-500', 'border' => 'border-yellow-200', 'bgLight' => 'bg-yellow-50'],
                        ];
                        $type = $notification->type ?? 'system';
                        $config = $typeConfig[$type] ?? $typeConfig['system'];
                    @endphp
                    
                    <div class="bg-gradient-to-r from-white to-{{ str_replace('border-', '', str_replace('-200', '-50', $config['border'])) }} rounded-2xl shadow-lg overflow-hidden card-hover border-2 {{ $config['border'] }} animate-fade-in {{ !$notification->read_at ? 'ring-2 ring-valentine-300 shadow-valentine-100' : '' }}" style="animation-delay: {{ $index * 0.05 }}s;">
                        <div class="flex items-start p-6">
                            <!-- Icon -->
                            <div class="flex-shrink-0 w-12 h-12 {{ $config['bg'] }} rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas {{ $config['icon'] }} text-white"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $notification->title }}</h3>
                                    @if(!$notification->is_read)
                                        <span class="bg-valentine-500 text-white text-xs px-2 py-1 rounded-lg font-medium ml-2 flex-shrink-0">
                                            New
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 mb-3">{{ $notification->message }}</p>
                                
                                <!-- Profile Suggestion Actions -->
                                @if($notification->type === 'profile_suggestion' && $notification->related_id)
                                    @php
                                        $suggestion = $notification->profileSuggestion;
                                        $suggestedUser = $suggestion ? $suggestion->suggestedUser : null;
                                        $suggestionStatus = $suggestion ? $suggestion->status : null;
                                    @endphp
                                    
                                    @if($suggestionStatus === 'pending' && $suggestedUser)
                                        <!-- View Profile Button - Pending -->
                                        <button onclick="openProfileModal({{ $notification->related_id }})" 
                                                class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center mb-3">
                                            <i class="fas fa-user mr-2"></i>View Profile
                                        </button>
                                    @elseif($suggestionStatus === 'accepted' && $suggestedUser)
                                        <!-- View Profile Button - Accepted (can still view) -->
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="inline-flex items-center bg-green-100 text-green-700 px-4 py-2 rounded-xl font-semibold">
                                                <i class="fas fa-check-circle mr-2"></i>Accepted
                                            </span>
                                            <button onclick="openProfileModal({{ $notification->related_id }}, true)" 
                                                    class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center text-sm">
                                                <i class="fas fa-eye mr-2"></i>View Profile
                                            </button>
                                        </div>
                                    @elseif($suggestionStatus === 'rejected')
                                        <!-- Rejected - Cannot view profile -->
                                        <span class="inline-flex items-center bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-semibold mb-3">
                                            <i class="fas fa-times-circle mr-2"></i>Rejected
                                        </span>
                                    @endif
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm flex items-center">
                                        <i class="far fa-clock mr-2"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center gap-3">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" class="text-valentine-600 text-sm font-medium hover:underline flex items-center">
                                                {{ $notification->action_text ?? 'View' }}
                                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                            </a>
                                        @endif
                                        @if(!$notification->is_read)
                                            <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-gray-400 hover:text-gray-600 text-sm flex items-center">
                                                    <i class="fas fa-check mr-1"></i>Mark read
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Unread Indicator -->
                        @if(!$notification->is_read)
                            <div class="h-1 bg-gradient-to-r from-valentine-500 to-pink-500"></div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-10">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4" onclick="closeProfileModal(event)">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-6 rounded-t-3xl flex items-center justify-between">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-user-circle mr-3"></i>
                Profile Details
            </h2>
            <button onclick="closeProfileModal()" class="text-white hover:bg-white/20 rounded-full p-2 transition-all duration-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div id="modalContent" class="p-6">
            <!-- Loading State -->
            <div class="text-center py-12">
                <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-4"></i>
                <p class="text-gray-600">Loading profile...</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Store suggestion data for modal
let currentSuggestionData = {};
let isViewOnlyMode = false;

// Open profile modal
function openProfileModal(suggestionId, viewOnly = false) {
    const modal = document.getElementById('profileModal');
    const modalContent = document.getElementById('modalContent');
    isViewOnlyMode = viewOnly;
    
    // Show modal with loading state
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Fetch suggestion details
    fetch(`/user/suggestions/${suggestionId}/details`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentSuggestionData = data.suggestion;
            renderProfileModal(data.suggestion);
        } else {
            modalContent.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                    <p class="text-gray-600">${data.message || 'Failed to load profile'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = `
            <div class="text-center py-12">
                <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                <p class="text-gray-600">An error occurred while loading the profile.</p>
            </div>
        `;
    });
}

// Render profile modal content
function renderProfileModal(suggestion) {
    const user = suggestion.suggested_user;
    const modalContent = document.getElementById('modalContent');
    
    // Calculate age
    const age = user.age || 'N/A';
    
    // Format keywords
    const keywords = user.keywords && user.keywords.length > 0 
        ? user.keywords.map(k => `<span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">${k}</span>`).join(' ')
        : '<span class="text-gray-400">No keywords</span>';
    
    // Build gallery HTML
    let galleryHtml = '';
    if (user.gallery_images && user.gallery_images.length > 0) {
        galleryHtml = `
            <div class="mb-6">
                <!-- Main Image -->
                <div class="relative mb-3">
                    <img id="notifMainImage" src="${user.gallery_images[0]}" 
                         alt="${user.full_name}" 
                         class="w-full h-64 object-cover rounded-2xl shadow-lg">
                    ${user.is_verified ? '<div class="absolute top-3 right-3 bg-blue-500 text-white rounded-full px-3 py-1 text-sm font-medium shadow-lg"><i class="fas fa-check mr-1"></i>Verified</div>' : ''}
                    ${user.gallery_images.length > 1 ? `<div class="absolute bottom-3 right-3 bg-black/60 text-white px-3 py-1 rounded-full text-sm"><i class="fas fa-images mr-1"></i>${user.gallery_images.length}</div>` : ''}
                </div>
                <!-- Thumbnail Strip -->
                ${user.gallery_images.length > 1 ? `
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        ${user.gallery_images.map((img, index) => `
                            <img src="${img}" 
                                 alt="Photo ${index + 1}" 
                                 class="w-16 h-16 object-cover rounded-lg cursor-pointer transition-all ${index === 0 ? 'ring-2 ring-purple-500' : 'opacity-60 hover:opacity-100'}"
                                 onclick="changeNotifImage('${img}', this)">
                        `).join('')}
                    </div>
                ` : ''}
            </div>
        `;
    } else {
        // SVG placeholder when no photos
        galleryHtml = `
            <div class="flex justify-center mb-6">
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center border-4 border-purple-200 shadow-lg">
                    <svg class="w-16 h-16 text-purple-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        `;
    }
    
    modalContent.innerHTML = `
        <!-- Photo Gallery -->
        ${galleryHtml}
        
        <!-- Profile Info -->
        <div class="space-y-4 mb-6">
            <!-- Name and Age -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center justify-center">
                    ${user.full_name}
                    ${user.is_verified ? '<i class="fas fa-badge-check text-blue-500 ml-2" title="Verified"></i>' : ''}
                </h3>
                <p class="text-gray-600 text-lg mt-1">${age} years old</p>
            </div>
            
            <!-- Location -->
            ${user.location ? `
                <div class="flex items-center justify-center text-gray-700">
                    <i class="fas fa-map-marker-alt text-valentine-500 mr-2"></i>
                    <span>${user.location}</span>
                </div>
            ` : ''}
            
            <!-- Bio -->
            ${user.bio ? `
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4 border-2 border-purple-100">
                    <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-quote-left text-purple-500 mr-2"></i>
                        About
                    </h4>
                    <p class="text-gray-700">${user.bio}</p>
                </div>
            ` : ''}
            
            <!-- Keywords -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4 border-2 border-purple-100">
                <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-tags text-purple-500 mr-2"></i>
                    Keywords
                </h4>
                <div class="flex flex-wrap gap-2">
                    ${keywords}
                </div>
            </div>
            
            <!-- Instagram -->
            ${user.instagram_id ? `
                <div class="flex items-center justify-center text-gray-700">
                    <i class="fab fa-instagram text-pink-500 mr-2"></i>
                    <span>@${user.instagram_id}</span>
                </div>
            ` : ''}
        </div>
        
        <!-- Action Buttons (only show if not view-only mode) -->
        ${isViewOnlyMode ? `
            <div class="pt-6 border-t-2 border-gray-100">
                <div class="bg-green-100 text-green-700 px-6 py-3 rounded-xl font-bold flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>You have already accepted this profile
                </div>
            </div>
        ` : `
            <div class="flex items-center gap-4 pt-6 border-t-2 border-gray-100">
                <button onclick="respondToSuggestionFromModal(${suggestion.id}, 'reject')" 
                        class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>Reject
                </button>
                <button onclick="respondToSuggestionFromModal(${suggestion.id}, 'accept')" 
                        class="flex-1 bg-gradient-to-r from-valentine-500 to-pink-500 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-heart mr-2"></i>Accept
                </button>
            </div>
        `}
    `;
}

// Close profile modal
function closeProfileModal(event) {
    if (event && event.target !== event.currentTarget) return;
    
    const modal = document.getElementById('profileModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentSuggestionData = {};
}

// Change main image when clicking thumbnail
function changeNotifImage(imageSrc, thumbElement) {
    // Update main image
    const mainImage = document.getElementById('notifMainImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
    
    // Update thumbnail highlights
    const thumbnails = thumbElement.parentElement.querySelectorAll('img');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('ring-2', 'ring-purple-500');
        thumb.classList.add('opacity-60');
    });
    thumbElement.classList.add('ring-2', 'ring-purple-500');
    thumbElement.classList.remove('opacity-60');
}

// Respond to suggestion from modal
function respondToSuggestionFromModal(suggestionId, action) {
    const modalContent = document.getElementById('modalContent');
    
    // Show loading state
    modalContent.innerHTML = `
        <div class="text-center py-12">
            <i class="fas fa-spinner fa-spin text-4xl text-purple-500 mb-4"></i>
            <p class="text-gray-600">Processing your response...</p>
        </div>
    `;
    
    fetch(`/user/suggestions/${suggestionId}/respond`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ action: action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            modalContent.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                    <p class="text-gray-900 font-bold text-xl mb-2">${data.message}</p>
                    ${data.redirect_url ? '<p class="text-gray-600">Redirecting to payment...</p>' : '<p class="text-gray-600">Updating...</p>'}
                </div>
            `;
            
            // If there's a payment redirect, redirect after delay
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else {
                // Just reload after a short delay to update notification status
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        } else {
            // Show error message
            modalContent.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                    <p class="text-gray-900 font-bold text-xl mb-2">Error</p>
                    <p class="text-gray-600 mb-6">${data.message || 'An error occurred. Please try again.'}</p>
                    <button onclick="openProfileModal(${suggestionId})" class="bg-purple-500 text-white px-6 py-2 rounded-xl font-semibold hover:bg-purple-600 transition-all">
                        Try Again
                    </button>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = `
            <div class="text-center py-12">
                <i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4"></i>
                <p class="text-gray-900 font-bold text-xl mb-2">Error</p>
                <p class="text-gray-600 mb-6">An error occurred. Please try again.</p>
                <button onclick="openProfileModal(${suggestionId})" class="bg-purple-500 text-white px-6 py-2 rounded-xl font-semibold hover:bg-purple-600 transition-all">
                    Try Again
                </button>
            </div>
        `;
    });
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeProfileModal();
    }
});
</script>
@endpush

@endsection
