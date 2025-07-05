@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-green-700">👤 Your Profile</h2>
        <div class="space-x-2">
            <a href="{{ route('home') }}">
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ⬅ Back to Home Page
                </button>
            </a>
            <a href="{{ route('profile.show.edit') }}">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Edit Profile
                </button>
            </a>
        </div>
    </div>

    <div class="space-y-4 text-lg text-gray-800">
        <p><span class="font-semibold">Name:</span> {{ $user->name }}</p>
        <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
        <p><span class="font-semibold">Joined On:</span> {{ $user->created_at->format('F d, Y') }}</p>
        <p><span class="font-semibold">Last Update:</span> {{ $user->updated_at->diffForHumans() }}</p>
        <a href="{{ route('appointments.index') }}" 
           class="inline-block bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition">
           My Appointments
        </a>
    </div>
    <br>
    <a href="{{ route('detection.history') }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>View History
    </a>
</div>
@endsection
