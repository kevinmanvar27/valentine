@extends('layouts.app')

@section('title', 'Notifications - Valentine Partner Finder')

@push('styles')
<style>
    /* Modal animations - keep minimal */
    #profileModal {
        animation: fadeIn 0.2s ease-out;
    }
    
    #profileModal > div {
        animation: slideUp 0.2s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
<!-- Clean background - no animated decorations -->
<div class="min-h-screen bg-gray-50">
    
    <!-- Header - Clean rose background -->
    <div class="bg-rose-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="text-white/80 hover:text-white transition-colors mb-3 inline-flex items-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-white flex items-center font-serif">
                        <i class="fas fa-bell mr-3"></i>
                        Notifications
                    </h1>
                    <p class="text-white/80 mt-1">Stay updated with your matches and activities</p>
                </div>
                @if($notifications->count() > 0)
                    <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white/20 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-white/30 transition-colors flex items-center">
                            <i class="fas fa-check-double mr-2"></i>Mark All Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($notifications->isEmpty())
            <!-- Empty State - Clean white card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-bell-slash text-gray-400 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-3">No Notifications</h2>
                <p class="text-gray-600 mb-6">You're all caught up! When something happens, you'll see it here.</p>
                <a href="{{ route('user.suggestions') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center transition-colors">
                    <i class="fas fa-heart mr-2"></i>Find Matches
                </a>
            </div>
        @else
            <!-- Notifications List -->
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    @php
                        $typeConfig = [
                            'match' => ['icon' => 'fa-heart', 'bg' => 'bg-rose-500', 'bgLight' => 'bg-rose-50', 'text' => 'text-rose-600'],
                            'like' => ['icon' => 'fa-heart', 'bg' => 'bg-pink-500', 'bgLight' => 'bg-pink-50', 'text' => 'text-pink-600'],
                            'payment' => ['icon' => 'fa-credit-card', 'bg' => 'bg-emerald-500', 'bgLight' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                            'verification' => ['icon' => 'fa-shield-check', 'bg' => 'bg-blue-500', 'bgLight' => 'bg-blue-50', 'text' => 'text-blue-600'],
                            'profile_suggestion' => ['icon' => 'fa-user-plus', 'bg' => 'bg-purple-500', 'bgLight' => 'bg-purple-50', 'text' => 'text-purple-600'],
                            'system' => ['icon' => 'fa-info-circle', 'bg' => 'bg-gray-500', 'bgLight' => 'bg-gray-50', 'text' => 'text-gray-600'],
                            'warning' => ['icon' => 'fa-exclamation-triangle', 'bg' => 'bg-amber-500', 'bgLight' => 'bg-amber-50', 'text' => 'text-amber-600'],
                        ];
                        $type = $notification->type ?? 'system';
                        $config = $typeConfig[$type] ?? $typeConfig['system'];
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden {{ !$notification->read_at ? 'ring-2 ring-rose-200' : '' }}">
                        <div class="flex items-start p-5">
                            <!-- Icon -->
                            <div class="flex-shrink-0 w-10 h-10 {{ $config['bg'] }} rounded-xl flex items-center justify-center mr-4">
                                <i class="fas {{ $config['icon'] }} text-white text-sm"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-1.5">
                                    <h3 class="text-base font-semibold text-gray-900">{{ $notification->title }}</h3>
                                    @if(!$notification->is_read)
                                        <span class="bg-rose-500 text-white text-xs px-2 py-0.5 rounded-lg font-medium ml-2 flex-shrink-0">
                                            New
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm mb-3">{{ $notification->message }}</p>
                                
                                <!-- Profile Suggestion Actions -->
                                @if($notification->type === 'profile_suggestion' && $notification->related_id)
                                    @php
                                        $suggestion = $notification->profileSuggestion;
                                        $suggestedUser = $suggestion ? $suggestion->suggestedUser : null;
                                        $suggestionStatus = $suggestion ? $suggestion->status : null;
                                    @endphp
                                    @if($suggestionStatus === 'pending' && $suggestedUser)
                                        <button onclick="openProfileModal({{ $notification->related_id }})" 
                                                class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl font-medium transition-colors flex items-center text-sm mb-3">
                                            <i class="fas fa-user mr-2"></i>View Profile
                                        </button>
                                    @elseif($suggestionStatus === 'accepted' && $suggestedUser)
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-lg font-medium text-sm">
                                                <i class="fas fa-check-circle mr-1.5"></i>Accepted
                                            </span>
                                            <button onclick="openProfileModal({{ $notification->related_id }}, true)" 
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg font-medium transition-colors flex items-center text-sm">
                                                <i class="fas fa-eye mr-1.5"></i>View
                                            </button>
                                        </div>
                                    @elseif($suggestionStatus === 'rejected')
                                        <span class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg font-medium text-sm mb-3">
                                            <i class="fas fa-times-circle mr-1.5"></i>Rejected
                                        </span>
                                    @endif
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm flex items-center">
                                        <i class="far fa-clock mr-1.5"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center gap-3">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" class="text-rose-600 text-sm font-medium hover:underline flex items-center">
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
                        
                        <!-- Unread Indicator - simple rose bar -->
                        @if(!$notification->is_read)
                            <div class="h-0.5 bg-rose-500"></div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Profile Modal - Clean design -->
<div id="profileModal" class="fixed inset-0 bg-black/70 z-50 hidden flex items-center justify-center p-4" onclick="closeProfileModal(event)">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <!-- Modal Header - Clean rose -->
        <div class="sticky top-0 bg-rose-500 text-white p-5 rounded-t-2xl flex items-center justify-between">
            <h2 class="text-xl font-bold flex items-center font-serif">
                <i class="fas fa-user-circle mr-3"></i>
                Profile Details
            </h2>
            <button onclick="closeProfileModal()" class="text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div id="modalContent" class="p-6">
            <!-- Loading State -->
            <div class="text-center py-10">
                <i class="fas fa-spinner fa-spin text-3xl text-rose-500 mb-4"></i>
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
                <div class="text-center py-10">
                    <i class="fas fa-exclamation-circle text-3xl text-red-500 mb-4"></i>
                    <p class="text-gray-600">${data.message || 'Failed to load profile'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = `
            <div class="text-center py-10">
                <i class="fas fa-exclamation-circle text-3xl text-red-500 mb-4"></i>
                <p class="text-gray-600">An error occurred while loading the profile.</p>
            </div>
        `;
    });
}

// Render profile modal content - Clean design
function renderProfileModal(suggestion) {
    const user = suggestion.suggested_user;
    const modalContent = document.getElementById('modalContent');
    
    const age = user.age || 'N/A';
    
    // Format keywords - clean badges
    const keywords = user.keywords && user.keywords.length > 0 
        ? user.keywords.map(k => `<span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-sm">${k}</span>`).join(' ')
        : '<span class="text-gray-400">No keywords</span>';
    
    // Build gallery HTML
    let galleryHtml = '';
    if (user.gallery_images && user.gallery_images.length > 0) {
        galleryHtml = `
            <div class="mb-6">
                <div class="relative mb-3">
                    <img id="notifMainImage" src="${user.gallery_images[0]}" 
                         alt="${user.full_name}" 
                         class="w-full h-64 object-cover rounded-xl">
                    ${user.is_verified ? '<div class="absolute top-3 right-3 bg-blue-500 text-white rounded-full px-3 py-1 text-sm font-medium"><i class="fas fa-check mr-1"></i>Verified</div>' : ''}
                    ${user.gallery_images.length > 1 ? `<div class="absolute bottom-3 right-3 bg-black/60 text-white px-3 py-1 rounded-full text-sm"><i class="fas fa-images mr-1"></i>${user.gallery_images.length}</div>` : ''}
                </div>
                ${user.gallery_images.length > 1 ? `
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        ${user.gallery_images.map((img, index) => `
                            <img src="${img}" 
                                 alt="Photo ${index + 1}" 
                                 class="w-14 h-14 object-cover rounded-lg cursor-pointer transition-all ${index === 0 ? 'ring-2 ring-rose-500' : 'opacity-60 hover:opacity-100'}"
                                 onclick="changeNotifImage('${img}', this)">
                        `).join('')}
                    </div>
                ` : ''}
            </div>
        `;
    } else {
        galleryHtml = `
            <div class="flex justify-center mb-6">
                <div class="w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-14 h-14 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        `;
    }
    
    modalContent.innerHTML = `
        ${galleryHtml}
        
        <div class="space-y-4 mb-6">
            <!-- Name and Age -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center justify-center font-serif">
                    ${user.full_name}
                    ${user.is_verified ? '<i class="fas fa-badge-check text-blue-500 ml-2 text-lg" title="Verified"></i>' : ''}
                </h3>
                <p class="text-gray-600 mt-1">${age} years old</p>
            </div>
            
            <!-- Location -->
            ${user.location ? `
                <div class="flex items-center justify-center text-gray-600">
                    <i class="fas fa-map-marker-alt text-rose-500 mr-2"></i>
                    <span>${user.location}</span>
                </div>
            ` : ''}
            
            <!-- Bio -->
            ${user.bio ? `
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-quote-left text-rose-400 mr-2"></i>
                        About
                    </h4>
                    <p class="text-gray-700">${user.bio}</p>
                </div>
            ` : ''}
            
            <!-- Keywords -->
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-tags text-rose-400 mr-2"></i>
                    Keywords
                </h4>
                <div class="flex flex-wrap gap-2">
                    ${keywords}
                </div>
            </div>
            
            <!-- Instagram -->
            ${user.instagram_id ? `
                <div class="flex items-center justify-center text-gray-600">
                    <i class="fab fa-instagram text-pink-500 mr-2"></i>
                    <span>@${user.instagram_id}</span>
                </div>
            ` : ''}
        </div>
        
        <!-- Action Buttons -->
        ${isViewOnlyMode ? `
            <div class="pt-5 border-t border-gray-100">
                <div class="bg-emerald-50 text-emerald-700 px-5 py-3 rounded-xl font-semibold flex items-center justify-center border border-emerald-100">
                    <i class="fas fa-check-circle mr-2"></i>You have already accepted this profile
                </div>
            </div>
        ` : `
            <div class="flex items-center gap-3 pt-5 border-t border-gray-100">
                <button onclick="respondToSuggestionFromModal(${suggestion.id}, 'reject')" 
                        class="flex-1 bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>Reject
                </button>
                <button onclick="respondToSuggestionFromModal(${suggestion.id}, 'accept')" 
                        class="flex-1 bg-rose-500 hover:bg-rose-600 text-white px-5 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
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
    const mainImage = document.getElementById('notifMainImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
    
    const thumbnails = thumbElement.parentElement.querySelectorAll('img');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('ring-2', 'ring-rose-500');
        thumb.classList.add('opacity-60');
    });
    thumbElement.classList.add('ring-2', 'ring-rose-500');
    thumbElement.classList.remove('opacity-60');
}

// Respond to suggestion from modal
function respondToSuggestionFromModal(suggestionId, action) {
    const modalContent = document.getElementById('modalContent');
    
    modalContent.innerHTML = `
        <div class="text-center py-10">
            <i class="fas fa-spinner fa-spin text-3xl text-rose-500 mb-4"></i>
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
            modalContent.innerHTML = `
                <div class="text-center py-10">
                    <i class="fas fa-check-circle text-3xl text-emerald-500 mb-4"></i>
                    <p class="text-gray-900 font-bold text-lg mb-2">${data.message}</p>
                    ${data.redirect_url ? '<p class="text-gray-600">Redirecting to payment...</p>' : '<p class="text-gray-600">Updating...</p>'}
                </div>
            `;
            
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        } else {
            modalContent.innerHTML = `
                <div class="text-center py-10">
                    <i class="fas fa-exclamation-circle text-3xl text-red-500 mb-4"></i>
                    <p class="text-gray-900 font-bold text-lg mb-2">Error</p>
                    <p class="text-gray-600 mb-5">${data.message || 'An error occurred. Please try again.'}</p>
                    <button onclick="openProfileModal(${suggestionId})" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl font-semibold transition-colors">
                        Try Again
                    </button>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = `
            <div class="text-center py-10">
                <i class="fas fa-exclamation-circle text-3xl text-red-500 mb-4"></i>
                <p class="text-gray-900 font-bold text-lg mb-2">Error</p>
                <p class="text-gray-600 mb-5">An error occurred. Please try again.</p>
                <button onclick="openProfileModal(${suggestionId})" class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl font-semibold transition-colors">
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
