@extends('layouts.gardener')

@section('title', 'Manage Treatments')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Treatments</h2>
        <a href="{{ route('gardener.treatments.create') }}" class="btn btn-primary">Add New Treatment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($treatments->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Disease</th>
                    <th>Name</th>
                    <th>Symptom</th>
                    <th>Care</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($treatments as $treatment)
                    <tr>
                        <td>{{ $treatment->disease }}</td>
                        <td>{{ $treatment->name }}</td>
                        <td>{{ Str::limit($treatment->symptoms, 40) }}</td>
                        <td>{{ Str::limit($treatment->care, 40) }}</td>
                        <td>
                            @if($treatment->image)
                                <img src="{{ asset('storage/' . $treatment->image) }}" alt="{{ $treatment->name }}" width="60" />
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('gardener.treatments.show', $treatment) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('gardener.treatments.edit', $treatment) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('gardener.treatments.destroy', $treatment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this treatment?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $treatments->links() }}
        </div>
    @else
        <p>No treatments found.</p>
    @endif
</div>
@endsection
