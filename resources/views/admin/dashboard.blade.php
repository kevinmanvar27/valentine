@extends('layouts.admin')

@section('title', 'Admin Dashboard - Valentine Partner Finder')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of Valentine Partner Finder')

@section('content')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    .animate-countUp {
        animation: countUp 0.5s ease-out forwards;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .progress-bar {
        background: linear-gradient(90deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        background-size: 200% 100%;
        animation: shimmer 2s linear infinite;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 flex items-center">
                <span class="bg-gradient-to-r from-valentine-500 to-pink-500 bg-clip-text text-transparent">
                    Admin Dashboard
                </span>
                <span class="ml-3 text-2xl animate-float">💕</span>
            </h1>
            <p class="text-gray-500 mt-1">Here's what's happening with your platform today</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <span class="text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <!-- Total Users -->
        <div class="stat-card bg-gradient-to-br from-white to-valentine-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-valentine-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-valentine-400 to-rose-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">Total</span>
            </div>
            <div class="animate-countUp">
                <div class="text-3xl font-extrabold text-gray-800">{{ number_format($totalUsers) }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Users</div>
            </div>
        </div>
        
        <!-- Pending Verifications -->
        <div class="stat-card bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-amber-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-clock text-white text-lg"></i>
                </div>
                @if($pendingVerifications > 0)
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                @endif
            </div>
            <div class="animate-countUp" style="animation-delay: 0.1s;">
                <div class="text-3xl font-extrabold text-gray-800">{{ $pendingVerifications }}</div>
                <div class="text-sm text-gray-500 mt-1">Pending Verify</div>
            </div>
        </div>
        
        <!-- Active Users -->
        <div class="stat-card bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-emerald-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-user-check text-white text-lg"></i>
                </div>
                <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full font-medium">Active</span>
            </div>
            <div class="animate-countUp" style="animation-delay: 0.2s;">
                <div class="text-3xl font-extrabold text-gray-800">{{ number_format($activeUsers) }}</div>
                <div class="text-sm text-gray-500 mt-1">Active Users</div>
            </div>
        </div>
        
        <!-- Total Matches -->
        <div class="stat-card bg-gradient-to-br from-white to-pink-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-pink-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-pink-400 to-rose-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-heart text-white text-lg"></i>
                </div>
            </div>
            <div class="animate-countUp" style="animation-delay: 0.3s;">
                <div class="text-3xl font-extrabold text-gray-800">{{ number_format($totalMatches) }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Matches</div>
            </div>
        </div>
        
        <!-- Couples -->
        <div class="stat-card bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-purple-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-violet-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-heart-circle-check text-white text-lg"></i>
                </div>
                <span class="text-xs text-violet-600 bg-violet-50 px-2 py-1 rounded-full font-medium">💕</span>
            </div>
            <div class="animate-countUp" style="animation-delay: 0.4s;">
                <div class="text-3xl font-extrabold text-gray-800">{{ number_format($totalCouples) }}</div>
                <div class="text-sm text-gray-500 mt-1">Couples</div>
            </div>
        </div>
        
        <!-- Pending Payments -->
        <div class="stat-card bg-gradient-to-br from-white to-orange-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-5 border-2 border-orange-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="stat-icon w-12 h-12 bg-gradient-to-br from-orange-400 to-amber-500 rounded-xl flex items-center justify-center shadow-lg transition-transform duration-300">
                    <i class="fas fa-credit-card text-white text-lg"></i>
                </div>
                @if($pendingPayments > 0)
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
                    </span>
                @endif
            </div>
            <div class="animate-countUp" style="animation-delay: 0.5s;">
                <div class="text-3xl font-extrabold text-gray-800">{{ $pendingPayments }}</div>
                <div class="text-sm text-gray-500 mt-1">Pending Pay</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.verifications') }}" class="group relative bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <i class="fas fa-user-clock text-2xl mb-2 opacity-80"></i>
                    <p class="font-bold text-lg">Verify Registrations</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl font-bold text-xl">
                    {{ $pendingVerifications }}
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.matchmaking') }}" class="group relative bg-gradient-to-r from-valentine-500 to-pink-500 text-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <i class="fas fa-wand-magic-sparkles text-2xl mb-2 opacity-80"></i>
                    <p class="font-bold text-lg">Matchmaking</p>
                </div>
                <i class="fas fa-arrow-right text-xl opacity-70 group-hover:translate-x-2 transition-transform"></i>
            </div>
        </a>
        
        <a href="{{ route('admin.payments') }}" class="group relative bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <i class="fas fa-money-check text-2xl mb-2 opacity-80"></i>
                    <p class="font-bold text-lg">Verify Payments</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl font-bold text-xl">
                    {{ $pendingPayments }}
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.settings') }}" class="group relative bg-gradient-to-r from-slate-600 to-gray-700 text-white rounded-2xl p-5 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <i class="fas fa-cog text-2xl mb-2 opacity-80"></i>
                    <p class="font-bold text-lg">Settings</p>
                </div>
                <i class="fas fa-arrow-right text-xl opacity-70 group-hover:translate-x-2 transition-transform"></i>
            </div>
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Users by Gender -->
        <div class="bg-gradient-to-br from-white to-valentine-50 rounded-2xl shadow-lg p-6 border-2 border-valentine-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-xl flex items-center justify-center mr-3 shadow">
                    <i class="fas fa-venus-mars text-white"></i>
                </div>
                Users by Gender
            </h2>
            <div class="flex items-center justify-center gap-8">
                @foreach($usersByGender as $gender)
                    <div class="text-center group">
                        <div class="relative">
                            <div class="w-28 h-28 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl
                                @if($gender->gender === 'male') bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600
                                @elseif($gender->gender === 'female') bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600
                                @else bg-gradient-to-br from-violet-100 to-purple-100 text-purple-600 @endif">
                                <div>
                                    <div class="text-3xl font-extrabold">{{ $gender->count }}</div>
                                    <i class="fas @if($gender->gender === 'male') fa-mars @elseif($gender->gender === 'female') fa-venus @else fa-genderless @endif text-xl mt-1"></i>
                                </div>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-lg flex items-center justify-center shadow-lg
                                @if($gender->gender === 'male') bg-blue-500
                                @elseif($gender->gender === 'female') bg-pink-500
                                @else bg-purple-500 @endif">
                                <i class="fas @if($gender->gender === 'male') fa-mars @elseif($gender->gender === 'female') fa-venus @else fa-genderless @endif text-white text-sm"></i>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-700">{{ ucfirst($gender->gender) }}</p>
                        <p class="text-xs text-gray-400">{{ $totalUsers > 0 ? round(($gender->count / $totalUsers) * 100) : 0 }}% of total</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg p-6 border-2 border-emerald-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mr-3 shadow">
                    <i class="fas fa-indian-rupee-sign text-white"></i>
                </div>
                Revenue Overview
            </h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-5 border border-emerald-100">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-600 font-medium">Registration</p>
                        <i class="fas fa-user-plus text-emerald-500"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-emerald-600">₹{{ number_format($registrationRevenue) }}</p>
                </div>
                <div class="bg-gradient-to-br from-valentine-50 to-pink-50 rounded-xl p-5 border border-valentine-100">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-600 font-medium">Match Payments</p>
                        <i class="fas fa-heart text-valentine-500"></i>
                    </div>
                    <p class="text-2xl font-extrabold text-valentine-600">₹{{ number_format($totalRevenue) }}</p>
                </div>
            </div>
            <div class="bg-gradient-to-r from-slate-800 to-gray-900 rounded-xl p-5 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-2 left-4 text-white text-4xl">💰</div>
                    <div class="absolute bottom-2 right-4 text-white text-3xl">📈</div>
                </div>
                <p class="text-sm text-gray-400 font-medium relative z-10">Total Revenue</p>
                <p class="text-4xl font-extrabold text-white relative z-10 mt-1">₹{{ number_format($registrationRevenue + $totalRevenue) }}</p>
            </div>
        </div>
    </div>

    <!-- Users by Location -->
    <div class="bg-gradient-to-br from-white to-indigo-50 rounded-2xl shadow-lg p-6 mt-8 border-2 border-indigo-200">
        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-violet-500 rounded-xl flex items-center justify-center mr-3 shadow">
                <i class="fas fa-map-marker-alt text-white"></i>
            </div>
            Users by Location
        </h2>
        @if($usersByLocation->count() > 0)
            <div class="space-y-4">
                @foreach($usersByLocation as $index => $location)
                    <div class="flex items-center group">
                        <div class="w-8 h-8 bg-gradient-to-br from-valentine-400 to-pink-500 rounded-lg flex items-center justify-center text-white text-xs font-bold mr-3 shadow">
                            {{ $index + 1 }}
                        </div>
                        <span class="w-36 text-sm text-gray-700 font-medium truncate">{{ $location->location }}</span>
                        <div class="flex-1 mx-4">
                            <div class="bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="progress-bar h-full rounded-full transition-all duration-500" 
                                    style="width: {{ $totalUsers > 0 ? ($location->count / $totalUsers) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-800 w-16 text-right bg-gray-50 px-3 py-1 rounded-lg">{{ $location->count }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500">No location data available</p>
            </div>
        @endif
    </div>

    <!-- Recent Users -->
    <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl shadow-lg p-6 mt-8 border-2 border-cyan-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center mr-3 shadow">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                Recent Registrations
            </h2>
            <a href="{{ route('admin.users') }}" class="flex items-center text-valentine-600 hover:text-valentine-700 text-sm font-medium group">
                View All
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                        <th class="pb-4 font-semibold">User</th>
                        <th class="pb-4 font-semibold">Gender</th>
                        <th class="pb-4 font-semibold">Location</th>
                        <th class="pb-4 font-semibold">Status</th>
                        <th class="pb-4 font-semibold">Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img src="{{ get_image_url($user->live_image) }}" 
                                            alt="{{ $user->full_name }}"
                                            class="w-11 h-11 rounded-xl object-cover border-2 border-white shadow">
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white
                                            @if($user->status === 'active') bg-green-500
                                            @elseif($user->status === 'matched') bg-valentine-500
                                            @else bg-yellow-500 @endif">
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">{{ $user->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold
                                    @if($user->gender === 'male') bg-blue-100 text-blue-700
                                    @elseif($user->gender === 'female') bg-pink-100 text-pink-700
                                    @else bg-purple-100 text-purple-700 @endif">
                                    <i class="fas @if($user->gender === 'male') fa-mars @elseif($user->gender === 'female') fa-venus @else fa-genderless @endif mr-1"></i>
                                    {{ ucfirst($user->gender) }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt text-valentine-400 mr-2"></i>
                                    {{ $user->location }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold
                                    @if($user->status === 'active') bg-emerald-100 text-emerald-700
                                    @elseif($user->status === 'matched') bg-valentine-100 text-valentine-700
                                    @else bg-amber-100 text-amber-700 @endif">
                                    @if($user->status === 'active')
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @elseif($user->status === 'matched')
                                        <i class="fas fa-heart mr-1"></i>
                                    @else
                                        <i class="fas fa-clock mr-1"></i>
                                    @endif
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
