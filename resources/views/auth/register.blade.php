<x-guest-layout>
    <div class="fixed inset-0 w-screen h-screen flex items-center justify-center"
         style="background-image: url('{{ asset('images/background.webp') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
        
        <!-- Dark overlay for readability -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Registration Form Card -->
        <div class="relative z-10 max-w-lg w-full mx-4 md:mx-auto bg-white/70 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-white/20">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-green-700 mb-1">🌿 PlantCare AI</h2>
                <p class="text-gray-600 text-sm">Create your account</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div class="space-y-1">
                    <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" 
                        placeholder="Enter your name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" 
                        placeholder="Enter your email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        placeholder="Create a password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                        placeholder="Confirm your password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Role -->
                <div class="space-y-1">
                    <x-input-label for="role" :value="__('Role')" class="text-sm font-medium text-gray-700" />
                    <select name="role" id="role" required
                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <option value="user">User</option>
                        <option value="gardener">Garedener</option>
                        <option value="admin">Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('login') }}"
                       class="text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-200">
                        Already registered?
                    </a>

                    <x-primary-button class="py-2.5 px-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Matching style to login -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .fixed.inset-0 {
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
        }

        input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }

        button:hover {
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
        }
    </style>
</x-guest-layout>
