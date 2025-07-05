@extends('layouts.app')

@section('content')

<!-- welcome section -->
<section id="home">
    <div class="bg-green-50 min-h-screen flex flex-col justify-center items-center px-4 py-16">
        <div class="text-center max-w-3xl">
            <h1 class="text-5xl font-extrabold text-green-800 leading-tight mb-4">
                Welcome to <span class="text-green-600">PlantCare AI</span> 🌿
            </h1>
            <p class="text-lg text-gray-700 mb-8">
                Diagnose plant diseases instantly with AI. Get treatments, consult experts, and join a growing farming community.
            </p>

            <!-- <div class="flex flex-col sm:flex-row justify-center gap-4 mb-10">
                <a href="{{ route('detection.upload') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-semibold shadow-md transition">
                    🩺 Detect Disease
                </a>
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow-md transition">
                    👩‍⚕️ Contact an Expert
                </a>
            </div> -->
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-green-800 mb-12">Key Features</h2>
        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-2">

            <!-- Feature 1: AI Detection -->
            <a href="{{ route('detection.upload') }}" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-lg hover:bg-green-50 transition transform hover:-translate-y-1">
                <div class="text-green-600 text-5xl mb-4">🩺</div>
                <h3 class="text-xl font-semibold text-green-800 mb-6">AI Disease Detection</h3>
                <p class="text-gray-600">
                    Instantly identify plant diseases using advanced AI models and get actionable treatment steps.
                </p>
            </a>

            <!-- Feature 2: Expert Consultation -->
            <a href="{{ route('experts.index')}}" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-lg hover:bg-green-50 transition transform hover:-translate-y-1">
                <div class="text-blue-600 text-5xl mb-4">👨‍⚕️</div>
                <h3 class="text-xl font-semibold text-green-800 mb-6">Expert Consultation</h3>
                <p class="text-gray-600">
                    Connect with agricultural experts for personalized advice and support for your plant health.
                </p>
            </a>

            <!-- Feature 3: Products -->
            <a href="{{ route('products.index') }}" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-lg hover:bg-green-50 transition transform hover:-translate-y-1">
                <div class="text-yellow-500 text-5xl mb-4">🌱</div>
                <h3 class="text-xl font-semibold text-green-800 mb-6">View Products</h3>
                <p class="text-gray-600">
                    View available pesticides, vitamins, and medications for your plants.
                </p>
            </a>

            <!-- Feature 4: Treatments -->
             <a href="{{ route('treatments.index') }}" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-lg hover:bg-green-50 transition transform hover:-translate-y-1">
                <div class="text-yellow-500 text-5xl mb-4">🌱</div>
                <h3 class="text-xl font-semibold text-green-800 mb-6">View Treatments</h3>
                <p class="text-gray-600">
                    View different treatments suggested by Gardeners.
                </p>
            </a>
        </div>
    </div>
</section>

<!-- Available plants section -->
<section id="plants" class="py-20 bg-white dark:bg-gray-900" id="plants">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-green-700 dark:text-green-400 mb-4">🪴 Supported Plants & Trees</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-12">We currently support disease detection for the following crops:</p>

        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ([
                ['name' => 'Apple', 'img' => 'apple.jpeg', 'note' => 'Common in cool climates'],
                ['name' => 'Tomato', 'img' => 'tomato.jpeg', 'note' => 'Often affected by blight'],
                ['name' => 'Corn', 'img' => 'corn.jpeg', 'note' => 'Susceptible to leaf spot'],
                ['name' => 'Grape', 'img' => 'grape.jpeg', 'note' => 'Watch for powdery mildew'],
                ['name' => 'Peach', 'img' => 'peach.jpeg', 'note' => 'Fungal infections are common'],
                ['name' => 'Potato', 'img' => 'potato.jpeg', 'note' => 'Look out for late blight'],
                ['name' => 'Strawberry', 'img' => 'strawberry.jpeg', 'note' => 'Sensitive to moisture'],
            ] as $plant)
                <div class="bg-white/90 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 hover:scale-105">
                    <img src="{{ asset('images/plants/' . $plant['img']) }}" alt="{{ $plant['name'] }}" class="w-24 h-24 mx-auto mb-4 object-contain rounded-full shadow-md border border-green-200">
                    <h3 class="text-xl font-semibold text-green-800 dark:text-green-200 mb-2">{{ $plant['name'] }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $plant['note'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- About Us Section -->
<section id="about-us" class="bg-green-50 px-4 py-16">
    <div class="max-w-5xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-green-800 mb-6">About Us</h2>
        <p class="text-lg text-gray-700 leading-relaxed mb-6">
            At <strong>PlantCare AI</strong>, we use artificial intelligence to help detect plant diseases quickly and accurately.
            Whether you’re a farmer, gardener, or plant enthusiast, we aim to support your journey toward healthier plants.
        </p>
        <p class="text-lg text-gray-700 leading-relaxed">
            Our platform provides disease detection, expert advice, treatment suggestions, and a community for sharing knowledge.
            Together, we’re building a smarter, greener future. 🌱
        </p>
    </div>
</section>

<!-- contact us section -->
<section id="contact">
    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 max-w-2xl mx-auto text-left">
    @csrf

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <label for="name" class="block font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" required class="w-full border px-4 py-2 rounded" value="{{ old('name') }}">
        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required class="w-full border px-4 py-2 rounded" value="{{ old('email') }}">
        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="message" class="block font-medium text-gray-700">Message</label>
        <textarea id="message" name="message" rows="4" required class="w-full border px-4 py-2 rounded">{{ old('message') }}</textarea>
        @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
        📩 Send Message
    </button>
    <br><br>
    </form>
</section>

@endsection