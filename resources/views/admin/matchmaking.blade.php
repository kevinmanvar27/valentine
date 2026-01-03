@extends('layouts.admin')

@section('title', 'Matchmaking - Admin - Valentine Partner Finder')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold">
            <span class="gradient-text">
                <i class="fas fa-magic mr-2"></i> Matchmaking
            </span>
        </h1>
        <p class="text-gray-400 mt-2">Select a user and share compatible profiles with them</p>
    </div>

    <!-- Flash Messages Container (for AJAX responses) -->
    <div id="flash-messages"></div>

    <!-- Step 1: Select User -->
    <div class="glass-card rounded-2xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.05s;">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                <span class="text-white text-sm font-bold">1</span>
            </div>
            <h2 class="font-semibold text-gray-800">Select User</h2>
        </div>
        
        <form action="{{ route('admin.matchmaking') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <select name="user_id" class="input-modern w-full" onchange="this.form.submit()">
                    <option value="">-- Select a User --</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->full_name }} ({{ ucfirst($user->gender) }}, {{ $user->age }}y - {{ $user->location }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if($selectedUser)
        <!-- Step 2: Selected User Details + Shared Profiles -->
        <div class="grid lg:grid-cols-3 gap-6 mb-8">
            <!-- User Details Card -->
            <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <h2 class="font-semibold text-gray-800">User Details</h2>
                </div>
                
                <div class="text-center mb-4">
                    @if($selectedUser->gallery_images && count($selectedUser->gallery_images) > 0)
                        <img src="{{ Storage::url($selectedUser->gallery_images[0]) }}" 
                            alt="{{ $selectedUser->full_name }}"
                            class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-white shadow-lg">
                    @elseif($selectedUser->live_image)
                        <img src="{{ Storage::url($selectedUser->live_image) }}" 
                            alt="{{ $selectedUser->full_name }}"
                            class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-white shadow-lg">
                    @else
                        <div class="w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-rose-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="font-bold text-xl text-gray-800 mt-3">{{ $selectedUser->full_name }}</h3>
                    <p class="text-gray-500">{{ $selectedUser->age }} years old</p>
                </div>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500"><i class="fas fa-venus-mars mr-2"></i>Gender</span>
                        <span class="font-medium px-2 py-1 rounded-full text-xs
                            @if($selectedUser->gender === 'male') bg-blue-100 text-blue-700
                            @elseif($selectedUser->gender === 'female') bg-pink-100 text-pink-700
                            @else bg-purple-100 text-purple-700 @endif">
                            {{ ucfirst($selectedUser->gender) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500"><i class="fas fa-map-marker-alt mr-2"></i>Location</span>
                        <span class="font-medium text-gray-800">{{ $selectedUser->location }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500"><i class="fas fa-inbox mr-2"></i>Slots Used</span>
                        <span class="font-medium">
                            @php $pendingCount = $sharedProfiles->where('status', 'pending')->count(); @endphp
                            <span id="slots-counter" class="{{ $pendingCount >= 5 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $pendingCount }}/5
                            </span>
                        </span>
                    </div>
                </div>
                
                <!-- User's Interests -->
                @if(!empty($selectedUser->keywords))
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-2">Interests:</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($selectedUser->keywords as $kw)
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-full text-xs">{{ $kw }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- User's Expected Keywords -->
                @if(!empty($selectedUser->expected_keywords))
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">Looking for:</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($selectedUser->expected_keywords as $kw)
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-xs">{{ $kw }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Shared Profiles Card -->
            <div class="lg:col-span-2 glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.15s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-share text-white text-sm"></i>
                        </div>
                        <h2 class="font-semibold text-gray-800">Shared Profiles (<span id="shared-count">{{ $sharedProfiles->count() }}</span>)</h2>
                    </div>
                </div>
                
                <div id="shared-profiles-list">
                    @if($sharedProfiles->isEmpty())
                        <div class="text-center py-8" id="no-shared-profiles">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No profiles shared yet</p>
                        </div>
                    @else
                        <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar pr-2" id="shared-profiles-container">
                            @foreach($sharedProfiles as $suggestion)
                                @if($suggestion->suggestedUser)
                                    <div class="flex items-center p-3 rounded-xl border suggestion-item" 
                                        data-suggestion-id="{{ $suggestion->id }}"
                                        @if($suggestion->status === 'accepted') style="background-color: #f0fdf4; border-color: #bbf7d0;"
                                        @elseif($suggestion->status === 'rejected') style="background-color: #fef2f2; border-color: #fecaca;"
                                        @else style="background-color: #f9fafb; border-color: #e5e7eb;" @endif>
                                        @if($suggestion->suggestedUser->gallery_images && count($suggestion->suggestedUser->gallery_images) > 0)
                                            <img src="{{ Storage::url($suggestion->suggestedUser->gallery_images[0]) }}" 
                                                alt="{{ $suggestion->suggestedUser->full_name }}"
                                                class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white shadow">
                                        @elseif($suggestion->suggestedUser->live_image)
                                            <img src="{{ Storage::url($suggestion->suggestedUser->live_image) }}" 
                                                alt="{{ $suggestion->suggestedUser->full_name }}"
                                                class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white shadow">
                                        @else
                                            <div class="w-12 h-12 rounded-full mr-3 border-2 border-white shadow bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-rose-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-800 truncate">{{ $suggestion->suggestedUser->full_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $suggestion->suggestedUser->age }}y • {{ $suggestion->suggestedUser->location }}
                                            </p>
                                        </div>
                                        <div class="text-right ml-2 flex items-center gap-2">
                                            <div>
                                                @if($suggestion->status === 'accepted')
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                        <i class="fas fa-heart mr-1"></i>Accepted
                                                    </span>
                                                @elseif($suggestion->status === 'rejected')
                                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                                        <i class="fas fa-times mr-1"></i>Rejected
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                        <i class="fas fa-clock mr-1"></i>Pending
                                                    </span>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-1">{{ $suggestion->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if($suggestion->status === 'pending')
                                                <button type="button" 
                                                    class="revoke-suggestion-btn w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center"
                                                    data-suggestion-id="{{ $suggestion->id }}"
                                                    title="Revoke this suggestion">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Step 3: Filter & Find Matches -->
        <div class="glass-card rounded-2xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white text-sm font-bold">2</span>
                </div>
                <h2 class="font-semibold text-gray-800">Filter Potential Matches</h2>
            </div>
            
            <form action="{{ route('admin.matchmaking') }}" method="GET" id="filter-form">
                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Location</label>
                        <select name="filter_location" class="input-modern w-full">
                            <option value="">All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ request('filter_location') == $loc ? 'selected' : '' }}>
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Showing Gender</label>
                        <input type="text" class="input-modern w-full bg-gray-100" 
                            value="{{ $selectedUser->gender === 'male' ? 'Female' : ($selectedUser->gender === 'female' ? 'Male' : 'All') }}" 
                            disabled>
                    </div>
                </div>
                
                <!-- Keywords Select2 Style -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Keywords (Click to select/deselect)</label>
                    
                    @php
                        $selectedKeywords = request('filter_keywords', []);
                        if (!is_array($selectedKeywords)) {
                            $selectedKeywords = [$selectedKeywords];
                        }
                        $selectedKeywords = array_filter($selectedKeywords);
                        $unselectedKeywords = array_diff($keywords, $selectedKeywords);
                    @endphp
                    
                    <!-- Selected Keywords (Top) -->
                    <div id="selected-keywords-container" class="min-h-[44px] p-3 border-2 border-rose-200 rounded-xl bg-rose-50/50 mb-2 {{ empty($selectedKeywords) ? 'hidden' : '' }}">
                        <p class="text-xs text-rose-500 mb-2 font-medium"><i class="fas fa-check-circle mr-1"></i>Selected:</p>
                        <div id="selected-keywords" class="flex flex-wrap gap-2">
                            @foreach($selectedKeywords as $kw)
                                <span class="keyword-tag selected px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md hover:shadow-lg transition-all"
                                      data-keyword="{{ $kw }}">
                                    {{ $kw }}
                                    <i class="fas fa-times ml-1 text-xs"></i>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Available Keywords (Bottom) -->
                    <div class="p-3 border-2 border-gray-200 rounded-xl bg-white">
                        <p class="text-xs text-gray-400 mb-2 font-medium"><i class="fas fa-tags mr-1"></i>Available:</p>
                        <div id="available-keywords" class="flex flex-wrap gap-2">
                            @foreach($unselectedKeywords as $kw)
                                <span class="keyword-tag available px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all"
                                      data-keyword="{{ $kw }}">
                                    {{ $kw }}
                                    <i class="fas fa-plus ml-1 text-xs"></i>
                                </span>
                            @endforeach
                        </div>
                        @if(empty($unselectedKeywords))
                            <p id="no-available-msg" class="text-gray-400 text-sm">All keywords selected</p>
                        @else
                            <p id="no-available-msg" class="text-gray-400 text-sm hidden">All keywords selected</p>
                        @endif
                    </div>
                    
                    <!-- Hidden inputs for form submission -->
                    <div id="keyword-inputs">
                        @foreach($selectedKeywords as $kw)
                            <input type="hidden" name="filter_keywords[]" value="{{ $kw }}">
                        @endforeach
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="btn-gradient px-6 py-3 rounded-xl font-semibold">
                        <i class="fas fa-search mr-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.matchmaking', ['user_id' => $selectedUser->id]) }}" 
                       class="px-6 py-3 rounded-xl font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                        <i class="fas fa-undo mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Step 4: Potential Matches Grid -->
        <div class="animate-fade-in-up" style="animation-delay: 0.25s;">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white text-sm font-bold">3</span>
                </div>
                <h2 class="font-semibold text-gray-800">Potential Matches ({{ $potentialMatches->count() }})</h2>
                
                @php $canShare = $sharedProfiles->where('status', 'pending')->count() < 5; @endphp
                <span id="slots-warning" class="ml-auto px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium {{ $canShare ? 'hidden' : '' }}">
                    <i class="fas fa-exclamation-circle mr-1"></i> Max 5 pending profiles reached
                </span>
            </div>
            
            @if($potentialMatches->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                        <i class="fas fa-search text-rose-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Matches Found</h3>
                    <p class="text-gray-500">Try adjusting the filters to find more profiles</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($potentialMatches as $index => $match)
                        @php
                            // Check if this profile is already shared with selected user
                            $alreadyShared = $sharedProfiles->where('suggested_user_id', $match->id)->first();
                        @endphp
                        <div class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 match-card"
                             data-match-id="{{ $match->id }}"
                             style="animation: fadeInUp 0.5s ease-out forwards; animation-delay: {{ 0.05 * ($index % 8) }}s; opacity: 0;">
                            
                            <!-- User Image -->
                            <div class="relative group">
                                @if($match->gallery_images && count($match->gallery_images) > 0)
                                    <img src="{{ Storage::url($match->gallery_images[0]) }}" 
                                        alt="{{ $match->full_name }}"
                                        class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                                @elseif($match->live_image)
                                    <img src="{{ Storage::url($match->live_image) }}" 
                                        alt="{{ $match->full_name }}"
                                        class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-rose-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <!-- Gender Badge -->
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                                        @if($match->gender === 'male') bg-blue-500/80 text-white
                                        @elseif($match->gender === 'female') bg-pink-500/80 text-white
                                        @else bg-purple-500/80 text-white @endif">
                                        <i class="fas fa-{{ $match->gender === 'male' ? 'mars' : 'venus' }} mr-1"></i>
                                        {{ ucfirst($match->gender) }}
                                    </span>
                                </div>
                                
                                <!-- Already Shared Badge -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1">
                                    @if($alreadyShared)
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-500/90 text-white">
                                            <i class="fas fa-check mr-1"></i>Shared
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Name Overlay -->
                                <div class="absolute bottom-3 left-3 right-3">
                                    <h3 class="font-bold text-white text-lg">{{ $match->full_name }}</h3>
                                    <p class="text-white/80 text-sm">{{ $match->age }} years old</p>
                                </div>
                            </div>
                            
                            <!-- User Info -->
                            <div class="p-4">
                                <p class="text-sm text-gray-500 mb-3">
                                    <i class="fas fa-map-marker-alt text-rose-400 mr-1"></i> {{ $match->location }}
                                </p>
                                
                                <!-- Keywords -->
                                @if(!empty($match->keywords))
                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach(array_slice($match->keywords, 0, 3) as $keyword)
                                            <span class="px-2 py-1 bg-gradient-to-r from-rose-50 to-pink-50 text-rose-600 rounded-full text-xs font-medium border border-rose-100">
                                                {{ $keyword }}
                                            </span>
                                        @endforeach
                                        @if(count($match->keywords) > 3)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-xs">
                                                +{{ count($match->keywords) - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Share Button -->
                                <button type="button" 
                                    class="share-profile-btn w-full btn-gradient py-2.5 rounded-xl font-semibold text-sm {{ !$canShare ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    data-user-id="{{ $selectedUser->id }}"
                                    data-suggested-user-id="{{ $match->id }}"
                                    data-match-name="{{ $match->full_name }}"
                                    {{ !$canShare ? 'disabled' : '' }}>
                                    <i class="fas fa-paper-plane mr-2"></i> 
                                    <span class="btn-text">{{ $alreadyShared ? 'Share Again' : 'Share Profile' }}</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- No User Selected State -->
        <div class="glass-card rounded-2xl p-12 text-center animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                <i class="fas fa-user-plus text-rose-400 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Select a User to Start</h2>
            <p class="text-gray-500 mb-6">Choose a user from the dropdown above to view their details and share profiles with them</p>
        </div>
    @endif
</div>

<style>
    [x-cloak] { display: none !important; }
    
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
    
    .btn-gradient:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px -10px rgba(244, 63, 94, 0.5);
    }
    
    .btn-gradient:disabled {
        background: #d1d5db;
        cursor: not-allowed;
    }
    
    .btn-gradient.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .input-modern {
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        background: white;
        transition: all 0.3s ease;
    }
    
    .input-modern:focus {
        outline: none;
        border-color: #f43f5e;
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #f43f5e, #ec4899);
        border-radius: 3px;
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
    
    /* Keyword tag animations */
    .keyword-tag {
        transition: all 0.2s ease;
    }
    
    .keyword-tag:hover {
        transform: scale(1.05);
    }
    
    .keyword-tag.selected:hover {
        box-shadow: 0 4px 15px rgba(244, 63, 94, 0.4);
    }
    
    /* Flash message animations */
    .flash-message {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedContainer = document.getElementById('selected-keywords-container');
    const selectedKeywords = document.getElementById('selected-keywords');
    const availableKeywords = document.getElementById('available-keywords');
    const keywordInputs = document.getElementById('keyword-inputs');
    const noAvailableMsg = document.getElementById('no-available-msg');
    
    // Function to move keyword from available to selected
    function selectKeyword(tag) {
        const keyword = tag.dataset.keyword;
        
        // Create new selected tag
        const newTag = document.createElement('span');
        newTag.className = 'keyword-tag selected px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md hover:shadow-lg transition-all';
        newTag.dataset.keyword = keyword;
        newTag.innerHTML = `${keyword} <i class="fas fa-times ml-1 text-xs"></i>`;
        newTag.addEventListener('click', function() {
            deselectKeyword(this);
        });
        
        // Add to selected
        selectedKeywords.appendChild(newTag);
        selectedContainer.classList.remove('hidden');
        
        // Add hidden input
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'filter_keywords[]';
        input.value = keyword;
        input.dataset.keyword = keyword;
        keywordInputs.appendChild(input);
        
        // Remove from available
        tag.remove();
        
        // Check if no more available
        if (availableKeywords.children.length === 0) {
            noAvailableMsg.classList.remove('hidden');
        }
    }
    
    // Function to move keyword from selected to available
    function deselectKeyword(tag) {
        const keyword = tag.dataset.keyword;
        
        // Create new available tag
        const newTag = document.createElement('span');
        newTag.className = 'keyword-tag available px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all';
        newTag.dataset.keyword = keyword;
        newTag.innerHTML = `${keyword} <i class="fas fa-plus ml-1 text-xs"></i>`;
        newTag.addEventListener('click', function() {
            selectKeyword(this);
        });
        
        // Add to available
        availableKeywords.appendChild(newTag);
        noAvailableMsg.classList.add('hidden');
        
        // Remove hidden input
        const input = keywordInputs.querySelector(`input[data-keyword="${keyword}"]`);
        if (input) input.remove();
        
        // Remove from selected
        tag.remove();
        
        // Hide selected container if empty
        if (selectedKeywords.children.length === 0) {
            selectedContainer.classList.add('hidden');
        }
    }
    
    // Add click handlers to available keywords
    document.querySelectorAll('#available-keywords .keyword-tag').forEach(function(tag) {
        tag.addEventListener('click', function() {
            selectKeyword(this);
        });
    });
    
    // Add click handlers to selected keywords
    document.querySelectorAll('#selected-keywords .keyword-tag').forEach(function(tag) {
        tag.addEventListener('click', function() {
            deselectKeyword(this);
        });
    });
    
    // AJAX Share Profile functionality with real-time append
    document.querySelectorAll('.share-profile-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.disabled) return;
            
            const userId = this.dataset.userId;
            const suggestedUserId = this.dataset.suggestedUserId;
            const matchName = this.dataset.matchName;
            const button = this;
            const btnText = button.querySelector('.btn-text');
            const originalText = btnText.textContent;
            
            // Show loading state
            button.classList.add('loading');
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sharing...';
            
            // Make AJAX request
            fetch('{{ route("admin.matchmaking.suggest") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    suggested_user_id: suggestedUserId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                button.classList.remove('loading');
                
                if (data.success) {
                    // Show success message
                    showFlashMessage('success', data.message || 'Profile shared successfully!');
                    
                    // Update button text
                    btnText.textContent = 'Share Again';
                    
                    // Update slots counter
                    if (data.pending_count !== undefined) {
                        const slotsCounter = document.getElementById('slots-counter');
                        const slotsWarning = document.getElementById('slots-warning');
                        
                        slotsCounter.textContent = data.pending_count + '/5';
                        
                        if (data.pending_count >= 5) {
                            slotsCounter.classList.remove('text-green-600');
                            slotsCounter.classList.add('text-red-600');
                            slotsWarning.classList.remove('hidden');
                            
                            // Disable all share buttons
                            document.querySelectorAll('.share-profile-btn').forEach(function(b) {
                                b.disabled = true;
                                b.classList.add('opacity-50', 'cursor-not-allowed');
                            });
                        }
                    }
                    
                    // Real-time append: Add to shared profiles list
                    if (data.suggestion) {
                        console.log('Appending shared profile:', data.suggestion);
                        appendSharedProfile(data.suggestion);
                    } else {
                        console.warn('No suggestion data received from server');
                    }
                    
                    // Add "Shared" badge to the card if not already there
                    const card = button.closest('.match-card');
                    const imageContainer = card.querySelector('.relative.group');
                    const badgeContainer = imageContainer.querySelector('.absolute.top-3.left-3');
                    if (badgeContainer && !badgeContainer.querySelector('.bg-yellow-500\\/90')) {
                        const badge = document.createElement('span');
                        badge.className = 'px-2 py-1 rounded-full text-xs font-semibold bg-yellow-500/90 text-white';
                        badge.innerHTML = '<i class="fas fa-check mr-1"></i>Shared';
                        badgeContainer.appendChild(badge);
                    }
                    
                } else {
                    // Show error message
                    showFlashMessage('error', data.message || 'Failed to share profile.');
                    btnText.textContent = originalText;
                }
            })
            .catch(error => {
                button.classList.remove('loading');
                btnText.textContent = originalText;
                showFlashMessage('error', 'An error occurred. Please try again.');
                console.error('Error sharing profile:', error);
            });
        });
    });
    
    // Function to append shared profile to the list (real-time)
    function appendSharedProfile(suggestion) {
        console.log('appendSharedProfile called with:', suggestion);
        
        const sharedList = document.getElementById('shared-profiles-list');
        const noSharedMsg = document.getElementById('no-shared-profiles');
        const sharedCount = document.getElementById('shared-count');
        
        if (!sharedList) {
            console.error('shared-profiles-list element not found');
            return;
        }
        
        // Hide "no profiles" message if visible
        if (noSharedMsg) {
            console.log('Removing no-shared-profiles message');
            noSharedMsg.remove();
        }
        
        // Get or create container
        let container = document.getElementById('shared-profiles-container');
        if (!container) {
            console.log('Creating new shared-profiles-container');
            // Clear the sharedList first
            sharedList.innerHTML = '';
            
            container = document.createElement('div');
            container.id = 'shared-profiles-container';
            container.className = 'space-y-3 max-h-80 overflow-y-auto custom-scrollbar pr-2';
            sharedList.appendChild(container);
        } else {
            console.log('Using existing shared-profiles-container');
        }
        
        // Create new profile element
        const profileDiv = document.createElement('div');
        profileDiv.className = 'flex items-center p-3 rounded-xl border suggestion-item animate-fade-in-up';
        profileDiv.dataset.suggestionId = suggestion.id;
        profileDiv.style.backgroundColor = '#f9fafb';
        profileDiv.style.borderColor = '#e5e7eb';
        
        const imageUrl = suggestion.suggested_user.live_image 
            ? '/storage/' + suggestion.suggested_user.live_image 
            : '{{ asset("images/default-avatar.png") }}';
        
        profileDiv.innerHTML = `
            <img src="${imageUrl}" 
                alt="${suggestion.suggested_user.full_name}"
                class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white shadow">
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800 truncate">${suggestion.suggested_user.full_name}</p>
                <p class="text-xs text-gray-500">
                    ${suggestion.suggested_user.age}y • ${suggestion.suggested_user.location}
                </p>
            </div>
            <div class="text-right ml-2 flex items-center gap-2">
                <div>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                        <i class="fas fa-clock mr-1"></i>Pending
                    </span>
                    <p class="text-xs text-gray-400 mt-1">${suggestion.created_at}</p>
                </div>
                <button type="button" 
                    class="revoke-suggestion-btn w-8 h-8 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center"
                    data-suggestion-id="${suggestion.id}"
                    title="Revoke this suggestion">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
            </div>
        `;
        
        // Prepend to top of list
        container.insertBefore(profileDiv, container.firstChild);
        console.log('Profile appended to DOM');
        
        // Update count
        const currentCount = parseInt(sharedCount.textContent) || 0;
        sharedCount.textContent = currentCount + 1;
        console.log('Updated count from', currentCount, 'to', currentCount + 1);
        
        // Attach revoke handler to the new button
        const revokeBtn = profileDiv.querySelector('.revoke-suggestion-btn');
        if (revokeBtn) {
            revokeBtn.addEventListener('click', handleRevokeSuggestion);
            console.log('Revoke handler attached');
        }
    }
    
    // AJAX Revoke Suggestion functionality
    function handleRevokeSuggestion(e) {
        e.preventDefault();
        
        const button = this;
        const suggestionId = button.dataset.suggestionId;
        const suggestionItem = button.closest('.suggestion-item');
        
        if (!confirm('Are you sure you want to revoke this profile suggestion?')) {
            return;
        }
        
        // Show loading state
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';
        
        // Make AJAX request
        fetch(`{{ url('admin/matchmaking/revoke') }}/${suggestionId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showFlashMessage('success', data.message || 'Suggestion revoked successfully!');
                
                // Remove the item with animation
                suggestionItem.style.opacity = '0';
                suggestionItem.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    suggestionItem.remove();
                    
                    // Update count
                    const sharedCount = document.getElementById('shared-count');
                    const currentCount = parseInt(sharedCount.textContent) || 0;
                    sharedCount.textContent = Math.max(0, currentCount - 1);
                    
                    // Check if list is empty
                    const container = document.getElementById('shared-profiles-container');
                    if (container && container.children.length === 0) {
                        const sharedList = document.getElementById('shared-profiles-list');
                        sharedList.innerHTML = `
                            <div class="text-center py-8" id="no-shared-profiles">
                                <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No profiles shared yet</p>
                            </div>
                        `;
                    }
                }, 300);
                
                // Update slots counter
                if (data.pending_count !== undefined) {
                    const slotsCounter = document.getElementById('slots-counter');
                    const slotsWarning = document.getElementById('slots-warning');
                    
                    slotsCounter.textContent = data.pending_count + '/5';
                    
                    if (data.pending_count < 5) {
                        slotsCounter.classList.remove('text-red-600');
                        slotsCounter.classList.add('text-green-600');
                        slotsWarning.classList.add('hidden');
                        
                        // Re-enable all share buttons
                        document.querySelectorAll('.share-profile-btn').forEach(function(b) {
                            b.disabled = false;
                            b.classList.remove('opacity-50', 'cursor-not-allowed');
                        });
                    }
                }
            } else {
                // Show error message
                showFlashMessage('error', data.message || 'Failed to revoke suggestion.');
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-trash-alt text-xs"></i>';
            }
        })
        .catch(error => {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-trash-alt text-xs"></i>';
            showFlashMessage('error', 'An error occurred. Please try again.');
            console.error('Error:', error);
        });
    }
    
    // Attach revoke handlers to existing buttons
    document.querySelectorAll('.revoke-suggestion-btn').forEach(function(btn) {
        btn.addEventListener('click', handleRevokeSuggestion);
    });
    
    // Flash message helper function
    function showFlashMessage(type, message) {
        const container = document.getElementById('flash-messages');
        const alertClass = type === 'success' 
            ? 'bg-green-50 border-green-200 text-green-700' 
            : 'bg-red-50 border-red-200 text-red-700';
        const iconClass = type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500';
        
        const alert = document.createElement('div');
        alert.className = `mb-6 p-4 ${alertClass} border rounded-xl flex items-center flash-message`;
        alert.innerHTML = `
            <i class="fas ${iconClass} mr-3"></i>
            <span>${message}</span>
            <button type="button" class="ml-auto text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.innerHTML = '';
        container.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
@endsection