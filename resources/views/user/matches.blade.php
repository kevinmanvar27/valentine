@section('title', 'My Matches - Valentine Partner Finder')

@section('content')
<!-- Clean Valentine Theme - Matches Page -->
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
                        My Matches
                    </h1>
                    <p class="text-white/80 mt-1">Your mutual connections are waiting!</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 rounded-xl px-5 py-2.5 text-white">
                        <span class="text-xl font-bold">{{ $matches->count() }}</span>
                        <span class="text-white/80 ml-2">Matches</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($matches->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center max-w-2xl mx-auto">
                <div class="w-20 h-20 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-rose-500 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-3">No Matches Yet</h2>
                <p class="text-gray-600 mb-6">When someone you like also likes you back, they'll appear here. Keep exploring to find your Valentine!</p>
                <a href="{{ route('user.suggestions') }}" class="bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center transition-colors">
                    <i class="fas fa-heart mr-2"></i>Browse Suggestions
                </a>
            </div>
        @else
            <!-- Match Celebration Banner -->
            <div class="bg-rose-500 rounded-2xl p-6 mb-6 text-white">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center">
                        <div class="text-4xl mr-4">🎉</div>
                        <div>
                            <h2 class="text-xl font-bold mb-1">Congratulations!</h2>
                            <p class="text-white/90">You have {{ $matches->count() }} mutual match{{ $matches->count() > 1 ? 'es' : '' }}! Start connecting now.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-3xl">
                        💕 💖 💕
                    </div>
                </div>
            </div>
            
            <!-- Matches Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($matches as $index => $match)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:border-rose-200 transition-all">
                        <!-- Match Badge -->
                        <div class="bg-rose-500 px-4 py-2 text-white text-center text-sm font-medium">
                            <i class="fas fa-check-circle mr-2"></i>
                            Matched {{ $match->match_created_at ? $match->match_created_at->diffForHumans() : 'recently' }}
                        </div>
                        
                        <!-- Photo Section with Gallery -->
                        <div class="relative h-64 overflow-hidden group">
                            @if($match->gallery_images && count($match->gallery_images) > 0)
                                <img src="{{ Storage::url($match->gallery_images[0]) }}" alt="{{ $match->full_name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                
                                <!-- Photo Count Badge -->
                                @if(count($match->gallery_images) > 1)
                                    <button onclick="openGallery({{ json_encode($match->gallery_images) }}, '{{ $match->full_name }}')" 
                                            class="absolute bottom-4 right-4 bg-black/50 text-white px-3 py-1.5 rounded-full text-xs font-medium flex items-center hover:bg-black/70 transition-colors cursor-pointer">
                                        <i class="fas fa-images mr-1"></i>{{ count($match->gallery_images) }} Photos
                                    </button>
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
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                            
                            <!-- Verified Badge -->
                            @if($match->registration_verified)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-emerald-500 text-white px-2.5 py-1 rounded-lg text-xs font-medium flex items-center">
                                        <i class="fas fa-shield-check mr-1"></i>Verified
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Heart Icon -->
                            <div class="absolute top-4 right-4 w-10 h-10 bg-rose-500 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-heart"></i>
                            </div>
                            
                            <!-- Basic Info Overlay -->
                            <div class="absolute bottom-4 left-4 right-16 text-white">
                                <h3 class="text-xl font-bold mb-1">{{ $match->full_name }}, {{ $match->age }}</h3>
                                <p class="text-white/90 text-sm flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $match->location }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Info Section -->
                        <div class="p-5">
                            @if($match->bio)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $match->bio }}</p>
                            @endif
                            
                            <!-- Payment Status Info -->
                            @php
                                $userPayment = $match->user_payment;
                                $partnerPayment = $match->partner_payment;
                            @endphp
                            
                            <!-- Contact Info (if both payments verified) -->
                            @if($match->contact_unlocked)
                                <div class="bg-emerald-50 rounded-xl p-4 mb-4 border border-emerald-100">
                                    <p class="text-emerald-700 text-sm font-medium mb-3">
                                        <i class="fas fa-unlock mr-2"></i>Contact Unlocked
                                    </p>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 text-sm flex items-center">
                                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>WhatsApp
                                            </span>
                                            <button onclick="copyToClipboard('{{ $match->whatsapp_number }}')" class="text-rose-600 text-sm font-medium hover:underline flex items-center">
                                                {{ $match->whatsapp_number }}
                                                <i class="fas fa-copy ml-2"></i>
                                            </button>
                                        </div>
                                        @if($match->instagram_id)
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600 text-sm flex items-center">
                                                    <i class="fab fa-instagram text-purple-500 mr-2"></i>Instagram
                                                </span>
                                                <a href="https://instagram.com/{{ $match->instagram_id }}" target="_blank" class="text-rose-600 text-sm font-medium hover:underline">
                                                    @{{ $match->instagram_id }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $match->whatsapp_number) }}" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-semibold flex items-center justify-center transition-colors">
                                        <i class="fab fa-whatsapp mr-2"></i>Message
                                    </a>
                                    @if($match->instagram_id)
                                        <a href="https://instagram.com/{{ $match->instagram_id }}" target="_blank" class="w-12 h-12 bg-purple-500 hover:bg-purple-600 text-white rounded-xl flex items-center justify-center transition-colors">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <!-- Payment Status -->
                                <div class="bg-rose-50 rounded-xl p-4 mb-4 border border-rose-100">
                                    <p class="text-rose-700 text-sm font-medium mb-2">
                                        <i class="fas fa-lock mr-2"></i>Contact Locked
                                    </p>
                                    
                                    <!-- Show detailed payment status -->
                                    <div class="space-y-2 text-xs">
                                        @if($userPayment)
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Your Payment:</span>
                                                @if($userPayment->status === 'verified')
                                                    <span class="text-emerald-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                                                @elseif($userPayment->status === 'submitted')
                                                    <span class="text-amber-600 font-medium"><i class="fas fa-clock mr-1"></i>Under Review</span>
                                                @elseif($userPayment->status === 'rejected')
                                                    <span class="text-red-600 font-medium"><i class="fas fa-times-circle mr-1"></i>Rejected</span>
                                                @else
                                                    <span class="text-gray-500 font-medium"><i class="fas fa-hourglass mr-1"></i>Pending</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        @if($partnerPayment)
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Partner's Payment:</span>
                                                @if($partnerPayment->status === 'verified')
                                                    <span class="text-emerald-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                                                @elseif($partnerPayment->status === 'submitted')
                                                    <span class="text-amber-600 font-medium"><i class="fas fa-clock mr-1"></i>Under Review</span>
                                                @else
                                                    <span class="text-gray-500 font-medium"><i class="fas fa-hourglass mr-1"></i>Pending</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Partner's Payment:</span>
                                                <span class="text-gray-500 font-medium"><i class="fas fa-hourglass mr-1"></i>Waiting for acceptance</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <p class="text-rose-600 text-xs mt-2">
                                        @if(!$userPayment || $userPayment->status === 'pending' || $userPayment->status === 'rejected')
                                            Pay to unlock contact details
                                        @elseif($userPayment->status === 'submitted')
                                            Waiting for admin verification
                                        @elseif($userPayment->status === 'verified' && (!$partnerPayment || $partnerPayment->status !== 'verified'))
                                            Waiting for partner's payment verification
                                        @endif
                                    </p>
                                </div>
                                
                                @if(!$userPayment || $userPayment->status === 'pending' || $userPayment->status === 'rejected')
                                    <a href="{{ route('user.matches.payment', $match->match_id) }}" class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3 rounded-xl font-semibold flex items-center justify-center transition-colors">
                                        <i class="fas fa-unlock mr-2"></i>
                                        @if($userPayment && $userPayment->status === 'rejected')
                                            Resubmit Payment
                                        @else
                                            Unlock Contact
                                        @endif
                                    </a>
                                @elseif($userPayment->status === 'submitted')
                                    <div class="w-full bg-amber-100 text-amber-700 py-3 rounded-xl font-semibold flex items-center justify-center">
                                        <i class="fas fa-clock mr-2"></i>Payment Under Review
                                    </div>
                                @elseif($userPayment->status === 'verified')
                                    <div class="w-full bg-blue-100 text-blue-700 py-3 rounded-xl font-semibold flex items-center justify-center">
                                        <i class="fas fa-hourglass-half mr-2"></i>Waiting for Partner
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Photo Gallery Modal - Clean Design -->
<div id="galleryModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center">
    <div class="absolute inset-0" onclick="closeGallery()"></div>
    
    <!-- Close Button -->
    <button onclick="closeGallery()" class="absolute top-4 right-4 w-11 h-11 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors z-10">
        <i class="fas fa-times text-lg"></i>
    </button>
    
    <!-- User Name -->
    <div id="galleryUserName" class="absolute top-4 left-4 text-white text-lg font-semibold z-10"></div>
    
    <!-- Navigation Arrows -->
    <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors z-10">
        <i class="fas fa-chevron-left text-lg"></i>
    </button>
    <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors z-10">
        <i class="fas fa-chevron-right text-lg"></i>
    </button>
    
    <!-- Main Image -->
    <div class="relative max-w-4xl max-h-[80vh] mx-auto">
        <img id="galleryImage" src="" alt="Gallery" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-xl">
    </div>
    
    <!-- Image Counter -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded-lg text-sm">
        <span id="imageCounter">1 / 1</span>
    </div>
    
    <!-- Thumbnail Strip -->
    <div id="thumbnailStrip" class="absolute bottom-16 left-1/2 -translate-x-1/2 flex gap-2 max-w-full overflow-x-auto px-4 pb-2">
        <!-- Thumbnails added dynamically -->
    </div>
</div>

@push('scripts')
<script>
let galleryImages = [];
let currentImageIndex = 0;

function openGallery(images, userName) {
    galleryImages = images;
    currentImageIndex = 0;
    
    document.getElementById('galleryUserName').textContent = userName + "'s Photos";
    
    // Build thumbnails
    const strip = document.getElementById('thumbnailStrip');
    strip.innerHTML = '';
    images.forEach((img, index) => {
        const thumb = document.createElement('img');
        thumb.src = '/storage/' + img;
        thumb.className = 'w-16 h-16 object-cover rounded-lg cursor-pointer transition-all ' + (index === 0 ? 'ring-2 ring-white' : 'opacity-60 hover:opacity-100');
        thumb.onclick = () => goToImage(index);
        strip.appendChild(thumb);
    });
    
    updateGalleryImage();
    
    const modal = document.getElementById('galleryModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeGallery() {
    const modal = document.getElementById('galleryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function updateGalleryImage() {
    const img = document.getElementById('galleryImage');
    img.src = '/storage/' + galleryImages[currentImageIndex];
    
    document.getElementById('imageCounter').textContent = (currentImageIndex + 1) + ' / ' + galleryImages.length;
    
    // Update thumbnail highlights
    const thumbs = document.getElementById('thumbnailStrip').children;
    Array.from(thumbs).forEach((thumb, index) => {
        if (index === currentImageIndex) {
            thumb.classList.add('ring-2', 'ring-white');
            thumb.classList.remove('opacity-60');
        } else {
            thumb.classList.remove('ring-2', 'ring-white');
            thumb.classList.add('opacity-60');
        }
    });
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    updateGalleryImage();
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    updateGalleryImage();
}

function goToImage(index) {
    currentImageIndex = index;
    updateGalleryImage();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('galleryModal');
    if (!modal.classList.contains('hidden')) {
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeGallery();
    }
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50';
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