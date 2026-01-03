@extends('layouts.app')

@section('title', 'Register - Valentine Partner Finder')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-500 rounded-2xl mb-4 shadow-lg">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-serif">
                Join Valentine Finder
            </h1>
            <p class="text-gray-600">
                Create your profile and find your perfect Valentine match
            </p>
        </div>
        
        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-3 md:space-x-4">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div id="step1-indicator" class="w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <span class="ml-2 font-medium text-gray-900 hidden md:block text-sm">Account</span>
                </div>
                
                <!-- Progress Line 1 -->
                <div class="w-8 md:w-16 h-0.5 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progress-bar-1" class="h-full bg-rose-500 transition-all duration-500" style="width: 0%"></div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div id="step2-indicator" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 font-semibold transition-all duration-300">
                        <i class="fas fa-id-card text-sm"></i>
                    </div>
                    <span class="ml-2 font-medium text-gray-400 hidden md:block text-sm" id="step2-text">Profile</span>
                </div>
                
                <!-- Progress Line 2 -->
                <div class="w-8 md:w-16 h-0.5 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progress-bar-2" class="h-full bg-rose-500 transition-all duration-500" style="width: 0%"></div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex items-center">
                    <div id="step3-indicator" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 font-semibold transition-all duration-300">
                        <i class="fas fa-heart text-sm"></i>
                    </div>
                    <span class="ml-2 font-medium text-gray-400 hidden md:block text-sm" id="step3-text">Expectations</span>
                </div>
            </div>
        </div>
        
        <!-- Registration Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 m-6 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold mb-2">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
                @csrf
                
                <!-- ==================== STEP 1: Account Information ==================== -->
                <div id="step1" class="p-6 md:p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-user text-rose-500"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Account Information</h2>
                            <p class="text-gray-500 text-sm">Create your login credentials</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all"
                                   placeholder="Enter your full name" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all"
                                   placeholder="Enter your email" required>
                        </div>
                        
                        <!-- WhatsApp Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <i class="fab fa-whatsapp text-green-500 mr-1"></i>WhatsApp Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-3 bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl text-gray-600 font-medium text-sm">
                                    +91
                                </span>
                                <input type="tel" name="whatsapp_number" value="{{ old('whatsapp_number') }}"
                                       class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-r-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all"
                                       placeholder="10-digit number" maxlength="10" required>
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all pr-12"
                                       placeholder="Create a password" required>
                                <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative md:w-1/2">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all pr-12"
                                       placeholder="Confirm your password" required>
                                <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Next Button -->
                    <div class="mt-8">
                        <button type="button" onclick="goToStep(2)" 
                                class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                            Continue to Profile
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- ==================== STEP 2: Profile Information ==================== -->
                <div id="step2" class="p-6 md:p-8 hidden">
                    <div class="flex items-center mb-6">
                        <button type="button" onclick="goToStep(1)" class="mr-3 w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-rose-500"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Profile Information</h2>
                            <p class="text-gray-500 text-sm">Tell us about yourself</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-5">
                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all appearance-none cursor-pointer" required>
                                <option value="">Select your gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        
                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Date of Birth <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="dob" value="{{ old('dob') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all"
                                   max="{{ date('Y-m-d', strtotime('-13 years')) }}" required>
                            <p class="text-xs text-gray-400 mt-1">You must be at least 13 years old</p>
                        </div>
                        
                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all"
                                   placeholder="Enter your city (e.g., Mumbai, Delhi)" required>
                        </div>
                    </div>
                    
                    <!-- Photo Upload Section -->
                    <div class="mt-6 p-5 bg-gray-50 border border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-camera text-rose-500 mr-2"></i>Photo Verification
                        </h3>
                        
                        <div class="grid md:grid-cols-2 gap-5">
                            <!-- Live Photo Capture -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Live Verification Photo <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="hidden" name="live_photo" id="livePhotoInput">
                                    <div id="livePhotoContainer" class="w-full h-44 bg-white border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center overflow-hidden">
                                        <video id="video" class="hidden w-full h-full object-cover rounded-xl"></video>
                                        <canvas id="canvas" class="hidden"></canvas>
                                        <img id="livePhotoPreview" class="hidden w-full h-full object-cover rounded-xl">
                                        <div id="cameraPlaceholder" class="text-center p-4">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <i class="fas fa-video text-gray-400"></i>
                                            </div>
                                            <p class="text-gray-600 font-medium text-sm">Live photo capture</p>
                                            <p class="text-gray-400 text-xs mt-1">Click button to start camera</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-3">
                                        <button type="button" onclick="startCamera()" id="startCameraBtn"
                                                class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-xl font-medium hover:bg-gray-200 transition-colors flex items-center justify-center text-sm">
                                            <i class="fas fa-video mr-2"></i>Start Camera
                                        </button>
                                        <button type="button" onclick="capturePhoto()" id="captureBtn"
                                                class="flex-1 bg-rose-500 text-white py-2.5 rounded-xl font-medium hover:bg-rose-600 transition-colors flex items-center justify-center hidden text-sm">
                                            <i class="fas fa-camera mr-2"></i>Capture
                                        </button>
                                        <button type="button" onclick="retakePhoto()" id="retakeBtn"
                                                class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-xl font-medium hover:bg-gray-200 transition-colors flex items-center justify-center hidden text-sm">
                                            <i class="fas fa-redo mr-2"></i>Retake
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Gallery Photos Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Gallery Photos <span class="text-gray-400 font-normal">(Up to 5)</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="gallery_photos[]" id="galleryInput" accept="image/*" multiple class="hidden" onchange="previewGallery(this)">
                                    <div id="galleryPreview" onclick="document.getElementById('galleryInput').click()"
                                         class="w-full h-44 bg-white border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-rose-400 hover:bg-rose-50 transition-all overflow-hidden">
                                        <div class="text-center p-4" id="galleryPlaceholder">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <i class="fas fa-cloud-upload-alt text-gray-400"></i>
                                            </div>
                                            <p class="text-gray-600 font-medium text-sm">Click to upload photos</p>
                                            <p class="text-gray-400 text-xs mt-1">JPG, PNG up to 5MB each</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- About You -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            About You <span class="text-red-500">*</span>
                        </label>
                        <textarea name="bio" rows="3"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all resize-none"
                                  placeholder="Share your interests, hobbies, what makes you unique..." required>{{ old('bio') }}</textarea>
                    </div>
                    
                    <!-- Your Qualities/Keywords -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Your Qualities <span class="text-red-500">*</span>
                            <span class="text-gray-400 font-normal ml-1">(Select qualities that describe you)</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2" id="yourQualities">
                            @php
                                $qualities = ['Caring', 'Funny', 'Adventurous', 'Creative', 'Ambitious', 'Loyal', 'Romantic', 'Intelligent', 'Kind', 'Honest', 'Confident', 'Calm', 'Energetic', 'Supportive', 'Optimistic', 'Passionate'];
                            @endphp
                            @foreach($qualities as $quality)
                                <label class="quality-checkbox relative cursor-pointer">
                                    <input type="checkbox" name="keywords[]" value="{{ $quality }}" class="hidden peer" {{ in_array($quality, old('keywords', [])) ? 'checked' : '' }}>
                                    <div class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-center text-sm font-medium text-gray-600 transition-all peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 hover:border-rose-300">
                                        {{ $quality }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        
                        <!-- Add Custom Quality -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Add Your Own Quality
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="customQualityInput" 
                                       class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all text-sm"
                                       placeholder="Type a quality and press Add...">
                                <button type="button" onclick="addCustomQuality()" 
                                        class="px-5 py-2.5 bg-rose-500 text-white rounded-xl font-medium hover:bg-rose-600 transition-colors text-sm">
                                    <i class="fas fa-plus mr-1"></i>Add
                                </button>
                            </div>
                            <div id="customQualitiesContainer" class="flex flex-wrap gap-2 mt-3"></div>
                        </div>
                    </div>
                    
                    <!-- Next Button -->
                    <div class="mt-8">
                        <button type="button" onclick="goToStep(3)" 
                                class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                            Continue to Expectations
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- ==================== STEP 3: Partner Expectations ==================== -->
                <div id="step3" class="p-6 md:p-8 hidden">
                    <div class="flex items-center mb-6">
                        <button type="button" onclick="goToStep(2)" class="mr-3 w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-heart text-rose-500"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Partner Expectations</h2>
                            <p class="text-gray-500 text-sm">What are you looking for?</p>
                        </div>
                    </div>
                    
                    <!-- Expectation Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            What are you looking for in a partner? <span class="text-red-500">*</span>
                        </label>
                        <textarea name="expectation" rows="4"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all resize-none"
                                  placeholder="Describe your ideal partner - their personality, values, interests..." required>{{ old('expectation') }}</textarea>
                    </div>
                    
                    <!-- Expected Partner Qualities -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Qualities You're Looking For <span class="text-red-500">*</span>
                            <span class="text-gray-400 font-normal ml-1">(Select or add qualities)</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2" id="expectedQualities">
                            @php
                                $expectedQualities = ['Caring', 'Funny', 'Adventurous', 'Creative', 'Ambitious', 'Loyal', 'Romantic', 'Intelligent', 'Kind', 'Honest', 'Confident', 'Calm', 'Energetic', 'Supportive', 'Optimistic', 'Passionate'];
                            @endphp
                            @foreach($expectedQualities as $quality)
                                <label class="quality-checkbox relative cursor-pointer">
                                    <input type="checkbox" name="expected_keywords[]" value="{{ $quality }}" class="hidden peer" {{ in_array($quality, old('expected_keywords', [])) ? 'checked' : '' }}>
                                    <div class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-center text-sm font-medium text-gray-600 transition-all peer-checked:bg-pink-50 peer-checked:border-pink-500 peer-checked:text-pink-700 hover:border-pink-300">
                                        {{ $quality }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        
                        <!-- Custom Quality Input -->
                        <div class="mt-4">
                            <div class="flex gap-2">
                                <input type="text" id="customExpectedQuality" 
                                       class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-100 focus:bg-white transition-all text-sm"
                                       placeholder="Add your own quality...">
                                <button type="button" onclick="addCustomExpectedQuality()"
                                        class="px-5 py-2.5 bg-pink-500 text-white rounded-xl font-medium hover:bg-pink-600 transition-colors text-sm">
                                    <i class="fas fa-plus mr-1"></i>Add
                                </button>
                            </div>
                            <div id="customExpectedQualitiesContainer" class="flex flex-wrap gap-2 mt-3"></div>
                        </div>
                    </div>
                    
                    <!-- Age Preference -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Preferred Age Range
                        </label>
                        <div class="flex items-center gap-3 md:w-1/2">
                            <input type="number" name="preferred_age_min" value="{{ old('preferred_age_min', 13) }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all text-sm"
                                   placeholder="Min" min="13" max="100">
                            <span class="text-gray-400 text-sm">to</span>
                            <input type="number" name="preferred_age_max" value="{{ old('preferred_age_max', 35) }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all text-sm"
                                   placeholder="Max" min="13" max="100">
                        </div>
                    </div>
                    
                    <!-- Terms & Conditions -->
                    <div class="mt-6 bg-gray-50 rounded-xl p-4">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="terms" required class="w-5 h-5 text-rose-500 border-gray-300 rounded mt-0.5 focus:ring-rose-500 focus:ring-offset-0 cursor-pointer">
                            <span class="ml-3 text-gray-600 text-sm">
                                I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-rose-600 hover:underline font-medium">Terms of Service</a> and 
                                <a href="{{ route('privacy') }}" target="_blank" class="text-rose-600 hover:underline font-medium">Privacy Policy</a>. 
                                I confirm that I am at least 13 years old and all information provided is accurate.
                            </span>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit" id="submitBtn"
                                class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                            <i class="fas fa-heart mr-2"></i>
                            Create My Account & Find Love
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Login Link -->
            <div class="px-6 pb-6 text-center border-t border-gray-100 pt-6">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-rose-600 font-semibold hover:underline">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
let stream = null;
let currentStep = 1;

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function goToStep(step) {
    // Validation before moving forward
    if (step > currentStep) {
        if (!validateStep(currentStep)) {
            return;
        }
    }
    
    // Hide all steps
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step3').classList.add('hidden');
    
    // Show target step
    document.getElementById('step' + step).classList.remove('hidden');
    
    // Update progress indicators
    updateProgressIndicators(step);
    
    // Stop camera if leaving step 2
    if (currentStep === 2 && step !== 2 && stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep(step) {
    if (step === 1) {
        const requiredFields = ['full_name', 'email', 'whatsapp_number', 'password', 'password_confirmation'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields');
            return false;
        }
        
        // Password match validation
        const password = document.querySelector('[name="password"]').value;
        const confirmPassword = document.querySelector('[name="password_confirmation"]').value;
        
        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return false;
        }
        
        if (password.length < 6) {
            alert('Password must be at least 6 characters');
            return false;
        }
        
        // WhatsApp validation
        const whatsapp = document.querySelector('[name="whatsapp_number"]').value;
        if (whatsapp.length !== 10 || !/^\d+$/.test(whatsapp)) {
            alert('Please enter a valid 10-digit WhatsApp number');
            return false;
        }
        
        return true;
    }
    
    if (step === 2) {
        const requiredFields = ['gender', 'dob', 'location', 'bio'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        // Check if live photo is captured
        const livePhoto = document.getElementById('livePhotoInput').value;
        if (!livePhoto) {
            alert('Please capture a live verification photo');
            return false;
        }
        
        // Check if at least one quality is selected
        const selectedQualities = document.querySelectorAll('#yourQualities input[type="checkbox"]:checked');
        if (selectedQualities.length === 0) {
            alert('Please select at least one quality that describes you');
            return false;
        }
        
        if (!isValid) {
            alert('Please fill in all required fields');
            return false;
        }
        
        return true;
    }
    
    return true;
}

function updateProgressIndicators(step) {
    // Reset all indicators
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById(`step${i}-indicator`);
        const text = document.getElementById(`step${i}-text`);
        
        if (i < step) {
            // Completed steps
            indicator.className = 'w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-semibold shadow-sm';
            indicator.innerHTML = '<i class="fas fa-check text-sm"></i>';
            if (text) {
                text.classList.remove('text-gray-400');
                text.classList.add('text-gray-900');
            }
        } else if (i === step) {
            // Current step
            indicator.className = 'w-10 h-10 bg-rose-500 rounded-full flex items-center justify-center text-white font-semibold shadow-sm';
            if (i === 1) indicator.innerHTML = '<i class="fas fa-user text-sm"></i>';
            if (i === 2) indicator.innerHTML = '<i class="fas fa-id-card text-sm"></i>';
            if (i === 3) indicator.innerHTML = '<i class="fas fa-heart text-sm"></i>';
            if (text) {
                text.classList.remove('text-gray-400');
                text.classList.add('text-gray-900');
            }
        } else {
            // Future steps
            indicator.className = 'w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 font-semibold transition-all duration-300';
            if (i === 1) indicator.innerHTML = '<i class="fas fa-user text-sm"></i>';
            if (i === 2) indicator.innerHTML = '<i class="fas fa-id-card text-sm"></i>';
            if (i === 3) indicator.innerHTML = '<i class="fas fa-heart text-sm"></i>';
            if (text) {
                text.classList.add('text-gray-400');
                text.classList.remove('text-gray-900');
            }
        }
    }
    
    // Update progress bars
    document.getElementById('progress-bar-1').style.width = step > 1 ? '100%' : '0%';
    document.getElementById('progress-bar-2').style.width = step > 2 ? '100%' : '0%';
}

function previewGallery(input) {
    const preview = document.getElementById('galleryPreview');
    const placeholder = document.getElementById('galleryPlaceholder');
    
    if (input.files && input.files.length > 0) {
        if (input.files.length > 5) {
            alert('You can upload maximum 5 photos');
            input.value = '';
            return;
        }
        
        preview.innerHTML = '<div class="grid grid-cols-3 gap-2 p-2 w-full h-full overflow-auto">';
        let gridHtml = '';
        
        for (let i = 0; i < Math.min(input.files.length, 5); i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-16 object-cover rounded-lg';
                preview.querySelector('.grid').appendChild(img);
            }
            reader.readAsDataURL(input.files[i]);
        }
        
        preview.innerHTML += '</div>';
    }
}

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } } 
        });
        
        const video = document.getElementById('video');
        const placeholder = document.getElementById('cameraPlaceholder');
        
        video.srcObject = stream;
        video.classList.remove('hidden');
        placeholder.classList.add('hidden');
        video.play();
        
        document.getElementById('startCameraBtn').classList.add('hidden');
        document.getElementById('captureBtn').classList.remove('hidden');
    } catch (err) {
        alert('Unable to access camera. Please ensure camera permissions are granted.');
        console.error('Camera error:', err);
    }
}

function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('livePhotoPreview');
    const input = document.getElementById('livePhotoInput');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    
    const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
    input.value = dataUrl;
    
    preview.src = dataUrl;
    preview.classList.remove('hidden');
    video.classList.add('hidden');
    
    // Stop camera
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    document.getElementById('captureBtn').classList.add('hidden');
    document.getElementById('retakeBtn').classList.remove('hidden');
}

function retakePhoto() {
    const preview = document.getElementById('livePhotoPreview');
    const input = document.getElementById('livePhotoInput');
    const placeholder = document.getElementById('cameraPlaceholder');
    
    preview.classList.add('hidden');
    preview.src = '';
    input.value = '';
    placeholder.classList.remove('hidden');
    
    document.getElementById('retakeBtn').classList.add('hidden');
    document.getElementById('startCameraBtn').classList.remove('hidden');
}

// Form submission validation
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    // Check expected qualities
    const selectedExpectedQualities = document.querySelectorAll('#expectedQualities input[type="checkbox"]:checked');
    if (selectedExpectedQualities.length === 0) {
        e.preventDefault();
        alert('Please select at least one quality you are looking for in a partner');
        return false;
    }
    
    // Check expectation text
    const expectation = document.querySelector('[name="expectation"]').value.trim();
    if (!expectation) {
        e.preventDefault();
        alert('Please describe what you are looking for in a partner');
        return false;
    }
    
    // Check terms
    const terms = document.querySelector('[name="terms"]');
    if (!terms.checked) {
        e.preventDefault();
        alert('Please accept the Terms of Service and Privacy Policy');
        return false;
    }
});

// Custom Expected Qualities functionality
let customExpectedQualities = [];

function addCustomExpectedQuality() {
    const input = document.getElementById('customExpectedQuality');
    const quality = input.value.trim();
    
    if (!quality) {
        alert('Please enter a quality');
        return;
    }
    
    if (quality.length > 30) {
        alert('Quality must be 30 characters or less');
        return;
    }
    
    if (customExpectedQualities.includes(quality.toLowerCase())) {
        alert('This quality has already been added');
        return;
    }
    
    customExpectedQualities.push(quality.toLowerCase());
    
    const container = document.getElementById('customExpectedQualitiesContainer');
    const tag = document.createElement('div');
    tag.className = 'inline-flex items-center px-3 py-1.5 bg-pink-50 border border-pink-500 rounded-lg text-pink-700 font-medium text-sm';
    tag.innerHTML = `
        <input type="hidden" name="expected_keywords[]" value="${quality}">
        <span>${quality}</span>
        <button type="button" onclick="removeCustomExpectedQuality(this, '${quality.toLowerCase()}')" class="ml-2 text-pink-500 hover:text-pink-700">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(tag);
    
    input.value = '';
}

function removeCustomExpectedQuality(btn, quality) {
    customExpectedQualities = customExpectedQualities.filter(q => q !== quality);
    btn.parentElement.remove();
}

// Custom User Qualities functionality
let customUserQualities = [];

function addCustomQuality() {
    const input = document.getElementById('customQualityInput');
    const quality = input.value.trim();
    
    if (!quality) {
        alert('Please enter a quality');
        return;
    }
    
    if (quality.length > 30) {
        alert('Quality must be 30 characters or less');
        return;
    }
    
    if (customUserQualities.includes(quality.toLowerCase())) {
        alert('This quality has already been added');
        return;
    }
    
    customUserQualities.push(quality.toLowerCase());
    
    const container = document.getElementById('customQualitiesContainer');
    const tag = document.createElement('div');
    tag.className = 'inline-flex items-center px-3 py-1.5 bg-rose-50 border border-rose-500 rounded-lg text-rose-700 font-medium text-sm';
    tag.innerHTML = `
        <input type="hidden" name="keywords[]" value="${quality}">
        <span>${quality}</span>
        <button type="button" onclick="removeCustomQuality(this, '${quality.toLowerCase()}')" class="ml-2 text-rose-500 hover:text-rose-700">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(tag);
    
    input.value = '';
}

function removeCustomQuality(btn, quality) {
    customUserQualities = customUserQualities.filter(q => q !== quality);
    btn.parentElement.remove();
}

// Allow Enter key to add custom quality
document.getElementById('customQualityInput')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addCustomQuality();
    }
});
</script>
@endsection