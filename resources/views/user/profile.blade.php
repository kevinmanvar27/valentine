@extends('layouts.app')

@section('title', 'My Profile - Valentine Partner Finder')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-valentine-100 via-pink-100 to-purple-100 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-300 rounded-full blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl opacity-50 animate-float-slow"></div>
        <div class="absolute top-1/2 right-1/3 w-56 h-56 bg-purple-300 rounded-full blur-3xl opacity-40 animate-float" style="animation-delay: 2s;"></div>
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
                    <h1 class="text-3xl md:text-4xl font-bold text-white">My Profile</h1>
                    <p class="text-white/80 mt-2">View and update your information</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-user-edit text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-6">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Profile Photos Section -->
            <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-xl p-8 border-2 border-valentine-200 animate-fade-in">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-xl flex items-center justify-center mr-4 shadow">
                        <i class="fas fa-camera text-white"></i>
                    </div>
                    Photos
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Live Photo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Live Photo</label>
                        <div class="relative">
                            <div id="livePhotoPreview" class="w-full h-64 rounded-2xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                @if($user->live_image)
                                    <img src="{{ Storage::url($user->live_image) }}" alt="Live Photo" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                                        <p class="text-gray-500">No live photo</p>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="openCameraModal()" class="mt-4 w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-camera mr-2"></i>{{ $user->live_image ? 'Retake' : 'Take' }} Live Photo
                            </button>
                        </div>
                        <input type="hidden" name="live_photo_data" id="livePhotoData">
                    </div>
                    
                    <!-- Gallery Images -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Gallery Images</label>
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @if($user->gallery_images && count($user->gallery_images) > 0)
                                @foreach($user->gallery_images as $image)
                                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($image) }}" alt="Gallery" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                                @for($i = count($user->gallery_images); $i < 6; $i++)
                                    <div class="aspect-square rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <i class="fas fa-plus text-gray-400"></i>
                                    </div>
                                @endfor
                            @else
                                @for($i = 0; $i < 6; $i++)
                                    <div class="aspect-square rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                        <i class="fas fa-plus text-gray-400"></i>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <div class="relative">
                            <input type="file" name="gallery_images[]" id="galleryInput" accept="image/*" multiple class="hidden">
                            <button type="button" onclick="document.getElementById('galleryInput').click()" class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-images mr-2"></i>Upload Gallery Images
                            </button>
                        </div>
                        <p class="text-gray-400 text-sm mt-2">Max 6 images, 5MB each</p>
                    </div>
                </div>
            </div>
            
            <!-- Basic Information -->
            <div class="bg-gradient-to-br from-white to-pink-50 rounded-3xl shadow-xl p-8 border-2 border-pink-200 animate-fade-in" style="animation-delay: 0.1s;">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center mr-4 shadow">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    Basic Information
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('full_name') border-red-500 @enderror">
                        @error('full_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" value="{{ $user->email }}" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 cursor-not-allowed" readonly disabled>
                        <p class="text-gray-400 text-sm mt-1">Email cannot be changed</p>
                    </div>
                    
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-semibold text-gray-700 mb-2">WhatsApp Number</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fab fa-whatsapp text-green-500"></i>
                            </span>
                            <input type="tel" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" 
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('whatsapp_number') border-red-500 @enderror"
                                placeholder="9876543210">
                        </div>
                        @error('whatsapp_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob ? $user->dob->format('Y-m-d') : '') }}" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('dob') border-red-500 @enderror">
                        @if($user->dob)
                            <p class="text-gray-500 text-sm mt-1">Age: {{ $user->age }} years</p>
                        @endif
                        @error('dob')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Gender</label>
                        <select name="gender" id="gender" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('gender') border-red-500 @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-map-marker-alt text-valentine-500"></i>
                            </span>
                            <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('location') border-red-500 @enderror"
                                placeholder="City, State">
                        </div>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- About You Section -->
            <div class="bg-gradient-to-br from-white to-yellow-50 rounded-3xl shadow-xl p-8 border-2 border-yellow-200 animate-fade-in" style="animation-delay: 0.2s;">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mr-4 shadow">
                        <i class="fas fa-heart text-white"></i>
                    </div>
                    About You
                </h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                        <textarea name="bio" id="bio" rows="4" maxlength="500"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 resize-none @error('bio') border-red-500 @enderror"
                            placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        <div class="flex justify-between mt-2">
                            <p class="text-gray-400 text-sm">Share your personality and interests</p>
                            <p class="text-gray-400 text-sm"><span id="bioCount">{{ strlen($user->bio ?? '') }}</span>/500</p>
                        </div>
                        @error('bio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="keywords" class="block text-sm font-semibold text-gray-700 mb-2">Your Interests / Keywords</label>
                        <input type="text" name="keywords" id="keywords" value="{{ old('keywords', is_array($user->keywords) ? implode(', ', $user->keywords) : $user->keywords) }}" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('keywords') border-red-500 @enderror"
                            placeholder="e.g., Music, Travel, Reading, Sports">
                        <p class="text-gray-400 text-sm mt-1">Separate with commas</p>
                        @error('keywords')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if($user->keywords && is_array($user->keywords) && count($user->keywords) > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Interests</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->keywords as $keyword)
                                <span class="px-3 py-1 bg-valentine-100 text-valentine-700 rounded-full text-sm font-medium">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Partner Preferences Section -->
            <div class="bg-gradient-to-br from-white to-purple-50 rounded-3xl shadow-xl p-8 border-2 border-purple-200 animate-fade-in" style="animation-delay: 0.3s;">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center mr-4 shadow">
                        <i class="fas fa-search-heart text-white"></i>
                    </div>
                    Partner Preferences
                </h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="expectation" class="block text-sm font-semibold text-gray-700 mb-2">What are you looking for?</label>
                        <textarea name="expectation" id="expectation" rows="3" maxlength="500"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 resize-none @error('expectation') border-red-500 @enderror"
                            placeholder="Describe your ideal partner...">{{ old('expectation', $user->expectation) }}</textarea>
                        @error('expectation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="expected_keywords" class="block text-sm font-semibold text-gray-700 mb-2">Expected Partner Interests</label>
                        <input type="text" name="expected_keywords" id="expected_keywords" value="{{ old('expected_keywords', is_array($user->expected_keywords) ? implode(', ', $user->expected_keywords) : $user->expected_keywords) }}" 
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('expected_keywords') border-red-500 @enderror"
                            placeholder="e.g., Music, Travel, Reading">
                        <p class="text-gray-400 text-sm mt-1">Separate with commas</p>
                        @error('expected_keywords')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if($user->expected_keywords && is_array($user->expected_keywords) && count($user->expected_keywords) > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Looking for partners interested in</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->expected_keywords as $keyword)
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="preferred_age_min" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Age Range</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="preferred_age_min" id="preferred_age_min" value="{{ old('preferred_age_min', $user->preferred_age_min ?? 13) }}" min="13" max="60"
                                    class="w-24 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('preferred_age_min') border-red-500 @enderror">
                                <span class="text-gray-500">to</span>
                                <input type="number" name="preferred_age_max" id="preferred_age_max" value="{{ old('preferred_age_max', $user->preferred_age_max ?? 30) }}" min="13" max="60"
                                    class="w-24 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-valentine-500 focus:border-valentine-500 transition-all duration-300 @error('preferred_age_max') border-red-500 @enderror">
                                <span class="text-gray-500">years</span>
                            </div>
                            @error('preferred_age_min')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('preferred_age_max')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account Status Section (Read Only) -->
            <div class="bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-xl p-8 border-2 border-green-200 animate-fade-in" style="animation-delay: 0.4s;">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    Account Status
                </h2>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-4 border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Account Status</p>
                        <p class="font-semibold flex items-center">
                            @if($user->status === 'active')
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                <span class="text-green-600">Active</span>
                            @elseif($user->status === 'pending')
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                <span class="text-yellow-600">Pending</span>
                            @else
                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                <span class="text-gray-600">{{ ucfirst($user->status ?? 'Unknown') }}</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                        <p class="font-semibold flex items-center">
                            @if($user->registration_paid)
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span class="text-green-600">Paid</span>
                            @else
                                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                                <span class="text-yellow-600">Pending</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 border border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Verification</p>
                        <p class="font-semibold flex items-center">
                            @if($user->registration_verified)
                                <i class="fas fa-badge-check text-green-500 mr-2"></i>
                                <span class="text-green-600">Verified</span>
                            @else
                                <i class="fas fa-hourglass-half text-yellow-500 mr-2"></i>
                                <span class="text-yellow-600">Pending</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('user.dashboard') }}" class="px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl font-semibold hover:from-gray-200 hover:to-gray-300 transition-all duration-300 shadow">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-valentine-500 to-pink-500 hover:from-valentine-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-bold shadow-xl flex items-center transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Camera Modal -->
<div id="cameraModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border-2 border-valentine-200">
        <div class="gradient-bg-animated p-6 text-white">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Take Live Photo</h3>
                <button type="button" onclick="closeCameraModal()" class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <div class="relative rounded-2xl overflow-hidden bg-gray-900 mb-4">
                <video id="cameraStream" autoplay playsinline class="w-full h-64 object-cover"></video>
                <canvas id="cameraCanvas" class="hidden"></canvas>
            </div>
            
            <div id="capturedPreview" class="hidden mb-4">
                <img id="capturedImage" class="w-full h-64 object-cover rounded-2xl">
            </div>
            
            <div class="flex gap-4">
                <button type="button" id="captureBtn" onclick="capturePhoto()" class="flex-1 btn-primary text-white py-3 rounded-xl font-bold flex items-center justify-center">
                    <i class="fas fa-camera mr-2"></i>Capture
                </button>
                <button type="button" id="retakeBtn" onclick="retakePhoto()" class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hidden items-center justify-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-redo mr-2"></i>Retake
                </button>
                <button type="button" id="usePhotoBtn" onclick="usePhoto()" class="flex-1 bg-green-500 text-white py-3 rounded-xl font-bold hidden items-center justify-center hover:bg-green-600 transition-colors">
                    <i class="fas fa-check mr-2"></i>Use Photo
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Bio character count
document.getElementById('bio')?.addEventListener('input', function() {
    document.getElementById('bioCount').textContent = this.value.length;
});

// Camera functionality
let stream = null;
let capturedData = null;

function openCameraModal() {
    document.getElementById('cameraModal').classList.remove('hidden');
    document.getElementById('cameraModal').classList.add('flex');
    startCamera();
}

function closeCameraModal() {
    document.getElementById('cameraModal').classList.add('hidden');
    document.getElementById('cameraModal').classList.remove('flex');
    stopCamera();
}

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: 'user' } 
        });
        document.getElementById('cameraStream').srcObject = stream;
        document.getElementById('cameraStream').classList.remove('hidden');
        document.getElementById('capturedPreview').classList.add('hidden');
        document.getElementById('captureBtn').classList.remove('hidden');
        document.getElementById('retakeBtn').classList.add('hidden');
        document.getElementById('usePhotoBtn').classList.add('hidden');
    } catch (error) {
        alert('Unable to access camera. Please ensure camera permissions are granted.');
        closeCameraModal();
    }
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function capturePhoto() {
    const video = document.getElementById('cameraStream');
    const canvas = document.getElementById('cameraCanvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    capturedData = canvas.toDataURL('image/jpeg', 0.8);
    
    document.getElementById('capturedImage').src = capturedData;
    document.getElementById('cameraStream').classList.add('hidden');
    document.getElementById('capturedPreview').classList.remove('hidden');
    document.getElementById('captureBtn').classList.add('hidden');
    document.getElementById('retakeBtn').classList.remove('hidden');
    document.getElementById('retakeBtn').classList.add('flex');
    document.getElementById('usePhotoBtn').classList.remove('hidden');
    document.getElementById('usePhotoBtn').classList.add('flex');
}

function retakePhoto() {
    capturedData = null;
    document.getElementById('cameraStream').classList.remove('hidden');
    document.getElementById('capturedPreview').classList.add('hidden');
    document.getElementById('captureBtn').classList.remove('hidden');
    document.getElementById('retakeBtn').classList.add('hidden');
    document.getElementById('retakeBtn').classList.remove('flex');
    document.getElementById('usePhotoBtn').classList.add('hidden');
    document.getElementById('usePhotoBtn').classList.remove('flex');
}

function usePhoto() {
    document.getElementById('livePhotoData').value = capturedData;
    document.getElementById('livePhotoPreview').innerHTML = `<img src="${capturedData}" class="w-full h-full object-cover">`;
    closeCameraModal();
}
</script>
@endpush
@endsection
