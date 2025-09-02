@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-4">Edit Appointment</h2>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="date">Date</label>
            <input type="date" name="date" value="{{ $appointment->date }}" required class="w-full border px-4 py-2">
        </div>

        <div class="mb-4">
            <label for="time">Time</label>
            <input type="time" name="time" value="{{ $appointment->time }}" required class="w-full border px-4 py-2">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
    </form>
    <br>
    <a href="{{ route('experts.index') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition">
            Back to Expert consultation</a>
</div>
@endsection
