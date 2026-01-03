@extends('layouts.app')

@section('title', 'Login - Valentine Partner Finder')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="relative w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-rose-500 px-8 py-8 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-1 font-serif">Welcome Back!</h1>
                <p class="text-rose-100 text-sm">Sign in to find your Valentine</p>
            </div>
            
            <!-- Form -->
            <div class="p-8">
                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 flex items-center text-sm">
                        <i class="fas fa-exclamation-circle mr-2 text-rose-500"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all pl-11"
                                   placeholder="Enter your email"
                                   required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-100 focus:bg-white transition-all pl-11 pr-11"
                                   placeholder="Enter your password"
                                   required>
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 transition-colors">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-rose-500 border-gray-300 rounded focus:ring-rose-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-rose-500 hover:text-rose-600 font-medium">
                            Forgot password?
                        </a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white py-3.5 rounded-xl font-semibold flex items-center justify-center transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">New to Valentine Finder?</span>
                    </div>
                </div>
                
                <!-- Register Link -->
                <a href="{{ route('register') }}" class="w-full bg-white hover:bg-gray-50 text-rose-500 py-3.5 rounded-xl font-semibold flex items-center justify-center border border-rose-200 transition-colors">
                    <i class="fas fa-heart mr-2"></i>
                    Create an Account
                </a>
            </div>
        </div>
        
        <!-- Bottom Text -->
        <p class="text-center text-gray-500 text-sm mt-6">
            By signing in, you agree to our 
            <a href="#" class="text-rose-500 hover:underline">Terms</a> and 
            <a href="#" class="text-rose-500 hover:underline">Privacy Policy</a>
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