@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-4">My Appointments</h2>

    @if($appointments->isEmpty())
        <p>You have no appointments yet.</p>
        <a href="{{ route('experts.index') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition">
            Book Appointment</a>
    @else
        <table class="w-full table-auto border">
            <thead class="bg-green-200">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Time</th>
                    <th class="px-4 py-2">Expert</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appt)
                    <tr class="text-center border-t">
                        <td>{{ $appt->date }}</td>
                        <td>{{ $appt->time }}</td>
                        <td>{{ $appt->expert_email }}</td>
                        <td>
                            <a href="{{ route('appointments.edit', $appt->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <form action="{{ route('appointments.destroy', $appt->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <a href="{{ route('experts.index') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 transition">
            Book a new Appointment</a>
    @endif
</div>
@endsection
