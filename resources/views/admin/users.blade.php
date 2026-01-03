@extends('layouts.admin')

@section('title', 'All Users - Admin - Valentine Partner Finder')

@section('content')
<style>
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
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-slide-in {
        animation: slideIn 0.3s ease-out forwards;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .filter-card {
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.03) 0%, rgba(236, 72, 153, 0.03) 100%);
        border: 1px solid rgba(244, 63, 94, 0.1);
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 50%, #f472b6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(244, 63, 94, 0.35);
    }
    
    .input-modern {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }
    
    .input-modern:focus {
        border-color: #f43f5e;
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
    }
    
    .table-row {
        transition: all 0.2s ease;
    }
    
    .table-row:hover {
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.02) 0%, rgba(236, 72, 153, 0.02) 100%);
        transform: scale(1.005);
    }
    
    .user-avatar {
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }
    
    .table-row:hover .user-avatar {
        border-color: #f43f5e;
        transform: scale(1.1);
    }
    
    .keyword-tag {
        transition: all 0.2s ease;
    }
    
    .keyword-tag:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
    }
    
    .status-badge {
        position: relative;
        overflow: hidden;
    }
    
    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 3s infinite;
    }
    
    .action-btn {
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
    }
    
    .stat-mini {
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
        transition: all 0.3s ease;
    }
    
    .stat-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(244, 63, 94, 0.15);
    }
    
    /* Staggered animation delays */
    .table-row:nth-child(1) { animation-delay: 0.05s; }
    .table-row:nth-child(2) { animation-delay: 0.1s; }
    .table-row:nth-child(3) { animation-delay: 0.15s; }
    .table-row:nth-child(4) { animation-delay: 0.2s; }
    .table-row:nth-child(5) { animation-delay: 0.25s; }
    .table-row:nth-child(6) { animation-delay: 0.3s; }
    .table-row:nth-child(7) { animation-delay: 0.35s; }
    .table-row:nth-child(8) { animation-delay: 0.4s; }
    .table-row:nth-child(9) { animation-delay: 0.45s; }
    .table-row:nth-child(10) { animation-delay: 0.5s; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-lg"></i>
                    </span>
                    <span>All <span class="gradient-text">Users</span></span>
                </h1>
                <p class="text-gray-500 mt-2 ml-15">Manage all registered users on the platform</p>
            </div>
            
            <!-- Quick Stats -->
            <div class="flex gap-3">
                <div class="stat-mini px-4 py-2 rounded-xl">
                    <p class="text-xs text-gray-500">Total Users</p>
                    <p class="text-xl font-bold gradient-text">{{ $users->total() }}</p>
                </div>
                <div class="stat-mini px-4 py-2 rounded-xl">
                    <p class="text-xs text-gray-500">This Page</p>
                    <p class="text-xl font-bold text-gray-700">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="glass-card filter-card rounded-2xl shadow-xl p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                <i class="fas fa-filter text-white text-sm"></i>
            </div>
            <h2 class="font-semibold text-gray-700">Filter Users</h2>
        </div>
        
        <form action="{{ route('admin.users') }}" method="GET" class="grid md:grid-cols-5 gap-4">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-600">
                    <i class="fas fa-search text-rose-400 mr-1"></i> Search
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Name, email, phone..."
                    class="input-modern w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none">
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-600">
                    <i class="fas fa-venus-mars text-rose-400 mr-1"></i> Gender
                </label>
                <select name="gender" class="input-modern w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none appearance-none cursor-pointer">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>👨 Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>👩 Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }}>🧑 Other</option>
                </select>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-600">
                    <i class="fas fa-map-marker-alt text-rose-400 mr-1"></i> Location
                </label>
                <select name="location" class="input-modern w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none appearance-none cursor-pointer">
                    <option value="">All Locations</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-600">
                    <i class="fas fa-toggle-on text-rose-400 mr-1"></i> Status
                </label>
                <select name="status" class="input-modern w-full px-4 py-2.5 rounded-xl bg-white focus:outline-none appearance-none cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="matched" {{ request('status') === 'matched' ? 'selected' : '' }}>💕 Matched</option>
                    <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>🚫 Blocked</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-gradient flex-1 text-white py-2.5 rounded-xl font-medium shadow-lg">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                @if(request()->hasAny(['search', 'gender', 'location', 'status']))
                    <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-500 hover:border-rose-300 hover:text-rose-500 transition-all">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
        
        <!-- Active Filters Display -->
        @if(request()->hasAny(['search', 'gender', 'location', 'status']))
            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500">Active filters:</span>
                @if(request('search'))
                    <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-sm flex items-center gap-1">
                        <i class="fas fa-search text-xs"></i> "{{ request('search') }}"
                    </span>
                @endif
                @if(request('gender'))
                    <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm flex items-center gap-1">
                        <i class="fas fa-venus-mars text-xs"></i> {{ ucfirst(request('gender')) }}
                    </span>
                @endif
                @if(request('location'))
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-xs"></i> {{ request('location') }}
                    </span>
                @endif
                @if(request('status'))
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm flex items-center gap-1">
                        <i class="fas fa-toggle-on text-xs"></i> {{ ucfirst(request('status')) }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Users Table -->
    <div class="glass-card rounded-2xl shadow-xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-rose-50 to-pink-50 text-left text-sm text-gray-600">
                        <th class="px-6 py-4 font-semibold">
                            <i class="fas fa-user text-rose-400 mr-2"></i>User
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fas fa-envelope text-rose-400 mr-2"></i>Contact
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fas fa-map-marker-alt text-rose-400 mr-2"></i>Location
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fas fa-tags text-rose-400 mr-2"></i>Keywords
                        </th>
                        <th class="px-6 py-4 font-semibold">
                            <i class="fas fa-info-circle text-rose-400 mr-2"></i>Status
                        </th>
                        <th class="px-6 py-4 font-semibold text-center">
                            <i class="fas fa-cog text-rose-400 mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="table-row animate-slide-in" style="opacity: 0;">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="{{ get_image_url($user->live_image) }}" 
                                            alt="{{ $user->full_name }}"
                                            class="user-avatar w-12 h-12 rounded-full object-cover shadow-md">
                                        <!-- Gender indicator -->
                                        <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-xs
                                            {{ $user->gender === 'male' ? 'bg-blue-500' : ($user->gender === 'female' ? 'bg-pink-500' : 'bg-purple-500') }} text-white shadow-md">
                                            {{ $user->gender === 'male' ? '♂' : ($user->gender === 'female' ? '♀' : '⚧') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 hover:text-rose-600 transition-colors">{{ $user->full_name }}</p>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-birthday-cake text-xs text-rose-300"></i>
                                            {{ $user->age }} years old
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-700 flex items-center gap-2">
                                        <i class="fas fa-envelope text-rose-300 text-xs"></i>
                                        {{ $user->email }}
                                    </p>
                                    <p class="text-sm text-gray-500 flex items-center gap-2">
                                        <i class="fas fa-phone text-rose-300 text-xs"></i>
                                        {{ $user->mobile_number }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt text-rose-400"></i>
                                    {{ $user->location }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(array_slice($user->keywords ?? [], 0, 2) as $keyword)
                                        <span class="keyword-tag bg-gradient-to-r from-rose-100 to-pink-100 text-rose-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                    @if(count($user->keywords ?? []) > 2)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-medium">
                                            +{{ count($user->keywords) - 2 }} more
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                                    @if($user->status === 'active') bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700
                                    @elseif($user->status === 'matched') bg-gradient-to-r from-rose-100 to-pink-100 text-rose-700
                                    @elseif($user->status === 'blocked') bg-gradient-to-r from-red-100 to-rose-100 text-red-700
                                    @else bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700 @endif">
                                    @if($user->status === 'active')
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($user->status === 'matched')
                                        <i class="fas fa-heart"></i>
                                    @elseif($user->status === 'blocked')
                                        <i class="fas fa-ban"></i>
                                    @else
                                        <i class="fas fa-clock"></i>
                                    @endif
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                        class="action-btn inline-flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-rose-500 to-pink-500 text-white rounded-lg text-sm font-medium shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($user->status !== 'active')
                                    <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="action-btn inline-flex items-center gap-1.5 px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition-colors" title="Approve User">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if($user->status !== 'suspended')
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="action-btn inline-flex items-center gap-1.5 px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition-colors" title="Suspend User">
                                            <i class="fas fa-pause"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if($user->status !== 'blocked')
                                    <form action="{{ route('admin.users.block', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="action-btn inline-flex items-center gap-1.5 px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium shadow-md hover:shadow-lg transition-colors" title="Block User">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-3xl text-rose-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No users found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                    @if(request()->hasAny(['search', 'gender', 'location', 'status']))
                                        <a href="{{ route('admin.users') }}" class="mt-4 px-4 py-2 bg-rose-100 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-200 transition-colors">
                                            <i class="fas fa-times mr-1"></i> Clear all filters
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-rose-50/50 to-pink-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-semibold text-gray-700">{{ $users->firstItem() }}</span> 
                        to <span class="font-semibold text-gray-700">{{ $users->lastItem() }}</span> 
                        of <span class="font-semibold text-gray-700">{{ $users->total() }}</span> users
                    </p>
                    <div class="flex items-center gap-2">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Trigger animations when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.table-row');
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '1';
            }, index * 50);
        });
    });
</script>
@endsection
