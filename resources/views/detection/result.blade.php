@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Main Result Card -->
        <div class="bg-white/80 backdrop-blur-sm border border-green-200/50 rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Detection Complete</h1>
                <p class="text-green-100 text-lg">AI Analysis Results</p>
            </div>

            <!-- Results Section -->
            <div class="p-8">
                @if(session()->has('disease'))
                    <!-- Auto-save notification for logged-in users -->
                    @auth
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-blue-800 font-medium">Result automatically saved to your profile!</p>
                            </div>
                        </div>
                    @endauth

                    <!-- Disease Detection Result -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Detected Condition</h2>
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-full text-xl font-semibold inline-block shadow-lg">
                            {{ session('disease') }}
                        </div>
                    </div>

                    <!-- Suggested Treatment -->
                    <p><strong>Suggested Treatment:</strong> {{ session('treatment') }}</p>

                    @if(session()->has('confidence'))
                        <!-- Confidence Level -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-gray-700 font-medium">Confidence Level</span>
                                <span class="text-2xl font-bold text-green-600">{{ number_format(session('confidence') * 100, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                                     style="width: {{ session('confidence') * 100 }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                @if(session('confidence') >= 0.9)
                                    Very High Confidence - Results are highly reliable
                                @elseif(session('confidence') >= 0.7)
                                    High Confidence - Results are reliable
                                @elseif(session('confidence') >= 0.5)
                                    Moderate Confidence - Consider additional analysis
                                @else
                                    Low Confidence - Manual verification recommended
                                @endif
                            </p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('detection.detect') }}" 
                           class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Analyze Another Image
                        </a>

                        @auth
                            <a href="{{ route('detection.history') }}" 
                               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                View History
                            </a>
                        @else
                            <button onclick="showLoginPrompt()" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Save Result
                            </button>
                        @endauth

                        <button onclick="window.print()" 
                                class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-6 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Results
                        </button>
                    </div>

                    <!-- Login Prompt for Guest Users -->
                    @guest
                        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-amber-800 font-medium mb-1">Want to save your results?</p>
                                    <p class="text-amber-700 text-sm mb-3">Create an account to automatically save all your detection results and track your plant health over time.</p>
                                    <div class="flex gap-2">
                                        <a href="{{ route('login') }}" class="text-amber-700 hover:text-amber-800 font-medium text-sm underline">Login</a>
                                        <span class="text-amber-600">or</span>
                                        <a href="{{ route('register') }}" class="text-amber-700 hover:text-amber-800 font-medium text-sm underline">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endguest

                @else
                    <!-- No Result Available -->
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.168 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">No Results Available</h2>
                        <p class="text-gray-600 mb-6">Unable to retrieve detection results. Please try analyzing an image first.</p>
                        <a href="{{ route('detection.detect') }}" 
                           class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Start New Analysis
                        </a>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-800 font-medium">{{ $errors->first('msg') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-6 bg-white/60 backdrop-blur-sm rounded-xl p-6 border border-gray-200/50">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Important Note
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                This AI-powered detection is designed to assist in plant health monitoring. For critical decisions regarding plant treatment, 
                please consult with agricultural experts or plant pathologists for professional diagnosis and treatment recommendations.
            </p>
        </div>
    </div>
</div>

<!-- Login Prompt Modal -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Save Your Results</h3>
            <p class="text-gray-600 mb-6">Create an account to save your detection results and track your plant health history.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('login') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                    Sign Up
                </a>
            </div>
            <button onclick="closeLoginPrompt()" class="mt-4 text-gray-500 hover:text-gray-700 text-sm">
                Maybe later
            </button>
        </div>
    </div>
</div>

<script>
function showLoginPrompt() {
    document.getElementById('loginModal').classList.remove('hidden');
    document.getElementById('loginModal').classList.add('flex');
}

function closeLoginPrompt() {
    document.getElementById('loginModal').classList.add('hidden');
    document.getElementById('loginModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('loginModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLoginPrompt();
    }
});
</script>

<style>
@media print {
    .bg-gradient-to-br,
    .bg-gradient-to-r {
        background: white !important;
        -webkit-print-color-adjust: exact;
    }
    .backdrop-blur-sm {
        backdrop-filter: none;
    }
    #loginModal {
        display: none !important;
    }
}
</style>
@endsection