@extends('layouts.app')

@section('title', 'Meet Our Experts')

@section('content')
<div class="container mx-auto py-10 px-4"
    style="background-image: url('{{ asset('images/background2.webp') }}');background-size: cover;
            background-position: center; background-repeat: no-repeat;">

    {{-- Page Title --}}
    <h2 class="text-4xl font-bold text-center text-green-800 mb-12">Meet Our Plant Disease Experts</h2>

    <form method="GET" action="{{ route('experts.index') }}" class="mb-10 max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Name Filter --}}
        <div>
            <input type="text" name="name" placeholder="Search by name"
                value="{{ request('name') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Specialty Filter --}}
        <div>
            <input type="text" name="specialty" placeholder="Search by specialty"
                value="{{ request('specialty') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                class="w-full bg-green-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Filter
            </button>
        </div>
            <a href="{{ route('experts.index') }}" class="block text-center text-sm text-gray-500 hover:underline mt-2">
            Reset Filters
            </a>

    </form>


    {{-- Expert Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 mb-16">
        @forelse ($experts as $expert)
            <div class="bg-lime-100 border border-lime-300 shadow-md rounded-xl p-6 transition hover:shadow-lg">
                <h5 class="text-xl font-bold text-lime-800 mb-2">{{ $expert->name }}</h5>
                <p><strong>Specialty:</strong> {{ $expert->specialty }}</p>
                <p><strong>Experience:</strong> {{ $expert->experience_years }} years</p>
                <p><strong>Qualification:</strong> {{ $expert->qualification }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $expert->email }}" class="text-green-700 underline">{{ $expert->email }}</a></p>
                @if($expert->phone)
                    <p><strong>Phone:</strong> <a href="tel:{{ $expert->phone }}" class="text-green-700 underline">{{ $expert->phone }}</a></p>
                @endif
                <div class="mt-4 text-right">
                    <a href="mailto:{{ $expert->email }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Contact
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center">
                <p>No experts available right now. Please check back later.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center mb-12">
        {{ $experts->links() }}
    </div>

    {{-- Booking Form --}}
<div class="max-w-2xl mx-auto p-8 bg-white shadow-xl rounded-2xl border border-gray-200 mt-10">
    <h3 class="text-3xl font-bold text-green-800 mb-6 text-center">Book Your Appointment</h3>

    <form action="{{ route('appointments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" id="name"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                value="{{ auth()->user()->name ?? '' }}" required>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                value="{{ auth()->user()->email ?? '' }}" required>
        </div>

        {{-- Expert Selection --}}
        <div>
            <label for="expert_name" class="block text-sm font-semibold text-gray-700 mb-1">Choose an Expert</label>
            <select name="expert_id" id="expert_id"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none" required>
                <option value="">-- Select Expert --</option>
                @foreach($experts as $expert)
                    <option value="{{ $expert->id }}">
                        {{ $expert->name }} ({{ $expert->specialty }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date Picker --}}
        <div>
            <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Preferred Date</label>
            <input type="date" name="date" id="date"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                required>
        </div>

        {{-- Time Slot --}}
        <div>
            <label for="time" class="block text-sm font-semibold text-gray-700 mb-1">Preferred Time Slot</label>
            <select name="time" id="time"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none" required>
                <option value="">-- Select a time slot --</option>
                @php
                    $start = \Carbon\Carbon::createFromTime(9, 0);
                    $end = \Carbon\Carbon::createFromTime(17, 0);
                @endphp
                @while ($start < $end)
                    <option value="{{ $start->format('H:i') }}">
                        {{ $start->format('h:i A') }}
                    </option>
                    @php $start->addMinutes(30); @endphp
                @endwhile
            </select>
        </div>

        {{-- Type of Tree --}}
        <div>
            <label for="tree_type" class="block text-sm font-semibold text-gray-700 mb-1">Type of Tree</label>
            <input type="text" name="tree_type" id="tree_type"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                placeholder="e.g., Olive, Apple, Lemon" required>
        </div>

        {{-- Observed Issue --}}
        <div>
            <label for="issue" class="block text-sm font-semibold text-gray-700 mb-1">Observed Issue</label>
            <input type="text" name="issue" id="issue"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                placeholder="e.g., yellowing leaves, white spots..." required>
        </div>

        {{-- Suspected Disease --}}
        <div>
            <label for="disease" class="block text-sm font-semibold text-gray-700 mb-1">Suspected Disease</label>
            <input type="text" name="disease" id="disease"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                placeholder="(Optional)">
        </div>

        {{-- Suggested Treatment --}}
        <div>
            <label for="user_treatment" class="block text-sm font-semibold text-gray-700 mb-1">Suggested Treatment (Optional)</label>
            <textarea name="user_treatment" id="user_treatment"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                placeholder="e.g., neem oil, pruning, more watering..."></textarea>
        </div>

        {{-- Upload Tree Image --}}
        <div>
            <label for="tree_image" class="block text-sm font-semibold text-gray-700 mb-1">Upload Tree Image (Optional)</label>
            <input type="file" name="tree_image" id="tree_image"
                accept="image/*"
                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Submit --}}
        <div class="text-center">
            <button type="submit"
                class="w-full bg-green-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                BOOK APPOINTMENT
            </button>
        </div>

        {{-- Success/Error --}}
        @if(session('success'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
    </form>
</div>


    <a href="{{ route('appointments.index') }}" 
       class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
       My Appointments
    </a>
</div>
@endsection
