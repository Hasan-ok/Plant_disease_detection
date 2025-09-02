@extends('layouts.app')

@section('title', 'Available Treatments')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">🧪 Available Treatments by Gardeners</h2>

        @if($treatments->count())
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                @foreach($treatments as $treatment)
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                        @if($treatment->image)
                            <img src="{{ asset($treatment->image) }}" alt="Treatment Image" class="w-full h-40 object-cover rounded mb-4">
                        @endif
                        <h3 class="text-xl font-semibold text-green-800">{{ $treatment->disease }}</h3>
                        <p class="text-sm text-gray-600 mt-2"><strong>Symptoms:</strong> {{ Str::limit($treatment->symptoms, 100) }}</p>
                        <p class="text-sm text-gray-600 mt-1"><strong>Care:</strong> {{ Str::limit($treatment->care, 100) }}</p>
                        <p class="text-xs text-gray-500 mt-2">Posted by: <strong>{{ $treatment->user->name }}</strong></p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $treatments->links() }}
            </div>
        @else
            <p class="text-center text-gray-500">No treatments have been added yet.</p>
        @endif
    </div>
</section>
@endsection
