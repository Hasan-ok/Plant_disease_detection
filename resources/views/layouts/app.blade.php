<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <header class="bg-green-900 text-white">
            <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="text-2xl font-bold text-green-400">🌿 PlantCare AI</div>

                <!-- Navigation Links -->
                <ul class="flex space-x-6 text-gray-700 font-medium">
                    <li><a href="{{ route('home') }}" class="hover:text-green-600 transition">Home</a></li>
                    <li><a href="{{ route('home') }}#features" class="hover:text-green-600 transition">Features</a></li>
                    <li><a href="{{ route('home') }}#about-us" class="hover:text-green-600 transition">About Us</a></li>
                    <li><a href="{{ route('home') }}#contact" class="hover:text-green-600 transition">Contact Us</a></li>
                </ul>

                <!-- Auth Section -->
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">{{ Auth::user()->name }}</span>

                    <!-- Profile Button -->
                    <a href="{{ route('profile.show') }}">
                        <button class="btn btn-primary">
                            <strong>Profile</strong>
                        </button>
                    </a>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            Logout
                        </button>
                    </form>
                    <a href="{{ route('cart.index') }}">🛒 Cart</a>
                </div>
                @else
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Register
                    </a>
                </div>
                @endauth
            </nav>
        </header>
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <footer class="bg-green-900 text-white">
            <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col sm:flex-row justify-between items-center text-center">
                <div>
                    <h4 class="text-lg font-semibold">🌿 PlantCare AI</h4>
                    <p class="text-sm">Helping farmers grow healthier plants with AI</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <ul class="flex space-x-6 text-gray-700 font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-green-600 transition">Home</a></li>
                        <li><a href="{{ route('home') }}#features" class="hover:text-green-600 transition">Features</a></li>
                        <li><a href="{{ route('home') }}#about-us" class="hover:text-green-600 transition">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact" class="hover:text-green-600 transition">Contact Us</a></li>
                    </ul>
                </div>
                <div class="mt-4 sm:mt-0 text-sm">
                    © {{ date('Y') }} PlantCare AI. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>