<x-guest-layout>
    <div class="fixed inset-0 w-screen h-screen flex items-center justify-center" 
         style="background-image: url('{{ asset('images/background.webp') }}'); 
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;">
        
        <!-- Optional overlay for better text readability -->
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        
        <!-- Form container with white background -->
        <div class="relative z-10 max-w-lg w-full mx-auto bg-white/70 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-white/20">

            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Title with better styling -->
            <div class="text-center mb-6">
                
                <h2 class="text-2xl font-bold text-gray-900 mb-1">🌿PlantCare AI</h2>
                <p class="text-gray-600 text-sm">Sign in to your account</p>
            </div>

            <!-- Form with better spacing -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="email" 
                                  class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" 
                                  type="email" 
                                  name="email" 
                                  :value="old('email')" 
                                  required 
                                  autofocus 
                                  autocomplete="username" 
                                  placeholder="Enter your email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="password" 
                                  class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" 
                                  type="password" 
                                  name="password" 
                                  required 
                                  autocomplete="current-password" 
                                  placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" 
                               type="checkbox" 
                               class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 w-4 h-4" 
                               name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-200" 
                           href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="pt-1">
                    <x-primary-button class="w-full justify-center py-2.5 px-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        {{ __('Sign In') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Sign up link -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" 
                       class="text-green-600 hover:text-green-800 font-medium transition-colors duration-200">
                        Create account
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Add custom styles to ensure full coverage -->
    <style>
        /* Ensure the html and body take full height */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        /* Ensure guest layout takes full space */
        .fixed.inset-0 {
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
        }
        
        /* Enhanced input focus effects */
        input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }
        
        /* Button hover effects */
        button:hover {
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
        }
    </style>
</x-guest-layout>