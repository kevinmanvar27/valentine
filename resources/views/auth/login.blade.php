@extends('layouts.app')

@section('title', 'Login - Valentine Partner Finder')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-gradient-to-br from-valentine-200 via-pink-200 to-purple-200">
    <!-- Animated Background -->
    <div class="absolute inset-0 gradient-bg-animated opacity-30"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-valentine-400 rounded-full blur-3xl opacity-40 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-400 rounded-full blur-3xl opacity-40 animate-float-slow"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-purple-400 rounded-full blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/3 right-1/3 w-48 h-48 bg-yellow-300 rounded-full blur-3xl opacity-30 animate-float" style="animation-delay: 3s;"></div>
        
        <!-- Floating Hearts -->
        <div class="absolute top-32 right-20 text-5xl animate-float opacity-40">💕</div>
        <div class="absolute bottom-32 left-20 text-4xl animate-float-slow opacity-40">💗</div>
        <div class="absolute top-1/3 left-1/3 text-3xl animate-float opacity-30" style="animation-delay: 1s;">💖</div>
        <div class="absolute bottom-1/4 right-1/4 text-4xl animate-float-slow opacity-35" style="animation-delay: 2s;">❤️</div>
    </div>
    
    <div class="relative w-full max-w-md">
        <!-- Login Card -->
        <div class="animated-border">
            <div class="bg-gradient-to-br from-white to-valentine-50 rounded-3xl shadow-2xl overflow-hidden border-2 border-valentine-200">
                <!-- Header -->
                <div class="gradient-bg-animated px-8 py-10 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl mb-4 shadow-lg">
                            <i class="fas fa-heart text-white text-3xl animate-heartbeat"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2">Welcome Back!</h1>
                        <p class="text-white/80">Sign in to find your Valentine</p>
                    </div>
                </div>
                
                <!-- Form -->
                <div class="p-8">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 animate-fade-in">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                                <span class="font-medium">{{ $errors->first() }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-valentine-500 mr-2"></i>Email Address
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-valentine-500 focus:bg-white transition-all duration-300 input-animated pl-12"
                                       placeholder="Enter your email"
                                       required>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-valentine-500 transition-colors">
                                    <i class="fas fa-at"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-valentine-500 mr-2"></i>Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password"
                                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-valentine-500 focus:bg-white transition-all duration-300 input-animated pl-12 pr-12"
                                       placeholder="Enter your password"
                                       required>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-valentine-500 transition-colors">
                                    <i class="fas fa-key"></i>
                                </div>
                                <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-valentine-500 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="remember" class="w-5 h-5 text-valentine-500 border-2 border-gray-300 rounded focus:ring-valentine-500 focus:ring-offset-0 cursor-pointer">
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                            </label>
                            <a href="#" class="text-sm text-valentine-600 hover:text-valentine-700 font-medium hover:underline transition-colors">
                                Forgot password?
                            </a>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-lg flex items-center justify-center group">
                            <i class="fas fa-sign-in-alt mr-3 group-hover:translate-x-1 transition-transform"></i>
                            Sign In
                        </button>
                    </form>
                    
                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">New to Valentine Finder?</span>
                        </div>
                    </div>
                    
                    <!-- Register Link -->
                    <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-gray-50 to-pink-50 border-2 border-valentine-200 text-valentine-600 py-4 rounded-xl font-bold text-lg flex items-center justify-center hover:border-valentine-400 hover:bg-valentine-50 transition-all duration-300 group">
                        <i class="fas fa-heart mr-3 group-hover:animate-heartbeat"></i>
                        Create an Account
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Text -->
        <p class="text-center text-gray-500 text-sm mt-8">
            By signing in, you agree to our 
            <a href="#" class="text-valentine-600 hover:underline">Terms of Service</a> and 
            <a href="#" class="text-valentine-600 hover:underline">Privacy Policy</a>
        </p>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection