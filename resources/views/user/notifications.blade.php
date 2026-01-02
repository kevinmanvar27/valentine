@extends('layouts.app')
@extends('layouts.app')

@section('title', 'Notifications - Valentine Partner Finder')

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
@endsection
